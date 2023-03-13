<sav:utility.removeEmptyLines keepLine="!">
<?php

<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:format.removeUnderscore()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">

defined('TYPO3') or die();
!
(function () {
<f:for each="{extension.newTables}" as="newTable">
<f:alias map="{
    model: '{sav:builder.tableName(shortName:newTable.tablename, extensionKey:extension.general.1.extensionKey)}'
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
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">
	// Registers the icon
	$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
   		\TYPO3\CMS\Core\Imaging\IconRegistry::class
	);
	$iconRegistry->registerIcon(
   		'ext-{extensionName->sav:format.toLower()}-wizard',
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
</sav:utility.removeEmptyLines>
