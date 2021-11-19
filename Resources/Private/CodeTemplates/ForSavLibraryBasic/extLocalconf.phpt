<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
defined('TYPO3_MODE') or die();
!
<f:for each="{extension.newTables}" as="table">
<f:if condition="{table.save_and_new}">
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addUserTSConfig('options.saveDocNew.{table.tablename}=1');
</f:if>
</f:for>
!
// Configures the Dispatcher
$typo3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
if (version_compare($typo3Version->getVersion(), '10.0', '<')) {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    	'{extension.general.1.vendorName}.{extension.general.1.extensionKey}',
    	'{extension.forms->sav:getItem()->sav:getItem(key:'title')}',
    	// Cachable controller actions    	
    	[
        	'{extension.forms->sav:getItem()->sav:getItem(key:'title')->sav:upperCamel()}' => '{extension.views->sav:getItem()->sav:getItem(key:'title')->sav:lowerCamel()}',
    	],
    	// Non-cachable controller actions
    	[]
	);
} else {
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    	'{extension.general.1.extensionKey->sav:upperCamel()}',
    	'{extension.forms->sav:getItem()->sav:getItem(key:'title')}',
    	// Cachable controller actions    	
    	[
        	\{extension.general.1.vendorName}\{extension.general.1.extensionKey->sav:upperCamel()}\Controller\{extension.forms->sav:getItem()->sav:getItem(key:'title')->sav:upperCamel()}Controller::class => '{extension.views->sav:getItem()->sav:getItem(key:'title')->sav:lowerCamel()}',
    	],
    	// Non-cachable controller actions
    	[]
	);
}

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
</sav:function>
