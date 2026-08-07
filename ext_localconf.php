<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

defined('TYPO3') or die();

(function () {

    // Add default TypoScript
    ExtensionManagementUtility::addTypoScriptConstants(
        "@import 'EXT:sav_library_kickstarter/Configuration/TypoScript/constants.typoscript'",
        false
        );
    ExtensionManagementUtility::addTypoScriptSetup(
        "@import 'EXT:sav_library_kickstarter/Configuration/TypoScript/setup.typoscript'",
        false
        );
    
    $GLOBALS['TYPO3_CONF_VARS']['LOG']['YolfTypo3']['SavLibraryKickstarter']['writerConfiguration'] = [
        \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
            \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                'logFile' => \TYPO3\CMS\Core\Core\Environment::getVarPath() . '/logs/SavLibraryKickstarter.log'
            ],
        ],
    ];

})();