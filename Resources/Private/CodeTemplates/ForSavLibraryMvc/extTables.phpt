<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:for each="{extension.newTables}" as="table" key="tableKey">
<f:alias map="{
  model: '{sav:buildTableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:1)}'
}">

<f:if condition="{table.allow_on_pages}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('{model}');
</f:if>

<f:if condition="{table.allow_ce_insert_records}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('{model}');
</f:if>

</f:alias>
</f:for>

<f:for each="{extension.existingTables}" as="table">
<f:alias map="{
    model: '{table.tablename}'
}">

$tempColumns = array (
	<f:for each="{table.fields}" as="field">
	<sav:removeIfContainsDoNotCreate>
	'{sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}' => array (
		'exclude' => 1,
		'label'  => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xml:{model}.{sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}',
		'config' => array (
            <sav:indent count="12"><f:render partial="Partials/TCA/{field.type}.phpt" arguments="{field:field,model:'{model}_{sav:buildTableName(shortName:0, extensionKey:extension.general.1.extensionKey)}',extensionKey:extension.general.1.extensionKey}" /></sav:indent>
		)
	),
	</sav:removeIfContainsDoNotCreate>
	</f:for>
);
!
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('{model}',$tempColumns,1);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('{model}',';;;;1-1-1<f:alias map="{RichTextEditor:'RichTextEditor',ShowOnly:'ShowOnly'}"><f:for each="{table.fields}" as="field"><f:if condition="{field.type} != {ShowOnly}">, {sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}<f:if condition="{field.type} == {RichTextEditor}">;;;richtext[]:rte_transform[mode=ts]</f:if></f:if></f:for></f:alias>');

</f:alias>
</f:for>

$extensionName = \TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';
!
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key';
!
// Adds the flexform field to plugin option
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
!
// Adds the flexform DataStructure
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/ExtensionFlexForm.xml');
!
// Registers the Plugin to be listed in the Backend.
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
	'Pi1',
	'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1'
);

<f:if condition="{extension.general.1.addWizardPluginIcon}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
}">
!
// Adds a wizard plugin icon
if (TYPO3_MODE === 'BE') {
    $GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['{vendorName}\\{extensionName}\\Controller\\WizardIcon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Classes/Controller/WizardIcon.php';
}
</f:alias>
</f:if>
!
// Default TypoScript
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', '{extension.general.1.pluginTitle->sav:function(name:'stringToUtf8')}');

</sav:function>
?>
