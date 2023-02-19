<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:function(name:\'removeUnderscore\')}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
}">

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
!
namespace {vendorName}\{extensionName}\Controller;
!
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\Plugin\AbstractPlugin;
use YolfTypo3\SavLibraryPlus\Controller\Controller;
!
/**
 * Plugin '{extension.emconf.1.title}' for the '{extension.general.1.extensionKey}' extension.
 *
 * @author {extension.emconf.1.author} <{extension.emconf.1.author_email}>
 * @package {extension.general.1.extensionKey}
 */
class {extensionName}Controller extends AbstractPlugin 
{
	/**
	 * PrefixId
	 * @var string
	 */
	public $prefixId = 'tx_{extensionNameWithoutUnderscore}_pi1';
!
	/**
	 * Extension key
	 * @var string
	 */
	public $extKey = '{extension.general.1.extensionKey}';
!	
	/**
	 * The main function
	 *
	 * @param string $content
	 * @param array $configuration
	 *
	 * @return string the plugin content
	 */            
	public function main(string $content, array $configuration) : string
	{
	  // Creates the SavLibraryPlus controller
	  $controller = GeneralUtility::makeInstance(Controller::class);
!
	  // Gets the extension configuration manager
	  $extensionConfigurationManager = $controller->getExtensionConfigurationManager();
!
	  // Injects the extension in the extension configuration manager
	  $extensionConfigurationManager->injectExtension($this);
!
	  // Injects the typoScript configuration in the extension configuration manager
	  $extensionConfigurationManager->injectTypoScriptConfiguration($configuration);
!
	  // Sets the debug variable. Use debug ONLY for development
	  $controller->setDebug({f:if(condition:extension.general.1.debug, then:extension.general.1.debug, else:0)});
!
	  // Renders the form
	  $out = $controller->render();
!	          
	  return $out;
	}
}
</f:alias>
</sav:function>
