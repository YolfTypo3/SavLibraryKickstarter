{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:if condition="{field.conf_rel_table} == '_CUSTOM'">
<f:then>
    <f:if condition="{field.conf_custom_model_name}">
    <f:then>
use <sav:format.ltrim>{field.conf_custom_model_name};</sav:format.ltrim>
    </f:then>
    <f:else>
use <sav:format.ltrim>{field.conf_custom_table_name->sav:builder.mvc.modelName(extension:extension, tableType:tableType)};</sav:format.ltrim>
    </f:else>
    </f:if>
</f:then>
<f:else>
use <sav:format.ltrim>{field.conf_rel_table->sav:builder.mvc.modelName(extension:extension, tableType:tableType)};</sav:format.ltrim>
</f:else>
</f:if>