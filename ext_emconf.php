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
    'version' => '0.9.4',
    'dependencies' => 'hdnet',
    'state' => 'stable',
    'author' => 'HDNET GmbH & Co. KG',
    'author_email' => '',
    'author_company' => 'hdnet.de',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.999',
        ],
    ],
];
