<f:if condition="{field.conf_relations_mm}">
<f:then>
    <f:if condition="{field.conf_rel_table} == '_CUSTOM'">
    <f:then>
        <f:if condition="{field.conf_custom_model_name}">
        <f:then>
\TYPO3\CMS\Extbase\Persistence\ObjectStorage<{field.conf_custom_model_name}>
        </f:then>
        <f:else>
\TYPO3\CMS\Extbase\Persistence\ObjectStorage<{field.conf_custom_table_name->sav:builder.mvc.modelName(extension:extension, tableType:tableType)}>
        </f:else>
        </f:if>
    </f:then>
    <f:else>
\TYPO3\CMS\Extbase\Persistence\ObjectStorage<{field.conf_rel_table->sav:builder.mvc.modelName(extension:extension)}>
    </f:else>
    </f:if>
</f:then>
<f:else>
string
</f:else>
</f:if>
