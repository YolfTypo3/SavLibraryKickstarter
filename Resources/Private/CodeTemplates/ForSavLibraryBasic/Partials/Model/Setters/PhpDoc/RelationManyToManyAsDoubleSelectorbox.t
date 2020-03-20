{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_relations_mm}">
<f:then>
@param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage ${field.fieldname->sav:lowerCamel()}
</f:then>
<f:else>
@param string ${field.fieldname->sav:lowerCamel()}
</f:else>
</f:if>
