{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_relations_mm}">
$this->{field.fieldname->sav:lowerCamel()} = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
</f:if>
