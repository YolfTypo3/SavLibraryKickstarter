{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines">

'ctrl' => [
    'title' => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}',
    'label' => '{f:if(condition:table.header_field, then:table.header_field, else:"uid")}',
    
    <f:if condition="{table.label_userFunc}"> 
    'label_userFunc' => '<f:format.raw>{table.label_userFunc}</f:format.raw>',
    </f:if>
    
    'tstamp' => 'tstamp',
    'crdate' => 'crdate',
    'cruser_id' => 'cruser_id',
    
    <f:if condition="{table.type_field}">
    'type' => '{table.type_field}',
    </f:if>
    
    <f:if condition="{table.versioning}">
    'origUid' => 't3_origuid',
    'versioningWS' => true,
    </f:if>
    
    <f:if condition="{table.localization}">
    'languageField' => 'sys_language_uid',
    'transOrigPointerField' => 'l10n_parent',
    'transOrigDiffSourceField' => 'l10n_diffsource',
    </f:if>
    
    <f:if condition="{table.sorting}">
    <f:then>
    'sortby' => 'sorting',
    </f:then>
    <f:else>
    'default_sortby' => '{table.sorting_field}{f:if(condition:table.sorting_desc, then:" DESC")}',
    </f:else>
    </f:if>
    
    <f:if condition="{table.add_deleted}">
    'delete' => 'deleted',
    </f:if>
    
    'enablecolumns' => [
    <f:if condition="{table.add_hidden}">
        'disabled' => 'hidden',
    </f:if>
    <f:if condition="{table.add_starttime}">
        'starttime' => 'starttime',
    </f:if>
    <f:if condition="{table.add_endtime}">
        'endtime' => 'endtime',
    </f:if>
    <f:if condition="{table.add_access}">
        'fe_group' => 'fe_group',
    </f:if>
    ],
    
    'iconfile' => 'EXT:{extension.general.1.extensionKey}/Resources/Public/Icons/icon_{model}.gif',
    
    <f:comment>Generates an EXT if the librarytype is sav_Library_mvc</f:comment>
    <f:if condition="{extension.general.1.libraryType} == 2">
    <sav:indent count="4"><f:render partial="Configuration/TCA/extSection.phpt" arguments="{_all}" /></sav:indent>
    </f:if>
    
],

</sav:function></f:format.raw>
