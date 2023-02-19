<?php
defined('TYPO3') or die();

(function () {
    // Register actions-duplicate icon for TYPO3 9.x
    // @todo Will be removed in TYPO3 12
    if (version_compare(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getVersion(), '10.0', '<')) {
        // Registers the icon
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        $iconRegistry->registerIcon('actions-bolt', \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class, [
            'source' => 'EXT:sav_library_kickstarter/Resources/Public/Icons/actions-bolt.svg'
        ]);
    }

    $GLOBALS['TYPO3_CONF_VARS']['LOG']['YolfTypo3']['SavLibraryKickstarter']['writerConfiguration'] = [
        \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
            \TYPO3\CMS\Core\Log\Writer\FileWriter::class => [
                'logFile' => \TYPO3\CMS\Core\Core\Environment::getVarPath() . '/logs/SavLibraryKickstarter.log'
            ],
        ],
    ];

})();