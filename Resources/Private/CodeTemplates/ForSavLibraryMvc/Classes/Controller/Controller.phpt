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
/**
*  Copyright notice
*
*  (c) <f:format.date format="Y">now</f:format.date> {extension.emconf.1.author} <{extension.emconf.1.author_email}>
*
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
 * Controller for the form {controllerName}
 *
 */
!
class {controllerName}Controller extends \YolfTypo3\SavLibraryMvc\Controller\DefaultController
{
!
    /**
     * Main repository
     *
     * @var \{vendorName}\{extensionName}\Domain\Repository\{mainModelName}Repository
     * @inject
     */
    protected $mainRepository = NULL;
!
    /**
     * Subform repository class names
     *
     * @var array
     */
    protected $subforms = array (
        <f:for each="{sav:Mvc.SubformIndexManager(action:'getSubforms')}" as="subform">
        array (
            'repository' => '{vendorName}\\{extensionName}\\Domain\\Repository\\{subform.tableName}Repository',
            'fieldName' => '{subform.fieldName}',
            'foreignRepository' => '{vendorName}\\{extensionName}\\Domain\\Repository\\{subform.foreignTableName}Repository',
        ),
        </f:for>
    );
 !
    /**
     * Save action for this controller
     *
     * @param \{vendorName}\{extensionName}\Domain\Model\{mainModelName} $data
     * @return void
     */
    public function saveAction(\{vendorName}\{extensionName}\Domain\Model\{mainModelName} $data)
    {
        $this->save($data);
    }
}
?>
</f:alias>
</f:alias>
</sav:function>
