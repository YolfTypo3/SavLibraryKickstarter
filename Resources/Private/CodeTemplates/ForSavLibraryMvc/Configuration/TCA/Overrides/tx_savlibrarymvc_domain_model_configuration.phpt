<f:format.raw><sav:utility.removeEmptyLines keepLine="!">
<?php
defined('TYPO3') or die();
!
<f:alias map="{
    pluginSignature:  '{extension.general.1.extensionKey->sav:format.upperCamel()->sav:format.toLower()}_{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()->sav:format.toLower()}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}'
}">
$GLOBALS['TCA']['tx_savlibrarymvc_domain_model_configuration']['ctrl']['EXT']['{extension.general.1.extensionKey}'] = [
    'controllers' => [   
        <f:for each="{extension.forms}" as="form" key="formKey">
        <f:alias map="{
            queryIndex:     '{form.query}',
            vendorName:     '{extension.general.1.vendorName}',
            extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}'           
        }">          
            {formKey} => [
                'name' => '{form.title->sav:format.upperCamel()}',
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
                                    <f:for each="{viewWithCondition.condition->sav:builder.mvc.configuration()}" as="attribute" key="attributeKey" >
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
                        {viewKey} => '{view->sav:utility.getItem(key:'viewTitleBar')->sav:format.addSlashes()}',
                    </f:for>
                ],
                'viewItemTemplates' => [
                    <f:if condition="{form.listView}">
                    {form.listView} => '{extension.views->sav:utility.getItem(key:form.listView)->sav:utility.getItem(key:'itemTemplate')}',
                    </f:if>
                    <f:if condition="{form.specialView}">                    
                    {form.specialView} => '{extension.views->sav:utility.getItem(key:form.specialView)->sav:utility.getItem(key:'itemTemplate')}',
                    </f:if>
                ],
                'folders' => [
                    <f:for each="{extension.views}" as="view" key="viewKey">
                    {viewKey} => [
                        <f:for each="{view->sav:utility.getItem(key:'folders')}" as="folder" key="folderKey">
                        {folderKey} => [
                            'label' => '{folder.label}',
                            'configuration' => [
                                <f:for each="{folder.configuration->sav:builder.mvc.configuration()}" as="attribute" key="attributeKey" >
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
</sav:utility.removeEmptyLines></f:format.raw>
