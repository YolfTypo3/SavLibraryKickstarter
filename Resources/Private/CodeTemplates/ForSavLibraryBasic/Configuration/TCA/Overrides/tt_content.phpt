{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<?php
defined('TYPO3_MODE') or die();
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    pluginSignature:  '{extension.general.1.extensionKey->sav:upperCamel()->sav:toLower()}_{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()->sav:toLower()}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
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
    '{extension.general.1.extensionKey}',
	'{controllerName}',
	'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1'
);
</f:alias>
!
// Adds addToInsertRecords() if any
<f:for each="{extension.newTables}" as="table">
<f:alias map="{
  model: '{sav:buildTableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc: true)}'
}">
<f:if condition="{table.allow_ce_insert_records}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('{model}');
</f:if>
</f:alias>
</f:for>
</sav:function></f:format.raw>
?>
