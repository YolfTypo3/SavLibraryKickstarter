{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<f:format.raw><sav:utility.removeEmptyLines keepLine="!">

<f:variable name="tableType" value="new" />

<?php
defined('TYPO3') or die();
!
return [
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/controlSection.phpt" arguments="{_all}" /></sav:utility.indent>
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/interfaceSection.phpt" arguments="{_all}" /></sav:utility.indent>    
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/columnsSection.phpt" arguments="{_all}" /></sav:utility.indent>
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/typesSection.phpt" arguments="{_all}" /></sav:utility.indent>
    <sav:utility.indent count="4"><f:render partial="Configuration/TCA/palettesSection.phpt" arguments="{_all}" /></sav:utility.indent>        
];
</sav:utility.removeEmptyLines></f:format.raw>
