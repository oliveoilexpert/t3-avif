<?php

$EM_CONF['ws_avif'] = [
    'title' => 'Creates Avif copies for images',
    'description' => 'Creates Avif copies of all jpeg and png images',
    'category' => 'fe',
    'author' => 'Sven Wappler',
    'author_email' => 'typo3@wappler.systems',
    'state' => 'stable',
    'author_company' => 'WapplerSystems',
    'version' => '12.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.9.99',
        ],
    ],
];
