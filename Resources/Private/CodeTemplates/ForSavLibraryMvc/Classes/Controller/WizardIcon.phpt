<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}',
    actionName:     '{extension.views->sav:getItem()->sav:getItem(key:\'title\')->sav:lowerCamel()}'
}">
namespace {vendorName}\{extensionName}\Controller;
!
/**
*  Copyright notice
*
*  (c) <f:format.date format="Y">now</f:format.date> {extension.emconf.1.author} <{extension.emconf.1.author_email}>
*
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
*/
!
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
!
/**
 * Class that adds the wizard icon.
 *
 */
class WizardIcon {

	/**
	 * Processes the wizard items array.
	 *
	 * @param array $wizardItems The wizard items
	 * @return array Modified array with wizard items
	 */
	public function proc(array $wizardItems) {
		$LL = $this->includeLocalLang();

		$wizardItems['plugins_tx_{extensionName->sav:tolower()}_{pi1'] = array(
			'icon'        => 'EXT:{extension.general.1.extensionKey}/Resources/Public/Icons/icon_{extension.general.1.extensionKey->sav:function(name:"removeUnderscore")}.png',
			'title'       => $GLOBALS['LANG']->getLLL('plugin_title', $LL),
			'description' => $GLOBALS['LANG']->getLLL('plugin_wizard_description', $LL),
			'params'      => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]={extensionName->sav:tolower()}_pi1}'
		);

		return $wizardItems;
	}

	/**
	 * Reads the extension locallang.xml and returns the $LOCAL_LANG array found in that file.
	 *
	 * @return array The array with language labels
	 */
	protected function includeLocalLang() {
		$llFile = ExtensionManagementUtility::extPath('{extension.general.1.extensionKey}') . 'Resources/Private/Language/locallang.xlf';
		return $GLOBALS['LANG']->includeLLFile($llFile, FALSE);
	}

}
?>
</f:alias>
</sav:function>