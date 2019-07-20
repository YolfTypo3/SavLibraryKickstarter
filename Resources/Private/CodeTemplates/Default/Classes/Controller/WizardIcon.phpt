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
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
!
/**
 * Class that adds the wizard icon.
 *
 */
class {controllerName}WizardIcon {
	/**
	 * Processes the wizard items array.
	 *
	 * @param array $wizardItems The wizard items
	 * @return array Modified array with wizard items
	 */
	public function proc(array $wizardItems) : array
	{
		$wizardItems['plugins_tx_{extensionName->sav:tolower()}_{controllerName->sav:tolower()}'] = [
			'iconIdentifier'        => 'tx-{extensionName->sav:toLower()}-wizard',
			'title'       => LocalizationUtility::translate('plugin_title', '{extension.general.1.extensionKey}'),
			'description' => LocalizationUtility::translate('plugin_wizard_description', '{extension.general.1.extensionKey}'),
			'params'      => '&defVals[tt_content][CType]=list&defVals[tt_content][list_type]={extensionName->sav:tolower()}_{controllerName->sav:tolower()}'
		];

		return $wizardItems;
	}
}
?>
</f:alias>
</sav:function>