<f:if condition="{field.conf_relations_mm}">
$this->{field.fieldname->sav:format.lowerCamel()} = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
</f:if>
