<sav:utility.removeEmptyLines keepLine="!">
<?php
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    modelName:      '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'tablename\')->sav:format.upperCamel()}',
    fields:         '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'fields\')}'    
}">
<f:alias map="{model:'tx_{extensionName->sav:format.toLower()}_domain_model_{modelName->sav:format.camelCaseToLowerCaseUnderscored()}'}">
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
!
namespace {vendorName}\{extensionName}\Domain\Repository;
!
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\Qom\ConstraintInterface;
!
/**
 * Repository for the model "{modelName}" in the extension "{extension.general.1.extensionKey}"
 *
 */
class {modelName}Repository extends \YolfTypo3\SavLibraryMvc\Domain\Repository\DefaultRepository
{

<f:for each="{extension.queries}" as="query" key="queryKey">

    <f:if condition="{query.mainTable} == {model}">

    <f:if condition="{query.whereClause}">
!    
    /**
     * Defines the where clause
     *
     * @param QueryInterface $query
     * @return ConstraintInterface
     */
    protected function whereClause{queryKey}(QueryInterface $query): ?ConstraintInterface
    {
        <sav:utility.indent count="8">$whereClauseConstraints = <sav:builder.mvc.whereClause clause="{query.whereClause}" />;
return $whereClauseConstraints;
        </sav:utility.indent>
    }
    </f:if>

    <f:if condition="{query.orderByClause}">
!    
    /**
     * Defines the order by clause
     *
     * @param QueryInterface $query
     * @return void
     */
    protected function orderByClause{queryKey}(QueryInterface $query)
    {
        <sav:utility.indent count="8"><sav:builder.mvc.orderByClause clause="{query.orderByClause}" /></sav:utility.indent>
    }
    </f:if>

    <f:for each="{query.whereTags}" as="whereTag" key="whereTagKey">
!    
    /**
     * Defines the order by clause associated with the whereTag "{whereTag.title}"
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return void
     */
    protected function orderByClauseForWhereTag{whereTagKey}(QueryInterface $query)
    {
        <sav:utility.indent count="8"><sav:builder.mvc.orderByClause clause="{whereTag.orderByClause}" /></sav:utility.indent>
    }
    </f:for>

    <f:if condition="{query.whereTags->f:count()} > 0">
!    
    /**
     * Returns the whereTag key from its title
     *
     * @param string $title
     * @return int
     */
    public function getWhereTagByTitle(string $title) : int
    {
        $whereTags = [
        <f:for each="{query.whereTags}" as="whereTag" key="whereTagKey">
            '{whereTag.title->sav:format.addSlashes()}' => {whereTagKey},
        </f:for>
        ];
        return $whereTags[$title];
    }
    </f:if>
  
    </f:if>
</f:for>
}
</f:alias>
</f:alias>
</sav:utility.removeEmptyLines>