<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    queryIndex:     '{extension->sav:getItem(key:\'forms\')->sav:getItem(key:itemKey)->sav:getItem(key:\'query\')}'
}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    controllerName: '{extension.forms->sav:getItem(key:itemKey)->sav:getItem(key:\'title\')->sav:upperCamel()}',
    mainModelName:  '{extension.queries->sav:getItem(key:queryIndex)->sav:getItem(key:\'mainTable\')->sav:Mvc.getModelFromTableName(extension:extension.general.1.extensionKey)}',    
    controller:     '{extension.forms->sav:getItem(key:itemKey)}'
}">
namespace {vendorName}\{extensionName}\Controller;
!
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
use YolfTypo3\SavLibraryMvc\Controller\DefaultController;
use {vendorName}\{extensionName}\Domain\Model\{mainModelName};
use {vendorName}\{extensionName}\Domain\Repository\{mainModelName}Repository;
!
/**
 * Controller for the form {controllerName}
 *
 */
class {controllerName}Controller extends DefaultController
{

    /**
     * Main repository
     * 
     * @var <f:format.raw>{mainModelName}Repository</f:format.raw>
     */
    protected $mainRepository = null;
!   
    /**
     * Injects the repository.
     *
     * @param <f:format.raw>{mainModelName}Repository $repository</f:format.raw>
     */
    public function inject{mainModelName}Repository({mainModelName}Repository $repository)
    {
        $this->mainRepository = $repository;
    }        
!
    /**
     * Subform repository class names
     *
     * @var array
     */
    protected $subforms = [
        <f:for each="{sav:Mvc.SubformIndexManager(action:'getSubforms')}" as="subform">
        [
            'repository' => \{vendorName}\{extensionName}\Domain\Repository\{subform.tableName}Repository::class,
            'fieldName' => '{subform.fieldName}',
            'foreignRepository' => \{vendorName}\{extensionName}\Domain\Repository\{subform.foreignTableName}Repository::class,
        ],
        </f:for>
    ];
 !
    /**
     * Save action for this controller
     *
     * @param {mainModelName} $data
     * @return void
     */
    public function saveAction({mainModelName} $data)
    {
        $this->save($data);
    }
}
?>
</f:alias>
</f:alias>
</sav:function>
