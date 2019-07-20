{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<?php
defined('TYPO3_MODE') or die();
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist']['{extension.general.1.extensionKey}_pi1'] = 'layout,select_key';
!
// Adds the flexform field to plugin option
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['{extension.general.1.extensionKey}_pi1'] = 'pi_flexform';
!
// Adds the flexform DataStructure
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    '{extension.general.1.extensionKey}_pi1',
    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml'
);
!
// Adds the plugin
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
        '{extension.general.1.extensionKey}_pi1',
    ],
    'list_type',
    '{extension.general.1.extensionKey}'
);
</sav:function>
</f:format.raw>
?>
