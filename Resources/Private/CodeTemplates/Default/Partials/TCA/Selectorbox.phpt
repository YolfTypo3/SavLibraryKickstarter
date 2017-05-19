'config' => [
    'type' => 'select',
    'renderType' => 'selectSingle',
    'items' => [
    <f:for each="{field.items}" as="item" key="itemKey">
        ['LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{field.fieldname}.I.{itemKey}', '{item.value}'],
    </f:for>
    ],
    'size' => 1,
    'maxitems' => 1,
],