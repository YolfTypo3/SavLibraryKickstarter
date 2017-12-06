{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_relations_mm}">
<f:then>
\TYPO3\CMS\Extbase\Persistence\ObjectStorage<{field.conf_rel_table->sav:Mvc.BuildModelName(extension:extension)}>
</f:then>
<f:else>
string
</f:else>
</f:if>
