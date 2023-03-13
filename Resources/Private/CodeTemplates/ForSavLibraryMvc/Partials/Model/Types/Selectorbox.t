<f:if condition="{field.items->sav:utility.isArrayOfInteger(index:'value')}">
<f:then>int</f:then>
<f:else>string</f:else>
</f:if>
