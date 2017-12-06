{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines">
'EXT' => [
    'sav_library_mvc' => [
        'ctrl' => [
            <f:if condition="{newTable.save_and_new}">
            'saveAndNew' => 1,
            </f:if>
        ],
        'columns' => [
            <f:alias map="{tableName:'{newTable.tablename}'}">      
            <f:for each="{newTable.fields}" as="field">
            <sav:Mvc.SubformIndexManager action="increment"/>
            '{field.fieldname}' => [
                'fieldType' => '{field.type}',
                'config' => [
                    <f:for each="{extension.views}" as="view" key="viewKey">
                    {viewKey} => [
                        <sav:indent count="24"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/TCA/EXTDefault/{field.type}{view.type->sav:upperCamel()}View.phpt', default:'Partials/TCA/EXTDefault/Default{view.type->sav:upperCamel()}View.phpt')}" arguments="{_all}" /></sav:indent>
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
                    {orderKey} => '{order}',
                    </f:if>
                    </f:for>
                ],
            ],
            </f:for>
            </f:alias>
        ],
        'controllers' => [   
        <f:for each="{extension.forms}" as="form" key="formKey">
        <f:alias map="{
            queryIndex:     '{form.query}',
            vendorName:     '{extension.general.1.vendorName}',
            extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}'           
        }">          
        <f:if condition="{extension.queries->sav:getItem(key:queryIndex)->sav:getItem(key:'mainTable')} == {model}">
            '{form.title}' => [
                'viewIdentifiers' => [
                    'listView' => {form.listView},
                    'singleView' => {form.singleView},
                    'editView' => {form.editView},
                    'specialView' => {form.specialView},
                    'viewsWithCondition' => [
                    <f:for each="{form.viewsWithCondition}" as="viewsWithCondition" key="viewsWithConditionKey">
                        '{viewsWithConditionKey}' => [
                            <f:for each="{viewsWithCondition}" as="viewWithCondition">
                            {viewWithCondition.key} => [
                                'config' => [
                                    <f:for each="{viewWithCondition.condition->sav:Mvc.buildConfiguration()}" as="attribute" key="attributeKey" >
                                    '{attributeKey}' => '{attribute}',
                                    </f:for>
                                ],
                            ],
                            </f:for>
                        ],
                    </f:for>
                    ],           
                ],
                'viewTileBars' => [
                    <f:for each="{extension.views}" as="view" key="viewKey">
                        <f:if condition="{sav:function(name:'in_array', arguments:'{needle:viewKey, haystack:\'{0:form.listView, 1:form.singleView, 2:form.editView, 3:form.specialView}\'}')}">
                        '{viewKey}' => '{view->sav:getItem(key:'viewTitleBar')}',
                        </f:if>
                    </f:for>
                ],
                'viewItemTemplates' => [
                    'listView' => '{extension.views->sav:getItem(key:form.listView)->sav:getItem(key:'itemTemplate')}',
                    'specialView' => '{extension.views->sav:getItem(key:form.specialView)->sav:getItem(key:'itemTemplate')}',
                ],
                'folders' => [
                    <f:for each="{extension.views}" as="view" key="viewKey">
                    '{viewKey}' => [
                        <f:for each="{view->sav:getItem(key:'folders')}" as="folder" key="folderKey">
                        {folderKey} => [
                            'label' => '{folder.label}',
                            'configuration' => [
                                <f:for each="{folder.configuration->sav:Mvc.buildConfiguration()}" as="attribute" key="attributeKey" >
                                '{attributeKey}' => '{attribute}',
                                </f:for>
                            ],
                        ],
                        </f:for>
                    ],        
                    </f:for>
                ],
                'queryIdentifier' => {queryIndex},            
            ],
        </f:if>
        </f:alias>
        </f:for> 
        ],              
    ],
],

</sav:function></f:format.raw>
