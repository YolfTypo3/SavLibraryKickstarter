{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<?php
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">

$temporaryColumns = [
    <f:for each="{table.fields}" as="field">
    <sav:removeIfContainsDoNotCreate>
    '{sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}' => [
        'exclude' => 1,
        'label'  => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}',
        <sav:indent count="8"><f:render partial="Partials/TCA/{field.type}.phpt" arguments="{field:field, model:'{model}_{sav:buildTableName(shortName:0, extensionKey:extension.general.1.extensionKey)}', extension:extension}" /></sav:indent>
    ],
    </sav:removeIfContainsDoNotCreate>
    </f:for>
];
!
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('{model}', $temporaryColumns);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('{model}','<f:for each="{table.fields}" as="field"><f:if condition="{field.type} != 'ShowOnly'">, {sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}<f:if condition="{field.type} == 'RichTextEditor'">;;;richtext[]:rte_transform[mode=ts]</f:if></f:if></f:for>');

</sav:function></f:format.raw>
?>