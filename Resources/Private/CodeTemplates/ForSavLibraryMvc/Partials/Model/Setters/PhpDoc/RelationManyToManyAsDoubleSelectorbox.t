{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_relations_mm}">
<f:then>
@param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<{field.conf_rel_table->sav:Mvc.BuildModelName(extension:extension)}> ${field.fieldname}
</f:then>
<f:else>
@param string ${field.fieldname}
</f:else>
</f:if>
