{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<f:format.raw><sav:utility.removeEmptyLines keepLine="!">
<?php
!
declare(strict_types=1);
!
<f:if condition="{extension.general.1.compatibility} == '13x-14x'">
use TYPO3\CMS\Core\Information\Typo3Version;
</f:if>
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

!
defined('TYPO3') or die();
!

<f:switch expression="{extension.general.1.compatibility}">

<f:case value="13x">

// Adds the plugin
ExtensionManagementUtility::addPlugin(
    [
        'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
        '{extension.general.1.extensionKey}_pi1',
    ],
    'CType',
    '{extension.general.1.extensionKey}'
);
!
// Activates the display of the FlexForm field
ExtensionManagementUtility::addToAllTCAtypes(
	'tt_content',
	'pages;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pages.ALT.list_formlabel,--div--;Configuration,pi_flexform,',
	'{extension.general.1.extensionKey}_pi1',
	'after:subheader',
);
!
ExtensionManagementUtility::addPiFlexFormValue(
	'*',
    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml',
    '{extension.general.1.extensionKey}_pi1'
);
</f:case>

<f:case value="13x-14x">
$typo3Version = new (Typo3Version::class);
if ($typo3Version->getMajorVersion() == 13) {
	// Adds the plugin
	ExtensionManagementUtility::addPlugin(
	    [
	        'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
	        '{extension.general.1.extensionKey}_pi1',
	    ],
	    'CType',
	    '{extension.general.1.extensionKey}'
	);
	!
	// Activates the display of the FlexForm field
	ExtensionManagementUtility::addToAllTCAtypes(
		'tt_content',
		'pages;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:pages.ALT.list_formlabel,--div--;Configuration,pi_flexform,',
		'{extension.general.1.extensionKey}_pi1',
		'after:subheader',
	);
	!
	// @extensionScannerIgnoreLine
	ExtensionManagementUtility::addPiFlexFormValue(
		'*',
	    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml',
	    '{extension.general.1.extensionKey}_pi1'
	);
} else {
	// Adds the plugin
	ExtensionManagementUtility::addPlugin(
	    [
	        'label' => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
	        'value' => '{extension.general.1.extensionKey}_pi1',
	        'icon'	=> '',
	        'group'	=> null
	    ],
	    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml',
	);
}

</f:case>

<f:case value="14x">
// Adds the plugin
ExtensionManagementUtility::addPlugin(
    [
        'label' => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:tt_content.list_type_pi1',
        'value' => '{extension.general.1.extensionKey}_pi1',
        'icon'	=> '',
        'group'	=> null
    ],
    'FILE:EXT:{extension.general.1.extensionKey}/Configuration/Flexforms/ExtensionFlexform.xml',
);

</f:case>
</f:switch>
!
// Adds addToInsertRecords() if any
<f:for each="{extension.newTables}" as="table">
<f:alias map="{
  model: '{sav:builder.tableName(shortName:table.tablename,extensionKey:extension.general.1.extensionKey,isMvc:false)}'
}">
<f:if condition="{table.allow_ce_insert_records}">
ExtensionManagementUtility::addToInsertRecords('{model}');
</f:if>
</f:alias>
</f:for>
</sav:utility.removeEmptyLines></f:format.raw>
