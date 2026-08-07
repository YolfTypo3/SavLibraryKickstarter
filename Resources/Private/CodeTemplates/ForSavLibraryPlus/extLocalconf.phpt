{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<sav:utility.removeEmptyLines keepLine="!">
<?php

<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:format.removeUnderscore()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">
!
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;
use TYPO3\CMS\Core\Imaging\IconRegistry;
!
defined('TYPO3') or die();
!
(function () {
<sav:file.saveContentToFile
    content='<f:render partial="{sav:file.getTemplateFile(templateFilePath:\'Configuration/user.tsconfigt\', extension:extension)}" arguments="{extension:extension}" />'
    extensionKey="{extension.general.1.extensionKey}"
    fileName="user.tsconfig"
    directory="Configuration"
    doNotCreateIfFileExists="{true}"
/>
!
	ExtensionManagementUtility::addTypoScript(
	    '{extension.general.1.extensionKey}',
	    'setup',
	    'plugin.tx_{extensionNameWithoutUnderscore}_pi1 = USER_INT
         plugin.tx_{extensionNameWithoutUnderscore}_pi1.userFunc = {vendorName}\{extensionName}\Controller\{extensionName}Controller->main'
	);
!	    
	ExtensionManagementUtility::addTypoScriptSetup(
		'tt_content.{extension.general.1.extensionKey}_pi1 < plugin.tx_{extensionNameWithoutUnderscore}_pi1'
	);	    

<f:if condition="{extension.general.1.addWizardPluginIcon}">
!
	// Registers the icon
	$iconRegistry = GeneralUtility::makeInstance(
   		IconRegistry::class
	);
	$iconRegistry->registerIcon(
   		'ext-{extensionName->sav:format.toLower()}-wizard',
		SvgIconProvider::class,
		['source' => 'EXT:{extension.general.1.extensionKey}/Resources/Public/Icons/ExtensionWizard.svg']
	);
!
	// Adds the page TSConfig for the Wizard Icon
	ExtensionUtility::addPageTSConfig(
    	'<INCLUDE_TYPOSCRIPT: source="FILE:EXT:{extension.general.1.extensionKey}/Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig">'
	);	
</f:if>
})();
</f:alias>
</sav:utility.removeEmptyLines>
