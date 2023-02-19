<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    queryIndex:     '{extension->sav:getItem(key:\'forms\')->sav:getItem(key:itemKey)->sav:getItem(key:\'query\')}'
}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    controllerName: '{extension.forms->sav:getItem(key:itemKey)->sav:getItem(key:\'title\')->sav:upperCamel()}',
    mainTable:      '{extension.queries->sav:getItem(key:queryIndex)->sav:getItem(key:\'mainTable\')}',    
    controller:     '{extension.forms->sav:getItem(key:itemKey)}'
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
namespace {vendorName}\{extensionName}\Controller;
!
use {mainTable->sav:Mvc.buildModelName(extension:extension, removeFirstBackslash:1)};
use {mainTable->sav:Mvc.buildRepositoryName(extension:extension, removeFirstBackslash:1)};
!
/**
 * Controller for the form {controllerName}
 *
 */
final class {controllerName}Controller extends \YolfTypo3\SavLibraryMvc\Controller\DefaultController
{

    /**
     * Main repository
     * 
     * @var <f:format.raw>{mainTable->sav:Mvc.buildRepositoryName(extension:extension, shortName:1)}</f:format.raw>
     */
    protected $mainRepository = null;
!   
    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct({mainTable->sav:Mvc.buildRepositoryName(extension:extension, shortName:1)} $repository)
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
     * @param {mainTable->sav:Mvc.buildModelName(extension:extension, shortName:1)} $data
     * @return void
     */
    public function saveAction({mainTable->sav:Mvc.buildModelName(extension:extension, shortName:1)} $data)
    {
        $this->save($data);
    }
}
</f:alias>
</f:alias>
</sav:function>
