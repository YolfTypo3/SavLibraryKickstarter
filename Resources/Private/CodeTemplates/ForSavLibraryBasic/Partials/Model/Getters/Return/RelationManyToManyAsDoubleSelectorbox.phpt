<f:if condition="{field.conf_relations_mm}">
<f:then>
return $this->{field.fieldname->sav:format.lowerCamel()};
</f:then>
<f:else>
return explode (',', $this->{field.fieldname->sav:format.lowerCamel()});
</f:else>
</f:if>
