<f:format.raw><sav:utility.removeEmptyLines keepLine="!">
<?php
defined('TYPO3') or die();
!
<f:alias map="{
    pluginSignature:  '{extension.general.1.extensionKey->sav:format.upperCamel()->sav:format.toLower()}_{extension.general.1.pluginName->sav:format.upperCamel()->sav:format.toLower()}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['{pluginSignature}'] = 'layout,select_key';

// Adds the flexform field to plugin option
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['{pluginSignature}'] = 'pi_flexform';
!
// Adds the flexform DataStructure
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '{pluginSignature}',
    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml'
);
!
// Registers the Plugin to be listed in the Backend.
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    '{extensionName}',
    '{extension.general.1.pluginName}',
    'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1'
);
</f:alias>
!
// Adds addToInsertRecords() if any
<f:for each="{extension.newTables}" as="table">
<f:alias map="{
  model: '{sav:builder.tableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc: true)}'
}">
<f:if condition="{table.allow_ce_insert_records}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('{model}');
</f:if>
</f:alias>
</f:for>
</sav:utility.removeEmptyLines></f:format.raw>
