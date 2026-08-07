{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:if condition="{field.conf_relations_mm}">
<f:then>
    <f:if condition="{field.conf_rel_table} == '_CUSTOM'">
    <f:then>
        <f:if condition="{field.conf_custom_model_name}">
        <f:then>
ObjectStorage<{field.conf_custom_model_name}>
        </f:then>
        <f:else>
ObjectStorage<{field.conf_custom_table_name->sav:builder.mvc.modelName(extension:extension, tableType:tableType, shortName:1)}>
        </f:else>
        </f:if>
    </f:then>
    <f:else>
ObjectStorage<{field.conf_rel_table->sav:builder.mvc.modelName(extension:extension, shortName:1)}>
    </f:else>
    </f:if>
</f:then>
<f:else>
string
</f:else>
</f:if>
