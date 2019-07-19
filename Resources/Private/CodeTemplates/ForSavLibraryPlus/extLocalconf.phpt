<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:function(name:\'removeUnderscore\')}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
}">
defined('TYPO3_MODE') or die();
!
<f:for each="{extension.newTables}" as="newTable">
<f:alias map="{
    model: '{sav:buildTableName(shortName:newTable.tablename, extensionKey:extension.general.1.extensionKey)}'
}">
<f:if condition="{newTable.save_and_new}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('
    options.saveDocNew.{model}=1
');
</f:if>
</f:alias>
</f:for>
!
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
    '{extension.general.1.extensionKey}',
    'Classes/Controller/{extensionName}Controller.php',
    '_pi1',
    'list_type',
    1
);
!
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup('
plugin.tx_{extensionNameWithoutUnderscore}_pi1.userFunc = {vendorName}\{extensionName}\Controller\{extensionName}Controller->main
'
);

</f:alias>
</sav:function>
?>
