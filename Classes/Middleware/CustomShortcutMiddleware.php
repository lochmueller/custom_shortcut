<?php

declare(strict_types=1);

namespace HDNET\CustomShortcut\Middleware;

use HDNET\CustomShortcut\Utility\HelperUtility;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class CustomShortcutMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var \TYPO3\CMS\Core\Routing\PageArguments $ageArguments */
        $ageArguments = $request->getAttribute('routing');
        $pageRecord = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('pages', (int) $ageArguments->getPageId());
        if (!isset($pageRecord['doktype']) || PageRepository::DOKTYPE_SHORTCUT !== $pageRecord['doktype']) {
            return $handler->handle($request);
        }

        $config = HelperUtility::getTableRecordConfiguration($pageRecord['shortcut']);
        if (null === $config) {
            return $handler->handle($request);
        }

        $handler = HelperUtility::getShortcutHandler($config);
        $uri = $handler->resolveUrl($pageRecord['shortcut'], GeneralUtility::makeInstance(ContentObjectRenderer::class));

        return new RedirectResponse($uri, 307);
    }
}
