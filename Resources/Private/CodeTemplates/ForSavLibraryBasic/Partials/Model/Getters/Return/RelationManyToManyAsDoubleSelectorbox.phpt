{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_relations_mm}">
<f:then>
return $this->{field.fieldname->sav:lowerCamel()};
</f:then>
<f:else>
return explode (',', $this->{field.fieldname->sav:lowerCamel()});
</f:else>
</f:if>
