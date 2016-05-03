{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{field.conf_relations_mm}">
<f:then>
return $this->{field.fieldname->sav:lowerCamel()};
</f:then>
<f:else>
return \SAV\SavLibraryMvc\Utility\Conversion::commaSeparatedStringToStringArray($this->{field.fieldname->sav:lowerCamel()});
</f:else>
</f:if>
