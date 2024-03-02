<?php

use WapplerSystems\Avif\Core\Filter\FileNameFilter;
use WapplerSystems\Avif\Service\Configuration;

defined('TYPO3') || exit;

(static function () {
    if (Configuration::get('hide_avif')) {
        // Hide avif files in file lists
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['fal']['defaultFilterCallbacks'][] = [
            FileNameFilter::class,
            'filterAvifFiles',
        ];
    }
})();
