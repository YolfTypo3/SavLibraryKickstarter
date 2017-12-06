{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_relations_mm}">
<f:then>
return $this->{field.fieldname->sav:lowerCamel()};
</f:then>
<f:else>
return \YolfTypo3\SavLibraryMvc\Utility\Conversion::commaSeparatedStringToStringArray($this->{field.fieldname->sav:lowerCamel()});
</f:else>
</f:if>
