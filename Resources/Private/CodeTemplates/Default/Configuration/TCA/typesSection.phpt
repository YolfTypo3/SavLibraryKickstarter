<f:format.raw><sav:utility.removeEmptyLines keepLine="!">

'types' => [
    '0' => [
        'showitem' => '<sav:format.regexp pattern="/^, (.*)$/" replacement="$1"><f:if condition="{table.add_hidden}">, hidden</f:if><f:if condition="{table.add_access}">, fe_group</f:if><f:if condition="{table.add_starttime}">, starttime </f:if><f:if condition="{table.add_endtime}">, endtime </f:if><f:for each="{table.fields}" as="field">, {field.fieldname}<f:if condition="{field.type} == 'RichTextEditor'">' . '</f:if></f:for></sav:format.regexp>',

        <f:if condition="{extension.general.1.compatibility} > 0" >         
        'columnsOverrides' => [
        <f:for each="{table.fields}" as="field">
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

</sav:utility.removeEmptyLines></f:format.raw>
