{namespace sav=SAV\SavLibraryKickstarter\ViewHelpers}
<f:format.raw><sav:function name="removeEmptyLines">
'EXT' => array(
    'sav_library_mvc' => array(
        'ctrl' => array(
            <f:if condition="{newTable.save_and_new}">
            'saveAndNew' => 1,
            </f:if>
        ),
        'columns' => array(
            <f:alias map="{tableName:'{newTable.tablename}'}">      
            <f:for each="{newTable.fields}" as="field">
            <sav:Mvc.SubformIndexManager action="increment"/>
            '{field.fieldname}' => array(
                'fieldType' => '{field.type}',
                'config' => array(
                    <f:for each="{extension.views}" as="view" key="viewKey">
                    {viewKey} => array (
                        <sav:indent count="24"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/TCA/EXTDefault/{field.type}{view.type->sav:upperCamel()}View.phpt', default:'Partials/TCA/EXTDefault/Default{view.type->sav:upperCamel()}View.phpt')}" arguments="{_all}" /></sav:indent>
                        <f:for each="{field.configuration->sav:getItem(key:viewKey)->sav:Mvc.buildConfiguration()}" as="attribute" key="attributeKey" >
                        '{attributeKey}' => '{attribute}',
                        </f:for>
                        <f:alias map="{selected:'{field.selected->sav:getItem(key:viewKey)}'}">
                        'selected' => {f:if(condition:selected, then:1, else:0)},
                        </f:alias>             
                     ),
                     </f:for>
                ),
                'folders' => array(
                    <f:for each="{field.folders}" as="folder" key="folderKey">
                    <f:if condition="{folderKey}">
                    {folderKey} => '{folder}',
                    </f:if>
                    </f:for>
                ),
               'order' => array(
                    <f:for each="{field.order}" as="order" key="orderKey">
                    <f:if condition="{orderKey->sav:function(name:'isPositiveInteger')}">
                    {orderKey} => '{order}',
                    </f:if>
                    </f:for>
                ),
            ),
            </f:for>
            </f:alias>
        ),
        <f:for each="{extension.forms}" as="form" key="formKey">
        <f:alias map="{
            queryIndex:     '{form.query}',
            vendorName:     '{extension.general.1.vendorName}',
            extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}'           
        }">
        'controllers' => array(               
        <f:if condition="{extension.queries->sav:getItem(key:queryIndex)->sav:getItem(key:'mainTable')} == {model}">
            '{form.title}' => array(
                'viewIdentifiers' => array (
                    'listView' => {form.listView},
                    'singleView' => {form.singleView},
                    'editView' => {form.editView},
                    'specialView' => {form.specialView},
                    'viewsWithCondition' => array(
                    <f:for each="{form.viewsWithCondition}" as="viewsWithCondition" key="viewsWithConditionKey">
                        '{viewsWithConditionKey}' => array(
                            <f:for each="{viewsWithCondition}" as="viewWithCondition">
                            {viewWithCondition.key} => array(
                                'config' => array(
                                    <f:for each="{viewWithCondition.condition->sav:Mvc.buildConfiguration()}" as="attribute" key="attributeKey" >
                                    '{attributeKey->sav:toLower()}' => '{attribute}',
                                    </f:for>
                                ),
                            ),
                            </f:for>
                        ),
                    </f:for>
                    ),           
                ),
                'viewTileBars' => array (
                    <f:for each="{extension.views}" as="view" key="viewKey">
                        '{viewKey}' => '{view->sav:getItem(key:'viewTitleBar')}',
                    </f:for>
                ),
                'viewItemTemplates' => array (
                    'listView' => '{extension.views->sav:getItem(key:controller.listView)->sav:getItem(key:'itemTemplate')}',
                    'specialView' => '{extension.views->sav:getItem(key:controller.specialView)->sav:getItem(key:'itemTemplate')}',
                ),
                'folders' => array (
                    <f:for each="{extension.views}" as="view" key="viewKey">
                    '{viewKey}' => array (
                        <f:for each="{view->sav:getItem(key:'folders')}" as="folder" key="folderKey">
                        {folderKey} => array (
                            'label' => '{folder.label}',
                            'configuration' => array (
                                <f:for each="{folder.configuration->sav:Mvc.buildConfiguration()}" as="attribute" key="attributeKey" >
                                '{attributeKey}' => '{attribute}',
                                </f:for>
                            ),
                        ),
                        </f:for>
                    ),        
                    </f:for>
                ),             
            ),
        </f:if>
        ),
        </f:alias>
        </f:for>               
    ),
),

</sav:function></f:format.raw>
