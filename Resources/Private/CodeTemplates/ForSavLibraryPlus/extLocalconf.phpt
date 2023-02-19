<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:function(name:\'removeUnderscore\')}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
}">
defined('TYPO3') or die();
!
(function () {
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
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
		'plugin.tx_{extensionNameWithoutUnderscore}_pi1.userFunc = {vendorName}\{extensionName}\Controller\{extensionName}Controller->main'
	);

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
   		'ext-{extensionName->sav:toLower()}-wizard',
		\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
		['source' => 'EXT:{extension.general.1.extensionKey}/Resources/Public/Icons/ExtensionWizard.svg']
	);
!
	// Adds the page TSConfig for the Wizard Icon
	\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    	'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:{extension.general.1.extensionKey}/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig">'
	);	
</f:alias>
</f:if>
})();
</f:alias>
</sav:function>
