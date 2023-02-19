{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines">
'columns' => [
    <f:if condition="{table.localization}">
    'sys_language_uid' => [
        'exclude' => true,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
        'config' => version_compare(\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getVersion(), '11.0', '<') ?
        [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'foreign_table' => 'sys_language',
            'items' => [
                ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages', -1],
                ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.default_value', 0]
            ],
            'default' => 0,
            'fieldWizard' => [
                'selectIcons' => [
                    'disabled' => false,
                ],
            ],
        ] :
        [
      		'type' => 'language'          
        ],        
    ],
    'l10n_parent' => [
        'displayCond' => 'FIELD:sys_language_uid:>:0',
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
        'config' => [
            'type' => 'select',
            'renderType' => 'selectSingle',
            'items' => [
                ['', 0]
            ],
            'foreign_table' => 'sys_file_collection',
            'foreign_table_where' => 'AND sys_file_collection.pid=###CURRENT_PID### AND sys_file_collection.sys_language_uid IN (-1,0)',
        'default' => 0,
        ]
    ],
    'l10n_diffsource' => [
        'config' => [
            'type' => 'passthrough',
            'default' => ''
        ]
    ],    
    't3ver_label' => [
        'displayCond' => 'FIELD:t3ver_label:REQ:true',
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
        'config' => [
            'type'=>'none',
            'cols' => 27
        ]
    ],
    </f:if>
    <f:if condition="{table.add_hidden}">
    'hidden' => [
        'exclude' => 1,
        'label'  => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
        'config' => [
            'type'  => 'check',
            'default' => 0,
        ]
    ],
    </f:if>
    <f:if condition="{table.add_starttime}">
    'starttime' => [
        'exclude' => true,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'eval' => 'datetime,int',
            'default' => 0
        ]
    ],
    </f:if>
    <f:if condition="{table.add_endtime}">
    'endtime' => [
        'exclude' => true,
        'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
        'config' => [
            'type' => 'input',
            'renderType' => 'inputDateTime',
            'eval' => 'datetime,int',
            'default' => 0,
            'range' => [
                'upper' => mktime(0, 0, 0, 1, 1, 2038)
            ]
        ]
    ],
    </f:if>
    <f:if condition="{table.add_access}">
    'fe_group' => [
        'exclude' => 1,
        'label'   => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_group',
        'config'  => [
            'type'  => 'select',
            'renderType' => 'selectSingleBox',            
            'items' => [
                ['', 0],
                ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hide_at_login', -1],
                ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.any_login', -2],
                ['LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.usergroups', '--div--']
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
    <f:for each="{table.fields}" as="field">
    '{field.fieldname}' => [
        'exclude' => 1,
        'label'  => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{field.fieldname}',
        <sav:indent count="8"><f:render partial="Partials/TCA/{field.type}.phpt" arguments="{_all}" /></sav:indent>
        <f:if condition="{field.displayCondition}">
        <sav:indent count="8">'displayCond' => '{field.displayCondition}',</sav:indent>
        </f:if>      
    ],
    </f:for>
],
</sav:function></f:format.raw>