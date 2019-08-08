<?php
defined('TYPO3_MODE') or die();

if (TYPO3_MODE === 'BE') {
    // Controller actions
    $controllerActions = [
        'Kickstarter' => '
		extensionList,
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
  '
    ];

    // Registers Backend Module
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule('YolfTypo3.sav_library_kickstarter', 'tools', 'mod', '', $controllerActions, [
        'access' => 'admin',
        'icon' => 'EXT:sav_library_kickstarter/Resources/Public/Icons/Extension.svg',
        'labels' => 'LLL:EXT:sav_library_kickstarter/Resources/Private/Language/locallang_mod.xlf'
    ]);
}
?>
