<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}"><f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    tableName:      '{extension.existingTables->sav:getItem(key:itemKey)->sav:getItem(key:\'tablename\')}',
    modelName:      '{extension.existingTables->sav:getItem(key:itemKey)->sav:getItem(key:\'tablename\')->sav:upperCamel()}',
    fields:         '{extension.existingTables->sav:getItem(key:itemKey)->sav:getItem(key:\'fields\')}'
}">

<f:variable name="extends"><f:switch expression="{tableName}">
    <f:case value="fe_users">\YolfTypo3\SavLibraryMvc\Domain\Model\FrontendUser</f:case>
    <f:case value="fe_groups">\YolfTypo3\SavLibraryMvc\Domain\Model\FrontendUserGroup</f:case>
    <f:defaultCase>\YolfTypo3\SavLibraryMvc\Domain\Model\DefaultModel</f:defaultCase>
</f:switch></f:variable>
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
namespace {vendorName}\{extensionName}\Domain\Model;
!
/**
 * {modelName} model for the extension "{extension.general.1.extensionKey}".
 *
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
!
class {modelName} extends {extends}
{
    /**
     * @var \{vendorName}\{extensionName}\Domain\Repository\{modelName}Repository
     */
    protected $repository = null;
!
    <f:for each="{fields}" as="field">
    <f:if condition="{field.type} != 'ShowOnly' || {field.conf_override_type}">

    <f:variable name="type"><f:spaceless><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Types/{field.type}.t', default:'Partials/Model/Types/Default.t')}" arguments="{_all}" /></f:spaceless></f:variable>  
    <f:variable name="lowerCamelFieldName">{field.fieldname->sav:lowerCamel()}</f:variable>  

    /**
     * The <{lowerCamelFieldName}> variable.
     *
     * @var {type}
        <f:if condition="{field.validationRules}">
        <f:then>
     * @Extbase\Validate({field.validationRules})
        </f:then>
        <f:else>
     * <sav:function name="removeLineFeed" arguments="{replacement:'\n     * '}"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/ValidationRules/PhpDoc/{field.type}.t', default:'Partials/Model/ValidationRules/PhpDoc/Default.t')}" arguments="{_all}" /></sav:function>
        </f:else>
        </f:if>
     */
    protected ${lowerCamelFieldName};
!
    </f:if>
	</f:for>

    /**
     * Constructor.
     */
    public function __construct()
    {
    <f:for each="{fields}" as="field">
    <f:if condition="{field.type} != 'ShowOnly' || {field.conf_override_type}">
        <sav:indent count="8"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Constructor/{field.type}.phpt', default:'Partials/Model/Constructor/Default.phpt')}" arguments="{_all}" /></sav:indent>
    </f:if>
    </f:for>
    }

    <f:for each="{fields}" as="field">
    <f:if condition="{field.type} != 'ShowOnly' || {field.conf_override_type}">

    <f:variable name="type"><f:spaceless><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Types/{field.type}.t', default:'Partials/Model/Types/Default.t')}" arguments="{_all}" /></f:spaceless></f:variable>  
    <f:variable name="lowerCamelFieldName">{field.fieldname->sav:lowerCamel()}</f:variable>  
    <f:variable name="upperCamelFieldName">{field.fieldname->sav:upperCamel()}</f:variable>  

    <f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Methods/{field.type}.phpt', default:'Partials/Model/Methods/Default.phpt')}" arguments="{_all}" /> 
    </f:if>
    </f:for>
	
}
</f:alias>
</sav:function>
