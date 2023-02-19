'config' => [
    'type' => 'inline',
    <f:if condition="{field.conf_rel_table} == '_CUSTOM'">
        <f:then>
    'foreign_table' => '{field.conf_custom_table_name}',
        </f:then>
        <f:else>
    'foreign_table' => '{field.conf_rel_table}',
        </f:else>
    </f:if>    
    'foreign_sortby' => 'sorting',
    'size' => {f:if(condition:field.conf_relations_selsize, then:field.conf_relations_selsize, else:1)},
    'minitems' => 0,
    'maxitems' => {f:if(condition:field.conf_relations, then:field.conf_relations, else:999999)},
    <f:if condition="{field.conf_norelation} == 1">
        <f:then>
    'norelation' => 1,
       </f:then>
       <f:else>
           <f:if condition="{field.conf_relations_mm}">
    'MM' => '{modelForMM}_{field.fieldname}_mm',
           </f:if>
       </f:else>
    </f:if>
    'appearance' => [
        'newRecordLinkPosition' => 'bottom',
        'collapseAll' => 1,
        'expandSingle' => 1,
    ],
],