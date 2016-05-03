<?php
<sav:function name="removeEmptyLines" arguments="{keepLine:'!'}">
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:upperCamel()}',
    controllerName: '{extension.forms->sav:getItem()->sav:getItem(key:\'title\')->sav:upperCamel()}',
    actionName:     '{extension.views->sav:getItem()->sav:getItem(key:\'title\')->sav:lowerCamel()}'
}">
namespace {vendorName}\{extensionName}\Controller;
!
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
 * {controllerName} Controller
 *
 */
!
class {controllerName}Controller extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
!
    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    protected function initializeAction() 
    <![CDATA[{
    }]]>
!
    /**
     * {actionName} action
     *
     * @return void
     */
    public function {actionName}Action()
    {  
        $this->view->assign('extension', $this->request->getControllerExtensionKey());         
        $this->view->assign('controller', $this->request->getControllerName());  
        $this->view->assign('action', $this->request->getControllerActionName());                      
    }  
}
?>
</f:alias>
</sav:function>
