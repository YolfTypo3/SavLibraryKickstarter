<sav:utility.removeEmptyLines keepLine="!">
<?php
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    tableName:      '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'tablename\')}',
    modelName:      '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'tablename\')->sav:format.upperCamel()}',
    fields:         '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'fields\')}',
    tableType:      'new'
}">

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
 * {modelName} model for the extension {extensionName}
 *
 */

use YolfTypo3\SavLibraryMvc\Domain\Model\DefaultModel;
!
class {modelName} extends DefaultModel
{
    /**
     * @var \{vendorName}\{extensionName}\Domain\Repository\{modelName}Repository
     */
    protected $repository = null;
!
    <f:for each="{fields}" as="field">
    <f:if condition="{field.type} != 'ShowOnly'">
    
    <f:variable name="type"><f:spaceless><f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Types/{field.type}.t', default:'Partials/Model/Types/Default.t')}" arguments="{_all}" /></f:spaceless></f:variable>  
    <f:variable name="lowerCamelFieldName">{field.fieldname->sav:format.lowerCamel()}</f:variable>  
    
    /**
     * The <{lowerCamelFieldName}> variable.
     *
     * @var {type}
        <f:if condition="{field.validationRules}">
        <f:then>
     * @Extbase\Validate({field.validationRules})
        </f:then>
        <f:else>
     * <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/ValidationRules/PhpDoc/{field.type}.t', default:'Partials/Model/ValidationRules/PhpDoc/Default.t')}" arguments="{_all}" />
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
    <f:if condition="{field.type} != 'ShowOnly'">    
        <sav:utility.indent count="8"><f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Constructor/{field.type}.phpt', default:'Partials/Model/Constructor/Default.phpt')}" arguments="{_all}" /></sav:utility.indent>
    </f:if>
    </f:for>
    }
!
    <f:for each="{fields}" as="field">
    <f:if condition="{field.type} != 'ShowOnly'">

    <f:variable name="type"><f:spaceless><f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Types/{field.type}.t', default:'Partials/Model/Types/Default.t')}" arguments="{_all}" /></f:spaceless></f:variable>  
    <f:variable name="lowerCamelFieldName">{field.fieldname->sav:format.lowerCamel()}</f:variable>  
    <f:variable name="upperCamelFieldName">{field.fieldname->sav:format.upperCamel()}</f:variable>  

    <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Methods/{field.type}.phpt', default:'Partials/Model/Methods/Default.phpt')}" arguments="{_all}" /> 
    </f:if>
    </f:for>
}
</f:alias>
</sav:utility.removeEmptyLines>