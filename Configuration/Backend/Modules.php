<?php
use YolfTypo3\SavLibraryKickstarter\Controller\KickstarterController;

/**
 * Definitions for modules provided by EXT:sav_library_kickstarter
 */
return [
    'SavLibraryKickstarter' => [
        'parent' => 'tools',
        'access' => 'systemMaintainer',
        'labels' => 'LLL:EXT:sav_library_kickstarter/Resources/Private/Language/locallang_mod.xlf',
        'extensionName' => 'SavLibraryKickstarter',
        'controllerActions' => [
            KickstarterController::class => [
                'extensionList', // Default
                'addItem',
                'addNewBoxItem',
                'addNewField',
                'addNewFolder',
                'addNewViewWithCondition',
                'addNewWhereTag',
                'changeConfigurationView',
                'changeExtensionVersion',
                'createExtension',
                'changeFolder',
                'changeView',
                'deleteBoxItem',
                'deleteField',
                'deleteFolder',
                'deleteItem',
                'deleteViewWithCondition',
                'deleteWhereTag',
                'documentationEditSection',
                'editExtension',
                'editFieldConfiguration',
                'editItem',
                'emconfEditSection',
                'existingTablesEditSection',
                'existingTablesImportFields',                
                'formsEditSection',               
                'generalEditSection',
                'generateCode',
                'generateExtension',
                'moveDownField',
                'moveDownFolder',
                'moveUpField',
                'moveUpFolder',
                'newTablesEditSection',
                'queriesEditSection',
                'save',
                'selectExtensionVersion',
                'showAllFields',
                'showFieldsNotInFolders',
                'upgradeExtension',
                'upgradeExtensions',
                'viewsEditSection',
            ],
        ],
    ]
];
