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
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Configuration\FrontendConfigurationManager;
!
/**
 * {controllerName} Controller
 *
 * @author {extension.emconf.1.author} <{extension.emconf.1.author_email}>
 * @package {extension.general.1.extensionKey}
 */
!
class {controllerName}Controller extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
<sav:function name="leftBrace"/> 
	/**
     * Css path
     *
     * @var string
     */
    protected static $cssPath = 'Resources/Public/Css/{extensionName}.css';
!    
    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    protected function initializeAction() 
	<sav:function name="leftBrace"/>
        // Gets the extension key
        $extensionKey = $this->request->getControllerExtensionKey();
!         
        // Checks if the static extension template is included
        /** @var FrontendConfigurationManager $frontendConfigurationManager */
        $frontendConfigurationManager = GeneralUtility::makeInstance(FrontendConfigurationManager::class);
        $typoScriptSetup = $frontendConfigurationManager->getTypoScriptSetup();
        $pluginSetupName = 'tx_' . strtolower($this->request->getControllerExtensionName()) . '.';       
        if (!@is_array($typoScriptSetup['plugin.'][$pluginSetupName]['view.'])) {
            throw new \Exception('Fatal error: You have to include the static template of the extension ' . $extensionKey . '.');
        }
!         
        // Adds the css file
        $extensionWebPath = self::getExtensionWebPath($extensionKey);
        $cssFile = $extensionWebPath . self::$cssPath;
        $this->addCascadingStyleSheet($cssFile);    
	<sav:function name="rightBrace"/>
! 
<f:comment>Do not remove</f:comment>
    /**
     * {actionName} action
     *
     * @return void|ResponseInterface
     */
    public function {actionName}Action()
	<sav:function name="leftBrace"/>  
        $this->view->assign('extension', $this->request->getControllerExtensionKey());         
        $this->view->assign('controller', $this->request->getControllerName());  
        $this->view->assign('action', $this->request->getControllerActionName());    
!        
        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }                          
	<sav:function name="rightBrace"/>
!    
    /**
     * Adds a cascading style Sheet
     *
     * @param string $cascadingStyleSheet
     *
     * @return void
     */
    protected function addCascadingStyleSheet($cascadingStyleSheet)
	<sav:function name="leftBrace"/>
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile($cascadingStyleSheet);
	<sav:function name="rightBrace"/>    
!    
    /**
     * Gets the relative web path of a given extension.
     *
     * @param string $extension
     *            The extension
     *
     * @return string The relative web path
     */
    protected static function getExtensionWebPath(string $extension): string
	<sav:function name="leftBrace"/>
        $extensionWebPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath($extension));
        if ($extensionWebPath[0] === '/') {
            // Makes the path relative
            $extensionWebPath = substr($extensionWebPath, 1);
        }
        return $extensionWebPath;
	<sav:function name="rightBrace"/>    
<sav:function name="rightBrace"/>  
</f:alias>
</sav:function>
