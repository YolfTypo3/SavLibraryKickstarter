{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines">
'EXT' => [
    '{extension.general.1.extensionKey}' => [
        'ctrl' => [
            <f:if condition="{table.save_and_new}">
            'saveAndNew' => 1,
            </f:if>
        ],
        'columns' => [
            <f:alias map="{tableName:'{table.tablename}'}">      
            <f:for each="{table.fields}" as="field">
            <sav:Mvc.SubformIndexManager action="increment"/>
            '{field.fieldname}' => [
                'fieldType' => '{field.type}',
               
<f:variable name="foreignModel"><f:spaceless><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/TCA/EXTForeignModel/{field.type}.t', default:'Partials/TCA/EXTForeignModel/Default.t')}" arguments="{_all}" /></f:spaceless></f:variable>   

                <f:if condition="{foreignModel}">
                'foreignModel' => '{foreignModel}',
                </f:if> 

                <f:if condition="{tableType} == 'existing' && {field.type} != 'ShowOnly'">
                'tableFieldName' => ['{sav:buildTableName(shortName:field.fieldname, extensionKey:extension.general.1.extensionKey)}' => '{field.fieldname}'],
                </f:if>
                <f:if condition="{field.conf_render_type} && {field.type} =='ShowOnly'" >
                'renderType' => '{field.conf_render_type}',
                </f:if>                 
                'config' => [
                    <f:for each="{extension.views}" as="view" key="viewKey">
                    {viewKey} => [
                    
<f:variable name="extDefault"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/TCA/EXTDefault/{field.type}{view.type->sav:upperCamel()}View.phpt', default:'Partials/TCA/EXTDefault/Default{view.type->sav:upperCamel()}View.phpt')}" arguments="{_all}" /></f:variable>
                        
                        <f:if condition="{extDefault}">
                        <sav:indent count="24">{extDefault}</sav:indent>
                        </f:if>
                        
                        <f:for each="{field.configuration->sav:getItem(key:viewKey)->sav:Mvc.buildConfiguration()}" as="attribute" key="attributeKey" >
                        '{attributeKey}' => '{attribute}',
                        </f:for>
                        <f:alias map="{selected:'{field.selected->sav:getItem(key:viewKey)}'}">
                        'selected' => {f:if(condition:selected, then:1, else:0)},
                        </f:alias>             
                     ],
                     </f:for>
                ],
                'folders' => [
                    <f:for each="{field.folders}" as="folder" key="folderKey">
                    <f:if condition="{folderKey}">
                    {folderKey} => '{folder}',
                    </f:if>
                    </f:for>
                ],
               'order' => [
                    <f:for each="{field.order}" as="order" key="orderKey">
                    <f:if condition="{orderKey->sav:function(name:'isPositiveInteger')}">
                    {orderKey} => {order},
                    </f:if>
                    </f:for>
                ],
            ],
            </f:for>
            </f:alias>
        ],          
    ],
],

</sav:function></f:format.raw>
