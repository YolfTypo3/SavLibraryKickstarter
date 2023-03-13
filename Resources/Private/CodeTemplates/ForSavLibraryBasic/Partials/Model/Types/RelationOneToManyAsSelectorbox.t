<f:alias map="{custom:'_CUSTOM'}">
<f:if condition="{field.conf_rel_table} == {custom}">
    <f:then>
{field.conf_custom_table_name->sav:builder.mvc.modelName(extension:extension)}
    </f:then>
    <f:else>
{field.conf_rel_table->sav:builder.mvc.modelName(extension:extension)}
    </f:else>
</f:if>
</f:alias>
