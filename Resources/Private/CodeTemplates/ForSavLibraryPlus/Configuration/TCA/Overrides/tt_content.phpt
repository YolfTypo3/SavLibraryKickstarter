<f:format.raw><sav:utility.removeEmptyLines keepLine="!">
<?php
defined('TYPO3') or die();
!
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['{extension.general.1.extensionKey}_pi1'] = 'layout,select_key';
!
// Adds the flexform field to plugin option
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['{extension.general.1.extensionKey}_pi1'] = 'pi_flexform';
!
// Adds the flexform DataStructure
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '{extension.general.1.extensionKey}_pi1',
    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml'
);
!
// Adds the plugin
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
        '{extension.general.1.extensionKey}_pi1',
    ],
    'list_type',
    '{extension.general.1.extensionKey}'
);
!
// Adds addToInsertRecords() if any
<f:for each="{extension.newTables}" as="table">
<f:alias map="{
  model: '{sav:builder.tableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey)}'
}">
<f:if condition="{table.allow_ce_insert_records}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToInsertRecords('{model}');
</f:if>
</f:alias>
</f:for>
</sav:utility.removeEmptyLines></f:format.raw>
