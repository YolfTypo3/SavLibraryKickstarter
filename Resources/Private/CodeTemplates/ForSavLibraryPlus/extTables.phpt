<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
defined('TYPO3_MODE') or die();

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

<f:if condition="{extension.general.1.addWizardPluginIcon}">
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
}">
// Registers the icon
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
   \TYPO3\CMS\Core\Imaging\IconRegistry::class
);
$iconRegistry->registerIcon(
   'tx-{extensionName->sav:toLower()}-wizard',
   \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
   ['source' => 'EXT:{extension.general.1.extensionKey}/Resources/Public/Icons/ExtensionWizard.svg']
);
!
// Adds a wizard plugin icon
if (TYPO3_MODE === 'BE') {
    $GLOBALS['TBE_MODULES_EXT']['xMOD_db_new_content_el']['addElClasses']['{vendorName}\\{extensionName}\\Controller\\{controllerName}WizardIcon'] = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('{extension.general.1.extensionKey}') . 'Classes/Controller/{controllerName}WizardIcon.php';
}
</f:alias>
</f:if>

</sav:function>
?>
