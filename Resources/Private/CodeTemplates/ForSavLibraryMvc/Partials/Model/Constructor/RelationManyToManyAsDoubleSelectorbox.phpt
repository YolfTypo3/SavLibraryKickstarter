{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:if condition="{field.conf_relations_mm}">
$this->{field.fieldname->sav:format.lowerCamel()} = new ObjectStorage();
</f:if>
