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
    'version' => '0.9.5',
    'dependencies' => 'hdnet',
    'state' => 'stable',
    'author' => 'HDNET GmbH & Co. KG',
    'author_email' => '',
    'author_company' => 'hdnet.de',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-8.1.999',
            'typo3' => '10.4.0-11.5.999',
        ],
    ],
];
