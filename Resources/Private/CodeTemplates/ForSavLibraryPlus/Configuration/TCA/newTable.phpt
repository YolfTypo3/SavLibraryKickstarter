{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<?php
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
defined('TYPO3_MODE') or die();
!
if (version_compare(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getVersion(), '10.0', '<')) {
    $interface = [
    	'showRecordFieldList' => '<f:if condition="{newTable.add_hidden}">hidden</f:if><f:for each="{newTable.fields}" as="field">,{field.fieldname}</f:for>'
    ];
} else {
    $interface = [];
}
return [
    <sav:indent count="4"><f:render partial="Configuration/TCA/controlSection.phpt" arguments="{_all}" /></sav:indent>
    <sav:indent count="4"><f:render partial="Configuration/TCA/interfaceSection.phpt" arguments="{_all}" /></sav:indent>    
    <sav:indent count="4"><f:render partial="Configuration/TCA/columnsSection.phpt" arguments="{_all}" /></sav:indent>
    <sav:indent count="4"><f:render partial="Configuration/TCA/typesSection.phpt" arguments="{_all}" /></sav:indent>
    <sav:indent count="4"><f:render partial="Configuration/TCA/palettesSection.phpt" arguments="{_all}" /></sav:indent>        
];
</sav:function></f:format.raw>
