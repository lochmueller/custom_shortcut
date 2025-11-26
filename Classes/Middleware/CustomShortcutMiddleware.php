<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Middleware;

use HDNET\CustomShortcut\Utility\HelperUtility;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class CustomShortcutMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var \TYPO3\CMS\Core\Routing\PageArguments $pageArguments */
        $pageArguments = $request->getAttribute('routing');
        $pageRecord = $this->getPageInformation($pageArguments->getPageId());

        // No page found: SKIP
        if ($pageRecord === null) {
            return $handler->handle($request);
        }

        // No shortcut page: SKIP
        if (PageRepository::DOKTYPE_SHORTCUT !== (int) $pageRecord['doktype']) {
            return $handler->handle($request);
        }

        $config = HelperUtility::getTableRecordConfiguration($pageRecord['shortcut']);

        // no shortcut configuration found: SKIP
        if (null === $config) {
            return $handler->handle($request);
        }

        $handler = HelperUtility::getShortcutHandler($config);
        $uri = $handler->resolveUrl($pageRecord['shortcut'], GeneralUtility::makeInstance(ContentObjectRenderer::class));

        return new RedirectResponse($uri, 307);
    }

    protected function getPageInformation(int $pageUid): ?array
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll();

        $versionGreaterEquals13 = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger(\TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()) >= \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionNumberToInteger('13.0');
        if($versionGreaterEquals13) {
            $queryBuilder
                ->select('doktype', 'shortcut')
                ->from('pages')
                ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int) $pageUid, \TYPO3\CMS\Core\Database\Connection::PARAM_INT)));

            $row = $queryBuilder->fetchAssociative();
        } else {
            $queryBuilder
                ->select('doktype', 'shortcut')
                ->from('pages')
                ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter((int) $pageUid, \PDO::PARAM_INT)));

            $row = $queryBuilder->execute()->fetch();
        }

        return is_array($row) ? $row : null;
    }
}
