{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<?php
defined('TYPO3_MODE') or die();
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    pluginSignature:  '{extension.general.1.extensionKey->sav:upperCamel()->sav:toLower()}_pi1',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
}">
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['{pluginSignature}'] = 'layout,select_key';

// Adds the flexform field to plugin option
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['{pluginSignature}'] = 'pi_flexform';
!
// Adds the flexform DataStructure
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '{pluginSignature}',
    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml'
);
!
// Registers the Plugin to be listed in the Backend.
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    '{extension.general.1.extensionKey}',
    'Pi1',
    'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1'
);
</f:alias>
</sav:function>
</f:format.raw>
?>
