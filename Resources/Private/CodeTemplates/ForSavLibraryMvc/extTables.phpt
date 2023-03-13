<sav:utility.removeEmptyLines keepLine="!">
<?php
defined('TYPO3') or die();
!
(function () {
<f:for each="{extension.newTables}" as="table" key="tableKey">
<f:alias map="{
  model: '{sav:builder.tableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:1)}'
}">

<f:if condition="{table.allow_on_pages}">
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('{model}');
</f:if>

</f:alias>
</f:for>
})();
</sav:utility.removeEmptyLines>