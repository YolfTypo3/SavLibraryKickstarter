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
                        <sav:indent count="32"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/TCA/EXTDefault/{field.type}{view.type->sav:upperCamel()}View.phpt', default:'Partials/TCA/EXTDefault/Default{view.type->sav:upperCamel()}View.phpt')}" arguments="{_all}" /></sav:indent>
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
    ),
),

</sav:function></f:format.raw>
