<sav:utility.removeEmptyLines keepLine="!">
<?php
!
declare(strict_types=1);
!
return [
    \YolfTypo3\SavLibraryMvc\Domain\Model\FrontendUser::class => [
        'tableName' => 'fe_users',
    ],
    \YolfTypo3\SavLibraryMvc\Domain\Model\FrontendUserGroup::class => [
        'tableName' => 'fe_groups',   
    ],
<f:for each="{extension.newTables}" as="table">
    {table.tablename->sav:builder.mvc.modelName(extension:extension)}::class => [
        'tableName' => '{sav:builder.tableName(shortName:table.tablename, extensionKey:extension.general.1.extensionKey, mvc:1)}',
    ],
</f:for>         
<f:for each="{extension.existingTables}" as="table">
    {table.tablename->sav:builder.mvc.modelName(extension:extension)}::class => [
        'tableName' => '{table.tablename}',
        'properties' => [
        <f:for each="{table.fields}" as="field">
            <f:if condition="{field.type}!='ShowOnly'">
            '{field.fieldname}' => [
                'fieldName' => 'tx_{extension.general.1.extensionKey->sav:format.removeUnderscore()}_{field.fieldname}',
            ],
            </f:if>
        </f:for>
        ],
    ],
</f:for>
];
</sav:utility.removeEmptyLines>