<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

<f:for each="{extension.newTables}" as="table">
<f:alias map="{
  model: '{sav:buildTableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey)}'
}">

<f:if condition="{table.allow_on_pages}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('{model}');
!
</f:if>

<f:if condition="{table.allow_ce_insert_records}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('{model}');
!
</f:if>
</f:alias>
</f:for>

$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi1'] = 'layout,select_key';
!
// Adds flexform field to plugin option
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';
!
// Adds flexform DataStructure
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $_EXTKEY . '_pi1',
    'FILE:EXT:' . $_EXTKEY . '/Configuration/Flexforms/ExtensionFlexform.xml'
);
!
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array (
        'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
        $_EXTKEY . '_pi1',
    ),
    'list_type'
);

</sav:function>
?>
