<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Overrides;

use TYPO3\CMS\Core\Error\Http\ShortcutTargetPageNotFoundException;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;

class PageRepository extends \TYPO3\CMS\Frontend\Page\PageRepository
{
    public function getPageShortcut($shortcutFieldValue, $shortcutMode, $thisUid, $iteration = 20, $pageLog = [], $disableGroupCheck = false)
    {
        if (MathUtility::canBeInterpretedAsInteger($shortcutFieldValue)) {
            return parent::getPageShortcut($shortcutFieldValue, $shortcutMode, $thisUid, $iteration, $pageLog, $disableGroupCheck);
        }
        // ---- CHANGE int to trim!!!
        $idArray = GeneralUtility::trimExplode(',', $shortcutFieldValue);
        // Find $page record depending on shortcut mode:
        switch ($shortcutMode) {
            case self::SHORTCUT_MODE_FIRST_SUBPAGE:
            case self::SHORTCUT_MODE_RANDOM_SUBPAGE:
                $pageArray = $this->getMenu($idArray[0] ?: $thisUid, '*', 'sorting', 'AND pages.doktype<199 AND pages.doktype!='.self::DOKTYPE_BE_USER_SECTION);
                $pO = 0;
                if (self::SHORTCUT_MODE_RANDOM_SUBPAGE === $shortcutMode && !empty($pageArray)) {
                    $pO = (int) random_int(0, \count($pageArray) - 1);
                }
                $c = 0;
                $page = [];
                foreach ($pageArray as $pV) {
                    if ($c === $pO) {
                        $page = $pV;

                        break;
                    }
                    ++$c;
                }
                if (empty($page)) {
                    $message = 'This page (ID '.$thisUid.') is of type "Shortcut" and configured to redirect to a subpage. However, this page has no accessible subpages.';

                    throw new ShortcutTargetPageNotFoundException($message, 1301648328);
                }

                break;
            case self::SHORTCUT_MODE_PARENT_PAGE:
                $parent = $this->getPage($idArray[0] ?: $thisUid, $disableGroupCheck);
                $page = $this->getPage($parent['pid'], $disableGroupCheck);
                if (empty($page)) {
                    $message = 'This page (ID '.$thisUid.') is of type "Shortcut" and configured to redirect to its parent page. However, the parent page is not accessible.';

                    throw new ShortcutTargetPageNotFoundException($message, 1301648358);
                }

                break;
            default:
                $page = $this->getPage($idArray[0], $disableGroupCheck);
                if (empty($page)) {
                    $message = 'This page (ID '.$thisUid.') is of type "Shortcut" and configured to redirect to a page, which is not accessible (ID '.$idArray[0].').';

                    throw new ShortcutTargetPageNotFoundException($message, 1301648404);
                }
        }
        // Check if short cut page was a shortcut itself, if so look up recursively:
        if (self::DOKTYPE_SHORTCUT === $page['doktype']) {
            if (!\in_array($page['uid'], $pageLog, true) && $iteration > 0) {
                $pageLog[] = $page['uid'];
                $page = $this->getPageShortcut($page['shortcut'], $page['shortcut_mode'], $page['uid'], $iteration - 1, $pageLog, $disableGroupCheck);
            } else {
                $pageLog[] = $page['uid'];
                $message = 'Page shortcuts were looping in uids '.implode(',', $pageLog).'...!';
                $this->logger->error($message);

                throw new \RuntimeException($message, 1294587212);
            }
        }

        $page['uid'] = 'shortcut://'.$shortcutFieldValue;
        // Return resulting page:
        return $page;
    }
}
