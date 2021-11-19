<?php
defined('TYPO3_MODE') or die();
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:for each="{extension.newTables}" as="table" key="tableKey">
<f:alias map="{
    model: '{sav:buildTableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:1)}'
}">

<f:if condition="{table.allow_on_pages}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('{model}');
</f:if>

</f:alias>
</f:for>

</sav:function>
