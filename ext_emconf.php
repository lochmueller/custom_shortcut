<?php
/**
 * $EM_CONF
 *
 * @package    Hdnet
 * @author     Tim Lochmüller <tim.lochmueller@hdnet.de>
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Custom shortcut',
    'description' => 'Add custom shortcut types to the page properties.',
    'category' => 'misc',
    'version' => '2.0.0',
    'dependencies' => 'hdnet',
    'state' => 'stable',
    'author' => 'HDNET GmbH & Co. KG',
    'author_email' => '',
    'author_company' => 'hdnet.de',
    'constraints' => [
        'depends' => [
            'php' => '8.2.0-8.2.999',
            'typo3' => '11.5.0-12.4.999',
        ],
    ],
    'autoload' => [
        'psr-4' => [
            'HDNET\\CustomShortcut\\' => 'Classes/',
        ],
    ],
];
