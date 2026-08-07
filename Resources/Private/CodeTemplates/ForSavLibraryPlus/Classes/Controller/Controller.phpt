{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<sav:utility.removeEmptyLines keepLine="!">
<?php
!
declare(strict_types=1);
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    extensionNameWithoutUnderscore: '{extension.general.1.extensionKey->sav:format.removeUnderscore()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
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
use TYPO3\CMS\Core\Attribute\AsAllowedCallable;
use YolfTypo3\SavLibraryPlus\Controller\Controller;
!
/**
 * Plugin '{extension.emconf.1.title}' for the '{extension.general.1.extensionKey}' extension.
 *
 * @author {extension.emconf.1.author} <{extension.emconf.1.author_email}>
 * @package {extension.general.1.extensionKey}
 */
final class {extensionName}Controller extends Controller
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
	public $extensionKey = '{extension.general.1.extensionKey}';
!	
	/**
	 * The main function
	 *
	 * @param string $content
	 * @param array $configuration
	 *
	 * @return string the plugin content
	 */            
	#[AsAllowedCallable]
	public function main(string $content, array $configuration): string
	{!
		// Sets the debug variable. Use debug ONLY for development.
		$this->setDebug({f:if(condition:extension.general.1.debug, then:extension.general.1.debug, else:0)});
!
		// Renders the form
		$out = $this->render($configuration);      
!	          
		return $out;
	}
}
</f:alias>
</sav:utility.removeEmptyLines>
