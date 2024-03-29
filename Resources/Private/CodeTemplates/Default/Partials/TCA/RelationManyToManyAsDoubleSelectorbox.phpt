'config' => [
    <f:alias map="{where:{
        all: 'AND 1',
        select_cur: 'AND {field.conf_rel_table}.pid=###CURRENT_PID###',
        select_root: 'AND {field.conf_rel_table}.pid=###SITEROOT###',
        select_storage: 'AND {field.conf_rel_table}.pid=###STORAGE_PID###'
    }}">
    'type' => 'select',
    'renderType' => 'selectMultipleSideBySide',
    <f:if condition="{field.conf_rel_table} == '_CUSTOM'">
        <f:then>
    'foreign_table' => '{field.conf_custom_table_name}',
    'foreign_table_where' => '{where->sav:utility.getItem(key:field.conf_rel_type)}{f:if(condition:newTable.localization, then:' AND {field.conf_custom_table_name}.sys_language_uid IN (-1,0)')} {sav:builder.orderByClauseForRelationTable(arguments:extension, tableName:field.conf_rel_table, mvc:mvc)}',
        </f:then>
        <f:else>
    'foreign_table' => '{field.conf_rel_table}',
    'foreign_table_where' => '{where->sav:utility.getItem(key:field.conf_rel_type)}{f:if(condition:newTable.localization, then:' AND {field.conf_rel_table}.sys_language_uid IN (-1,0)')} {sav:builder.orderByClauseForRelationTable(arguments:extension, tableName:field.conf_rel_table, mvc:mvc)}',
        </f:else>
    </f:if>
    'size' => {f:if(condition:field.conf_relations_selsize, then:field.conf_relations_selsize, else:1)},
    'minitems' => 0,
    'maxitems' => {f:if(condition:field.conf_relations, then:field.conf_relations, else:100000)},
    <f:if condition="{field.conf_relations_mm}">
    'MM' => '{modelForMM}_{field.fieldname}_mm',
    </f:if>
    </f:alias>
], 
   