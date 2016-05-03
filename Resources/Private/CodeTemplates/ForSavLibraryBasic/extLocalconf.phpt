<?php
<sav:function name="removeEmptyLines">
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

<f:for each="{extension.newTables}" as="table">
<f:if condition="{table.save_and_new}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('options.saveDocNew.{table.tablename}=1');
</f:if>
</f:for>

// Configures the Dispatcher
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    '{extension.general.1.vendorName}.' . $_EXTKEY,
    '{extension.forms->sav:getItem()->sav:getItem(key:'title')}',
    array (
        '{extension.forms->sav:getItem()->sav:getItem(key:'title')->sav:upperCamel()}' => '{extension.views->sav:getItem()->sav:getItem(key:'title')->sav:lowerCamel()}',
    ),
    // Non-cachable controller actions
    array (
    )
);
</sav:function>
?>
