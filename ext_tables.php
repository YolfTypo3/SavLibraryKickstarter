<?php
defined('TYPO3') or die();

(function () {
    // Controller actions
    $controllerActions = '
		extensionList,
        generateLocalDocumentationWithDockerCompose,
		selectExtensionVersion,
        changeExtensionVersion,
        createExtension,
        copyExtension,
        editExtension,
        installExtension,
        uninstallExtension,
        downloadExtension,
        generateExtension,
        upgradeExtension,
        upgradeExtensions,
        addItem,
        deleteItem,
        editItem,
        emconfEditSection,
        documentationEditSection,
        newTablesEditSection,
        existingTablesEditSection,
        existingTablesImportFields,
        generalEditSection,
        viewsEditSection,
        queriesEditSection,
        formsEditSection,
        save,
        changeView,
        changeFolder,
        showAllFields,
        showFieldsNotInFolders,
        changeConfigurationView,
        editFieldConfiguration,
        addNewField,
        moveUpField,
        moveDownField,
        deleteField,
        addNewViewWithCondition,
        deleteViewWithCondition,
        addNewFolder,
        moveUpFolder,
        moveDownFolder,
        deleteFolder,
        addNewWhereTag,
        deleteWhereTag,
        addNewBoxItem,
        deleteBoxItem,
        generateCode,
        ';

    // Registers Backend Module
    $typo3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
    if (version_compare($typo3Version->getVersion(), '10.0', '<')) {
        // @extensionScannerIgnoreLine
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'YolfTypo3.sav_library_kickstarter',
            'tools',
            'mod',
            '',
            [
                'Kickstarter' => $controllerActions
            ],
            [
                'access' => 'admin',
                'icon' => 'EXT:sav_library_kickstarter/Resources/Public/Icons/Extension.svg',
                'labels' => 'LLL:EXT:sav_library_kickstarter/Resources/Private/Language/locallang_mod.xlf'
            ]
        );
    } else {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
            'SavLibraryKickstarter',
            'tools',
            'mod',
            '',
            [
                \YolfTypo3\SavLibraryKickstarter\Controller\KickstarterController::class => $controllerActions
            ],
            [
                'access' => 'admin',
                'icon' => 'EXT:sav_library_kickstarter/Resources/Public/Icons/Extension.svg',
                'labels' => 'LLL:EXT:sav_library_kickstarter/Resources/Private/Language/locallang_mod.xlf'
            ]
        );
    }
})();