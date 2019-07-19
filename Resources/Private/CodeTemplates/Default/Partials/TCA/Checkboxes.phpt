'config' => [
    'type' => 'check',
    'cols' => 4,
    'items' => [
        <f:for each="{field.items}" as="item" key="itemKey">
            ['LLL:EXT:{extension.general.1.extensionKey}/Resources/Private/Language/locallang_db.xlf:{model}.{field.fieldname}.I.{itemKey}', ''],
        </f:for>
    ],
],