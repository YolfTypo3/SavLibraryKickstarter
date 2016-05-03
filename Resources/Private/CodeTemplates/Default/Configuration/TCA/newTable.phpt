{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}<?php
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
return array(
    <sav:indent count="4"><f:render partial="Configuration/TCA/controlSection.phpt" arguments="{_all}" /></sav:indent>
    <sav:indent count="4"><f:render partial="Configuration/TCA/interfaceSection.phpt" arguments="{_all}" /></sav:indent>    
    <sav:indent count="4"><f:render partial="Configuration/TCA/columnsSection.phpt" arguments="{_all}" /></sav:indent>
    <sav:indent count="4"><f:render partial="Configuration/TCA/typesSection.phpt" arguments="{_all}" /></sav:indent>
    <sav:indent count="4"><f:render partial="Configuration/TCA/palettesSection.phpt" arguments="{_all}" /></sav:indent>        
);
</sav:function></f:format.raw>
?>