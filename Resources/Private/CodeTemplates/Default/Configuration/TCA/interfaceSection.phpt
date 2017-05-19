{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">

'interface' => [
    'showRecordFieldList' => '<f:if condition="{newTable.add_hidden}">hidden</f:if><f:for each="{newTable.fields}" as="field">,{field.fieldname}</f:for>'
],

</sav:function></f:format.raw>
