<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}"><f:alias map="{
    vendorName:       '{extension.general.1.vendorName}',
    extensionName:    '{extension.general.1.extensionKey->sav:upperCamel()}',
    tableName:        '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'tablename\')}',
    modelName:        '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'tablename\')->sav:upperCamel()}',
    fields:           '{extension.newTables->sav:getItem(key:itemKey)->sav:getItem(key:\'fields\')}'
}">
namespace {vendorName}\{extensionName}\Domain\Model;

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

/**
 * {modelName} model for the extension {extensionName}
 *
 */

class {modelName} extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    <f:for each="{fields}" as="field">
    /**
     * The {field.fieldname->sav:lowerCamel()} variable.
     *
     * <sav:function name="removeLineFeed"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Variables/PhpDoc/{field.type}.t', default:'Partials/Model/Variables/PhpDoc/Default.t')}" arguments="{_all}" /></sav:function>
        <f:if condition="{field.validationRules}">
        <f:then>
     * @validate {field.validationRules}
        </f:then>
        <f:else>
     * <sav:function name="removeLineFeed"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/ValidationRules/PhpDoc/{field.type}.t', default:'Partials/Model/ValidationRules/PhpDoc/Default.t')}" arguments="{_all}" /></sav:function>
        </f:else>
        </f:if>
     */
    protected ${field.fieldname->sav:lowerCamel()};
!    
    </f:for>
    
    /**
     * Constructor.
     */
    public function __construct()
    {
    <f:for each="{fields}" as="field">
        <sav:indent count="8"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Constructor/{field.type}.phpt', default:'Partials/Model/Constructor/Default.phpt')}" arguments="{_all}" /></sav:indent>
    </f:for>
    }
!
    <f:for each="{fields}" as="field">    
    /**
     * Getter for {field.fieldname->sav:lowerCamel()}.
     *
     * <sav:function name="removeLineFeed"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Getters/PhpDoc/{field.type}.t', default:'Partials/Model/Getters/PhpDoc/Default.t')}" arguments="{_all}" /></sav:function>
     */
    public function get{field.fieldname->sav:upperCamel()}()
    {
        <sav:indent count="8">
        <f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Getters/Return/{field.type}.phpt', default:'Partials/Model/Getters/Return/Default.phpt')}" arguments="{_all}" />
        </sav:indent>
    }
!
    /**
     * Setter for {field.fieldname->sav:lowerCamel()}.
     *
     * <sav:function name="removeLineFeed"><f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Setters/PhpDoc/{field.type}.t', default:'Partials/Model/Setters/PhpDoc/Default.t')}" arguments="{_all}" /></sav:function>
     * @return void
     */
    public function set{field.fieldname->sav:upperCamel()}(${field.fieldname->sav:lowerCamel()})
    {
        <sav:indent count="8">
        <f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Setters/Return/{field.type}.phpt', default:'Partials/Model/Setters/Return/Default.phpt')}" arguments="{_all}" />
        </sav:indent>
    }    
!
    <f:render partial="{sav:useDefault(path:'{codeTemplatesPath}', fileName:'Partials/Model/Methods/{field.type}.phpt', default:'Partials/Model/Methods/Default.phpt')}" arguments="{_all}" /> 
  </f:for>
    
}
?>
</f:alias>
</sav:function>
