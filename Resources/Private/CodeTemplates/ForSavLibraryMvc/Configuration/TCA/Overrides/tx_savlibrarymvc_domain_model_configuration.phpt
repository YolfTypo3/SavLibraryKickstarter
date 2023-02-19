{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<?php
defined('TYPO3') or die();
<f:format.raw><sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    pluginSignature:  '{extension.general.1.extensionKey->sav:upperCamel()->sav:toLower()}_{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()->sav:toLower()}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}'
}">
$GLOBALS['TCA']['tx_savlibrarymvc_domain_model_configuration']['ctrl']['EXT']['{extension.general.1.extensionKey}'] = [
    'controllers' => [   
        <f:for each="{extension.forms}" as="form" key="formKey">
        <f:alias map="{
            queryIndex:     '{form.query}',
            vendorName:     '{extension.general.1.vendorName}',
            extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}'           
        }">          
            {formKey} => [
                'name' => '{form.title->sav:upperCamel()}',
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
                'viewTitleBars' => [
                    <f:for each="{extension.views}" as="view" key="viewKey">
                        {viewKey} => '{view->sav:getItem(key:'viewTitleBar')->sav:function(name:'addSlashes')}',
                    </f:for>
                ],
                'viewItemTemplates' => [
                    <f:if condition="{form.listView}">
                    {form.listView} => '{extension.views->sav:getItem(key:form.listView)->sav:getItem(key:'itemTemplate')}',
                    </f:if>
                    <f:if condition="{form.specialView}">                    
                    {form.specialView} => '{extension.views->sav:getItem(key:form.specialView)->sav:getItem(key:'itemTemplate')}',
                    </f:if>
                ],
                'folders' => [
                    <f:for each="{extension.views}" as="view" key="viewKey">
                    {viewKey} => [
                        <f:for each="{view->sav:getItem(key:'folders')}" as="folder" key="folderKey">
                        {folderKey} => [
                            'label' => '{folder.label}',
                            'configuration' => [
                                <f:for each="{folder.configuration->sav:Mvc.buildConfiguration()}" as="attribute" key="attributeKey" >
                                '{attributeKey}' => '{attribute}',
                                </f:for>
                            ],
                            'order' => {folder.order},
                        ],
                        </f:for>
                    ], 

                           
                    </f:for>
                ],
                'queryIdentifier' => {queryIndex},            
            ],

        </f:alias>
        </f:for>
    ],    
];
</f:alias>
</sav:function></f:format.raw>
