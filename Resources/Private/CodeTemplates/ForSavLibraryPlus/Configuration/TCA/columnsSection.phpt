{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines">
'columns' => [
    <f:if condition="{newTable.localization}">
    'sys_language_uid' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingleBox',
            'foreign_table' => 'sys_language',
            'foreign_table_where' => 'ORDER BY sys_language.title',
            'items' => [
                ['LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1],
                ['LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0]
            ]
        ]
    ],
    'l18n_parent' => [
        'displayCond' => 'FIELD:sys_language_uid:>:0',
        'exclude' => (version_compare(\YolfTypo3\SavLibraryPlus\Compatibility\Typo3VersionCompatibility::getVersion(), '10.0', '<') ? 1 : null),
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingleBox',
            'items' => [
                ['', 0],
            ],
            'foreign_table' => '{model}',
            'foreign_table_where' => 'AND {model}.uid=###CURRENT_PID### AND {model}.sys_language_uid IN (-1,0)', 
        ]
    ],
    'l18n_diffsource' => [
       'config'=> [
            'type'=>'passthrough'
            ]
    ],
    't3ver_label' => [
        'displayCond' => 'FIELD:t3ver_label:REQ:true',
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
        'config' => [
            'type'=>'none',
            'cols' => 27
        ]
    ],
    </f:if>
    <f:if condition="{newTable.add_hidden}">
    'hidden' => [
        'exclude' => 1,
        'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
        'config' => [
            'type'  => 'check',
            'default' => 0,
        ]
    ],
    </f:if>
    <f:if condition="{newTable.add_starttime}">
    'starttime' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
        'config'  => [
            'type'     => 'input',
            'size'     => '8',
            'max'      => '20',
            'eval'     => 'date',
            'default'  => '0',
            'checkbox' => '0'
        ]
    ],
    </f:if>
    <f:if condition="{newTable.add_endtime}">
    'endtime' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
        'config'  => [
            'type'     => 'input',
            'size'     => '8',
            'max'      => '20',
            'eval'     => 'date',
            'checkbox' => '0',
            'default'  => '0',
            'range'    => [
                'upper' => mktime(3, 14, 7, 1, 19, 2038),
                'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
            ]
        ]
    ],
    </f:if>
    <f:if condition="{newTable.add_access}">
    'fe_group' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.fe_group',
        'config'  => [
            'type'  => 'select',
            'renderType' => 'selectSingleBox',            
            'items' => [
                ['', 0],
                ['LLL:EXT:lang/locallang_general.xlf:LGL.hide_at_login', -1],
                ['LLL:EXT:lang/locallang_general.xlf:LGL.any_login', -2],
                ['LLL:EXT:lang/locallang_general.xlf:LGL.usergroups', '--div--']
            ],
            'foreign_table' => 'fe_groups'
        ]
    ],
    </f:if>
    <f:if condition="{libraryName}=='SavLibraryMvc'">
    'cruser_id_frontend' => [
        'config'  => [
            'type' => 'passthrough',
        ],
    ],
    </f:if>   
    <f:for each="{newTable.fields}" as="field">
    <sav:removeIfContainsDoNotCreate>
    '{field.fieldname}' => [
        'exclude' => 1,
        'label'  => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{field.fieldname}',
        <sav:indent count="8"><f:render partial="Partials/TCA/{field.type}.phpt" arguments="{_all}" /></sav:indent>
        <f:if condition="{field.displayCondition}">
        <sav:indent count="8">'displayCond' => '{field.displayCondition}',</sav:indent>
        </f:if>
    ],
    </sav:removeIfContainsDoNotCreate>
    </f:for>
],
</sav:function></f:format.raw>