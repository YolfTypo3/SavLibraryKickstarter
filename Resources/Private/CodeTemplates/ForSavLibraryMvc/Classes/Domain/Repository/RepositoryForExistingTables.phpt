<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}"><f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    modelName:      '{extension.existingTables->sav:getItem(key:itemKey)->sav:getItem(key:\'tablename\')->sav:upperCamel()}',
    fields:         '{extension.existingTables->sav:getItem(key:itemKey)->sav:getItem(key:\'fields\')}'    
}">
<f:alias map="{model:'Tx_{extensionName}_Domain_Model_{modelName}'}">
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
 * Repository for the {modelName} model in the extension {extensionName}
 *
 */
class {modelName}Repository extends \YolfTypo3\SavLibraryMvc\Domain\Repository\DefaultRepository
{

<f:for each="{extension.queries}" as="query" key="queryKey">

    <f:if condition="{query.mainTable} == {model->sav:toLower()} || {query.mainTable->sav:function(name:'removeUnderscore')} == {modelName->sav:toLower()}">   

    <f:if condition="{query.whereClause}">
!    
    /**
     * Defines the where clause
     *
     * @param QueryInterface $query
     * @return ConstraintInterface
     */
    protected function whereClause{queryKey}(QueryInterface $query): ConstraintInterface
    {
        <sav:indent count="8">$whereClauseConstraints = <sav:Mvc.buildWhereClause clause="{query.whereClause}" />;
return $whereClauseConstraints;
        </sav:indent>
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
        <sav:indent count="8"><sav:Mvc.buildOrderByClause clause="{query.orderByClause}" /></sav:indent>
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
    protected function orderByClauseForWhereTag{whereTagKey}(\TYPO3\CMS\Extbase\Persistence\QueryInterface $query)
    {
        <sav:indent count="8"><sav:Mvc.buildOrderByClause clause="{whereTag.orderByClause}" /></sav:indent>
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
            '{whereTag.title->sav:function(name:'addslashes')}' => {whereTagKey},
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
</sav:function>
