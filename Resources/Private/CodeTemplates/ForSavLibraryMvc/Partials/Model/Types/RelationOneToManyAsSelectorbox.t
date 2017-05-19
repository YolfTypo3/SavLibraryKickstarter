{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

<f:alias map="{custom:'_CUSTOM'}">
<f:if condition="{field.conf_rel_table} == {custom}">
    <f:then>
{field.conf_custom_table_name->sav:Mvc.BuildModelName(extension:extension)}
    </f:then>
    <f:else>
{field.conf_rel_table->sav:Mvc.BuildModelName(extension:extension)}
    </f:else>
</f:if>
</f:alias>