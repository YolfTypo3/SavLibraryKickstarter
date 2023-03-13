<f:format.raw><sav:utility.removeEmptyLines keepLine="!">

<f:variable name="tableType" value="new" />

<?php
defined('TYPO3') or die();
!
$typo3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
if (version_compare($typo3Version->getVersion(), '10.0', '<')) {
    $interface = [
    	'showRecordFieldList' => '<f:if condition="{newTable.add_hidden}">hidden</f:if><f:for each="{newTable.fields}" as="field">,{field.fieldname}</f:for>'
    ];
} else {
    $interface = [];
}
return [
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/controlSection.phpt" arguments="{_all}" /></sav:utility.indent>
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/interfaceSection.phpt" arguments="{_all}" /></sav:utility.indent>    
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/columnsSection.phpt" arguments="{_all}" /></sav:utility.indent>
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/typesSection.phpt" arguments="{_all}" /></sav:utility.indent>
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/palettesSection.phpt" arguments="{_all}" /></sav:utility.indent>        
];
</sav:utility.removeEmptyLines></f:format.raw>
