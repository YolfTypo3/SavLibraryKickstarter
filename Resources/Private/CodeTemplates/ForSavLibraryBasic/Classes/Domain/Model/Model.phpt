<sav:utility.removeEmptyLines keepLine="!">
<?php
!
<f:alias map="{
    vendorName:       '{extension.general.1.vendorName}',
    extensionName:    '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    tableName:        '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'tablename\')}',
    modelName:        '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'tablename\')->sav:format.upperCamel()}',
    fields:           '{extension.newTables->sav:utility.getItem(key:itemKey)->sav:utility.getItem(key:\'fields\')}'
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

class {modelName} extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    <f:for each="{fields}" as="field">
    /**
     * The {field.fieldname->sav:format.lowerCamel()} variable.
     *
     * <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Variables/PhpDoc/{field.type}.t', default:'Partials/Model/Variables/PhpDoc/Default.t')}" arguments="{_all}" />
     */
    protected ${field.fieldname->sav:format.lowerCamel()};
!    
    </f:for>
    
    /**
     * Constructor.
     */
    public function __construct()
    {
    <f:for each="{fields}" as="field">
        <sav:utility.indent count="8"><f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Constructor/{field.type}.phpt', default:'Partials/Model/Constructor/Default.phpt')}" arguments="{_all}" /></sav:utility.indent>
    </f:for>
    }
!
    <f:for each="{fields}" as="field">    
    /**
     * Getter for {field.fieldname->sav:format.lowerCamel()}.
     *
     * <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Getters/PhpDoc/{field.type}.t', default:'Partials/Model/Getters/PhpDoc/Default.t')}" arguments="{_all}" />
     */
    public function get{field.fieldname->sav:format.upperCamel()}()
    {
        <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Getters/ExtensionScannerIgnoreLine/{field.fieldname->sav:format.upperCamel()}.t', default:'Partials/Model/Getters/ExtensionScannerIgnoreLine/Default.t')}" arguments="{_all}" />       
        <sav:utility.indent count="8">
        <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Getters/Return/{field.type}.phpt', default:'Partials/Model/Getters/Return/Default.phpt')}" arguments="{_all}" />
        </sav:utility.indent>
    }
!
    /**
     * Setter for {field.fieldname->sav:format.lowerCamel()}.
     *
     * <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Setters/PhpDoc/{field.type}.t', default:'Partials/Model/Setters/PhpDoc/Default.t')}" arguments="{_all}" />
     * @return void
     */
    public function set{field.fieldname->sav:format.upperCamel()}(${field.fieldname->sav:format.lowerCamel()})
    {
        <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Getters/ExtensionScannerIgnoreLine/{field.fieldname->sav:format.upperCamel()}.t', default:'Partials/Model/Getters/ExtensionScannerIgnoreLine/Default.t')}" arguments="{_all}" />       
        <sav:utility.indent count="8">
        <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Setters/Return/{field.type}.phpt', default:'Partials/Model/Setters/Return/Default.phpt')}" arguments="{_all}" />
        </sav:utility.indent>
    }    
!
    <f:render partial="{sav:utility.useDefault(fileName:'Partials/Model/Methods/{field.type}.phpt', default:'Partials/Model/Methods/Default.phpt')}" arguments="{_all}" /> 
  </f:for>
    
}
</f:alias>
</sav:utility.removeEmptyLines>