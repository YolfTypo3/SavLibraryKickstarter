{<f:if condition="{field.conf_relations_mm}">
<f:then>
\TYPO3\CMS\Extbase\Persistence\ObjectStorage<{field.conf_rel_table->sav:builder.mvc.modelName(extension:extension)}>
</f:then>
<f:else>
string
</f:else>
</f:if>
