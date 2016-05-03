{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_relations_mm}">
<f:then>
@return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<{field.conf_rel_table->sav:Mvc.BuildModelName(extension:extension)}>
</f:then>
<f:else>
@return array
</f:else>
</f:if>
