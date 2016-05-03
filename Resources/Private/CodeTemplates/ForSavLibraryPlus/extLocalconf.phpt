<?php
<sav:function name="removeEmptyLines">
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

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

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPItoST43(
    $_EXTKEY,
    'Classes/Controller/{sav:function(name:"upperCamel", arguments:"{extension.general.1.extensionKey}")}Controller.php',
    '_pi1',
    'list_type',
    1
);

</sav:function>
?>
