{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<?php
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:variable name="tableType" value="existing" />

$temporaryColumns = [
    <f:for each="{table.fields}" as="field">
    <f:if condition="{field.type} != 'ShowOnly'">
    '{sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}' => [
        'exclude' => 1,
        'label'  => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}',
        <sav:indent count="8"><f:render partial="Partials/TCA/{field.type}.phpt" arguments="{field:field, model:'{model}_{sav:buildTableName(shortName:0, extensionKey:extension.general.1.extensionKey)}', extension:extension}" /></sav:indent>
    ],
    </f:if>
    </f:for>
];
!
<f:comment>Generates an EXT if the librarytype is sav_Library_mvc</f:comment>
<f:if condition="{extension.general.1.libraryType} == 2">
$GLOBALS['TCA']['{model}']['ctrl'] = array_merge($GLOBALS['TCA']['{model}']['ctrl'], [
<sav:indent count="4"><f:render partial="Configuration/TCA/extSection.phpt" arguments="{_all}" /></sav:indent>
]);
</f:if>
!
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('{model}', $temporaryColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('{model}','<f:for each="{table.fields}" as="field"><f:if condition="{field.type} != 'ShowOnly'">, {sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}<f:if condition="{field.type} == 'RichTextEditor'">;;;richtext[]:rte_transform[mode=ts]</f:if></f:if></f:for>');

</sav:function></f:format.raw>
