{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines">
'columns' => array(
    <f:if condition="{newTable.localization}">
    'sys_language_uid' => array (
        'exclude' => 1,
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
        'config' => array (
            'type' => 'select',
            'renderType' => 'selectSingleBox',
            'foreign_table' => 'sys_language',
            'foreign_table_where' => 'ORDER BY sys_language.title',
            'items' => array(
                array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',-1),
                array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value',0)
            )
        )
    ),
    'l18n_parent' => array(
        'displayCond' => 'FIELD:sys_language_uid:>:0',
        'exclude' => 1,
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
        'config' => array(
            'type' => 'select',
            'renderType' => 'selectSingleBox',
            'items' => array(
                array('', 0),
            ),
            'foreign_table' => '{model}',
            'foreign_table_where' => 'AND {model}.uid=###CURRENT_PID### AND {model}.sys_language_uid IN (-1,0)', 
        )
    ),
    'l18n_diffsource' => array(
       'config'=>array(
            'type'=>'passthrough')
    ),
    't3ver_label' => array(
        'displayCond' => 'FIELD:t3ver_label:REQ:true',
        'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
        'config' => array(
            'type'=>'none',
            'cols' => 27
        )
     ),
    </f:if>
    <f:if condition="{newTable.add_hidden}">
    'hidden' => array(
        'exclude' => 1,
        'label'  => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
        'config' => array(
            'type'  => 'check',
            'default' => 0,
        )
    ),
    </f:if>
    <f:if condition="{newTable.add_starttime}">
    'starttime' => array(
        'exclude' => 1,
        'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
        'config'  => array(
            'type'     => 'input',
            'size'     => '8',
            'max'      => '20',
            'eval'     => 'date',
            'default'  => '0',
            'checkbox' => '0'
        )
    ),
    </f:if>
    <f:if condition="{newTable.add_endtime}">
    'endtime' => array(
        'exclude' => 1,
        'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
        'config'  => array(
            'type'     => 'input',
            'size'     => '8',
            'max'      => '20',
            'eval'     => 'date',
            'checkbox' => '0',
            'default'  => '0',
            'range'    => array(
                'upper' => mktime(3, 14, 7, 1, 19, 2038),
                'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
            )
        )
    ),
    </f:if>
    <f:if condition="{newTable.add_access}">
    'fe_group' => array(
        'exclude' => 1,
        'label'   => 'LLL:EXT:lang/locallang_general.xlf:LGL.fe_group',
        'config'  => array(
            'type'  => 'select',
            'renderType' => 'selectSingleBox',            
            'items' => array(
                array('', 0),
                array('LLL:EXT:lang/locallang_general.xlf:LGL.hide_at_login', -1),
                array('LLL:EXT:lang/locallang_general.xlf:LGL.any_login', -2),
                array('LLL:EXT:lang/locallang_general.xlf:LGL.usergroups', '--div--')
            ),
            'foreign_table' => 'fe_groups'
        )
    ),
    </f:if>
    <f:for each="{newTable.fields}" as="field">
    <sav:removeIfContainsDoNotCreate>
    '{field.fieldname}' => array(
        'exclude' => 1,
        'label'  => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{field.fieldname}',
        <sav:indent count="8"><f:render partial="Partials/TCA/{field.type}.phpt" arguments="{_all}" /></sav:indent>
    ),
    </sav:removeIfContainsDoNotCreate>
    </f:for>
),
</sav:function></f:format.raw>