{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

<f:if condition="{sav:function(name:'isArrayOfInteger',arguments:{input:field.items,index:'value'})}">
<f:then>integer</f:then>
<f:else>string</f:else>
</f:if>
