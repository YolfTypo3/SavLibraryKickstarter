<?php
if (! defined('TYPO3_MODE')) {
    die('Access denied.');
}

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

// Context sensitive tags
$contextSensitiveHelpFiles = [
    // Tags for the SAV Library Kickstarter sections
    'emconf' => 'locallang_csh_emconf',
    'views' => 'locallang_csh_views',
    'queries' => 'locallang_csh_queries',
    'forms' => 'locallang_csh_forms',
    // Tags for the field types
    'all' => 'Types/locallang_csh_all',
    'checkbox' => 'Types/locallang_csh_checkbox',
    'checkboxes' => 'Types/locallang_csh_checkboxes',
    'date' => 'Types/locallang_csh_date',
    'dateTime' => 'Types/locallang_csh_dateTime',
    'files' => 'Types/locallang_csh_files',
    'functions' => 'Types/locallang_csh_functions',
    'graph' => 'Types/locallang_csh_graph',
    'general' => 'Types/locallang_csh_general',
    'integer' => 'Types/locallang_csh_integer',
    'link' => 'Types/locallang_csh_link',
    'radioButtons' => 'Types/locallang_csh_radioButtons',
    'relationManyToManyAsDoubleSelectorbox' => 'Types/locallang_csh_relationManyToManyAsDoubleSelectorbox',
    'relationManyToManyAsSubform' => 'Types/locallang_csh_relationManyToManyAsSubform',
    'relationOneToManyAsSelectorbox' => 'Types/locallang_csh_relationOneToManyAsSelectorbox',
    'richTextEditor' => 'Types/locallang_csh_richTextEditor',
    'selectorbox' => 'Types/locallang_csh_selectorbox',
    'showOnly' => 'Types/locallang_csh_showOnly',
    'string' => 'Types/locallang_csh_string',
    'text' => 'Types/locallang_csh_text'
];

// Registers Backend Module
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'YolfTypo3.' . $_EXTKEY,
    'tools',
    'mod',
    '',
    $controllerActions,
    [
        'access' => 'admin',
        'icon' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/Extension.svg',
        'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf'
    ]
);

// Sets the Context Sensitive Help
foreach ($contextSensitiveHelpFiles as $contextSensitiveHelpFileKey => $contextSensitiveHelpFile) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_' . $contextSensitiveHelpFileKey, 'EXT:' . $_EXTKEY . '/Resources/Private/Language/ContextSensitiveHelp/' . $contextSensitiveHelpFile . '.xlf');
}

// Default TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'SAV Library Kickstarter');

?>
