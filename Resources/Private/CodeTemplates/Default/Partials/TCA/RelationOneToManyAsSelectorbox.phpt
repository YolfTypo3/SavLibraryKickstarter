{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}

'config' => [
    <f:alias map="{where:{
    all: 'AND 1',
    select_cur: 'AND {field.conf_rel_table}.pid=###CURRENT_PID###',
    select_root: 'AND {field.conf_rel_table}.pid=###SITEROOT###',
    select_storage: 'AND {field.conf_rel_table}.pid=###STORAGE_PID###'
    }, custom:'_CUSTOM'}">
    'type' => 'select',  
    'renderType' => 'selectSingle',      
    <f:if condition="{field.conf_rel_dummyitem}">
    'items' => [
        ['LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{field.fieldname}.I.0', 0],
    ],
    </f:if>
    <f:if condition="{field.conf_rel_table} == {custom}">
    <f:then>
    'foreign_table' => '{field.conf_custom_table_name}',
    'foreign_table_where' => '{where->sav:getItem(key:field.conf_rel_type)}{f:if(condition:newTable.localization, then:' AND {field.conf_custom_table_name}.sys_language_uid IN (-1,0)')} {sav:buildOrderByClauseForRelationTable(arguments:extension, tableName:field.conf_custom_table_name)}',
    </f:then>
    <f:else>
    'foreign_table' => '{field.conf_rel_table}',
    'foreign_table_where' => '{where->sav:getItem(key:field.conf_rel_type)}{f:if(condition:newTable.localization, then:' AND {field.conf_rel_table}.sys_language_uid IN (-1,0)')} {sav:buildOrderByClauseForRelationTable(arguments:extension, tableName:field.conf_rel_table)}',
    </f:else>
    </f:if>   
    'size' => 1,
    'minitems' => 0,
    'maxitems' => 1,
    </f:alias>
],