{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<f:format.raw><sav:utility.removeEmptyLines keepLine="!">
<?php
!
declare(strict_types=1);
!
<f:if condition="{extension.general.1.compatibility} == '13x-14x'">
use TYPO3\CMS\Core\Information\Typo3Version;
</f:if>
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
!
defined('TYPO3') or die();
!
<f:alias map="{
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    pluginName: '{extension.general.1.pluginName->sav:format.upperCamel()}'
}">
<f:switch expression="{extension.general.1.compatibility}">

<f:case value="13x">

// Registers the Plugin to be listed in the Backend.
$pluginSignature = ExtensionUtility::registerPlugin(
    '{extensionName}',
	'{pluginName}',
	'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
	null,
	'plugins',
	'{extension.general.1.description}'
);
!
// Activates the display of the FlexForm field
ExtensionManagementUtility::addToAllTCAtypes(
	'tt_content',
	'pages;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pages.ALT.list_formlabel,--div--;Configuration,pi_flexform,',
	$pluginSignature,
	'after:subheader',
);
!
ExtensionManagementUtility::addPiFlexFormValue(
	'*',
    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml',
    $pluginSignature
);
</f:case>

<f:case value="13x-14x">
$typo3Version = new (Typo3Version::class);
if ($typo3Version->getMajorVersion() == 13) {
	// Registers the Plugin to be listed in the Backend.
	$pluginSignature = ExtensionUtility::registerPlugin(
	    '{extensionName}',
		'{pluginName}',
		'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
		null,
		'plugins',
		'{extension.general.1.description}'
	);
!
	// Activates the display of the FlexForm field
	ExtensionManagementUtility::addToAllTCAtypes(
		'tt_content',
		'pages;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pages.ALT.list_formlabel,--div--;Configuration,pi_flexform,',
		$pluginSignature,
		'after:subheader',
	);
!
	// @extensionScannerIgnoreLine
	ExtensionManagementUtility::addPiFlexFormValue(
		'*',
	    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml',
	    $pluginSignature
	); 
} else {
	$pluginSignature = ExtensionUtility::registerPlugin(
	    '{extensionName}',
		'{pluginName}',
		'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
		null,
		'plugins',
		'{extension.general.1.description}'
	);
}
</f:case>

<f:case value="14x">
// Registers the Plugin to be listed in the Backend.
$pluginSignature = ExtensionUtility::registerPlugin(
    '{extensionName}',
	'{pluginName}',
	'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
	null,
	'plugins',
	'{extension.general.1.description}',
	'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml'
);
</f:case>
</f:switch>
</f:alias>
!
// Adds addToInsertRecords() if any
<f:for each="{extension.newTables}" as="table">
<f:alias map="{
  model: '{sav:builder.tableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, isMvc: true)}'
}">
<f:if condition="{table.allow_ce_insert_records}">
ExtensionManagementUtility::addToInsertRecords('{model}');
</f:if>
</f:alias>
</f:for>
</sav:utility.removeEmptyLines></f:format.raw>