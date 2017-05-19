<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}"><f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    modelName:      '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'tablename\')->sav:upperCamel()}',
    fields:         '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'fields\')}'    
}">
<f:alias map="{model:'Tx_{extensionName}_Domain_Model_{modelName}'}">
namespace {vendorName}\{extensionName}\Domain\Repository;
/**
*  Copyright notice
*
*  (c) <f:format.date format="Y">now</f:format.date> {extension.emconf.1.author} <{extension.emconf.1.author_email}>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
*/
!
/**
 * Repository for the {modelName} model in the extension {extensionName}
 *
 */
class {modelName}Repository extends \SAV\SavLibraryMvc\Domain\Repository\DefaultRepository
{
!
<f:for each="{extension.queries}" as="query" key="queryKey">

    <f:if condition="{query.mainTable} == {model->sav:toLower()}">

    <f:if condition="{query.whereClause}">
    /**
     * Defines the where clause
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return void
     */
    protected function whereClause{queryKey}($query)
    {
        <sav:indent count="8">$whereClauseConstraints = <sav:Mvc.buildWhereClause clause="{query.whereClause}" />;
return $whereClauseConstraints;
        </sav:indent>
    }
    </f:if>
!
    <f:if condition="{query.orderByClause}">
    /**
     * Defines the order by clause
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return void
     */
    protected function orderByClause{queryKey}($query)
    {
        <sav:indent count="8"><sav:Mvc.buildOrderByClause clause="{query.orderByClause}" /></sav:indent>
    }
    </f:if>
!
    <f:for each="{query.whereTags}" as="whereTag" key="whereTagKey">
    /**
     * Defines the order by clause associated with the whereTag "{whereTag.title}"
     *
     * @param \TYPO3\CMS\Extbase\Persistence\QueryInterface $query
     * @return void
     */
    protected function orderByClauseForWhereTag{whereTagKey}($query)
    {
        <sav:indent count="8"><sav:Mvc.buildOrderByClause clause="{whereTag.orderByClause}" /></sav:indent>
    }
!
    </f:for>

    <f:if condition="{query.whereTags->f:count()} > 0">
    /**
     * Returns the whereTag from its title
     *
     * @param string $title
     * @return void
     */
    public function getWhereTagByTitle($title) {
        $whereTags = array (
        <f:for each="{query.whereTags}" as="whereTag" key="whereTagKey">
            '{whereTag.title->sav:function(name:'addslashes')}' => {whereTagKey},
        </f:for>
        );
        return $whereTags[$title];
    }
    </f:if>
  
    </f:if>
</f:for>
}

?>
</f:alias>
</f:alias>
</sav:function>
