<sav:utility.removeEmptyLines keepLine="!">
<?php
!
<f:alias map="{
    vendorName:     '{extension.general.1.vendorName}',
    extensionName:  '{extension.general.1.extensionKey->sav:format.upperCamel()}',
    controllerName: '{extension.forms->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.upperCamel()}',
    actionName:     '{extension.views->sav:utility.getItem()->sav:utility.getItem(key:\'title\')->sav:format.lowerCamel()}',
    openBrace:      '{',
    closeBrace:     '}'        
}">   
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
{
! 
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
	{openBrace} 
        // Gets the extension key
        $extensionKey = $this->request->getControllerExtensionKey();
!         
        // Checks if the static extension template is included
        /** @var FrontendConfigurationManager $frontendConfigurationManager */
        $frontendConfigurationManager = GeneralUtility::makeInstance(FrontendConfigurationManager::class);
        $typoScriptSetup = $frontendConfigurationManager->getTypoScriptSetup();
        $pluginSetupName = 'tx_' . strtolower($this->request->getControllerExtensionName()) . '.';       
        if (! is_array($typoScriptSetup['plugin.'][$pluginSetupName]['view.'] ?? null)) {openBrace} 
            throw new \RuntimeException('You have to include the static template of the extension ' . $extensionKey . '.');
        {closeBrace}
!         
        // Adds the css file
        $extensionWebPath = self::getExtensionWebPath($extensionKey);
        $cssFile = $extensionWebPath . self::$cssPath;
        $this->addCascadingStyleSheet($cssFile);    
	{closeBrace}
! 
<f:comment>Do not remove</f:comment>
    /**
     * {actionName} action
     *
     * @return void|ResponseInterface
     */
    public function {actionName}Action()
	{openBrace}   
        $this->view->assign('extension', $this->request->getControllerExtensionKey());         
        $this->view->assign('controller', $this->request->getControllerName());  
        $this->view->assign('action', $this->request->getControllerActionName());    
!        
        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {openBrace}
            return $this->htmlResponse($this->view->render());
        {closeBrace}                          
	{closeBrace}
!    
    /**
     * Adds a cascading style Sheet
     *
     * @param string $cascadingStyleSheet
     *
     * @return void
     */
    protected function addCascadingStyleSheet($cascadingStyleSheet)
	{openBrace} 
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile($cascadingStyleSheet);
	{closeBrace}    
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
	{openBrace} 
        $extensionWebPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath($extension));
        if ($extensionWebPath[0] === '/') {openBrace}
            // Makes the path relative
            $extensionWebPath = substr($extensionWebPath, 1);
        {closeBrace}
        return $extensionWebPath;
	{closeBrace}     
}  
</f:alias>
</sav:utility.removeEmptyLines>