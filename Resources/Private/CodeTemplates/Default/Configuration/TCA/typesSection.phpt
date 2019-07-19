{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">

'types' => [
    '0' => [
        'showitem' => '<sav:function name="substr" arguments="2"><f:if condition="{newTable.add_hidden}">, hidden</f:if><f:if condition="{newTable.add_access}">, fe_group</f:if><f:if condition="{newTable.add_starttime}">, starttime </f:if><f:if condition="{newTable.add_endtime}">, endtime </f:if><f:for each="{newTable.fields}" as="field">, {field.fieldname}<f:if condition="{field.type} == 'RichTextEditor'">' . '</f:if></f:for></sav:function>',

        <f:if condition="{extension.general.1.compatibility} > 0" >         
        'columnsOverrides' => [
        <f:for each="{newTable.fields}" as="field">
            <f:if condition="{field.type} == 'RichTextEditor'">
            '{field.fieldname}' => [
                'defaultExtras' => 'richtext[]:rte_transform[mode=ts]',
            ],
            </f:if>
        </f:for>           
        ],
        </f:if>
    ],
],

</sav:function></f:format.raw>
