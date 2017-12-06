<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:function(name:\'removeUnderscore\')}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
}">
namespace {vendorName}\{extensionName}\Controller;
!
/***************************************************************
*  Copyright notice
*
*  (c) <f:format.date format="Y">now</f:format.date> {extension.emconf.1.author} <{extension.emconf.1.author_email}>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
!
use \TYPO3\CMS\Core\Utility\GeneralUtility;
!
/**
 * Plugin '{extension.emconf.1.title}' for the '{extension.general.1.extensionKey}' extension.
 *
 * @author {extension.emconf.1.author} <{extension.emconf.1.author_email}>
 * @package TYPO3
 * @subpackage {extension.general.1.extensionKey}
 */
class {extensionName}Controller extends \TYPO3\CMS\Frontend\Plugin\AbstractPlugin {
!
	/**
	 * Should be same as classname of the plugin, used for CSS classes, variables
	 *
	 * @var string
	 */
	public $prefixId = 'tx_{extensionNameWithoutUnderscore}_pi1';
!
	/**
	 * Extension key.
	 *
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
	public function main($content, $configuration) {
!
	  // Creates the SavLibraryPlus controller
	  $controller = GeneralUtility::makeInstance(\YolfTypo3\SavLibraryPlus\Controller\Controller::class);
!
	  // Gets the extension configuration manager
	  $extensionConfigurationManager = $controller->getExtensionConfigurationManager();
!
	  // Injects the extension in the extension configuration manager
	  $extensionConfigurationManager->injectExtension($this);

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
?>
