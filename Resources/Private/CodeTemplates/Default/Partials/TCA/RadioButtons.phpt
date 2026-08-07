'config' => [
    'type' => 'radio',
    'items' => [
        <f:for each="{field.items}" as="item" key="itemKey">
        [
        	'label' => 'LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{field.fieldname}.I.{itemKey}', 
        	'value' => '{item.value}'
        ],
        </f:for>
    ],
],
