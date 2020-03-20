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
    {
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
    }
! 
<f:comment>Do not remove</f:comment>
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
!    
    /**
     * Adds a cascading style Sheet
     *
     * @param string $cascadingStyleSheet
     *
     * @return void
     */
    protected function addCascadingStyleSheet($cascadingStyleSheet)
    {
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile($cascadingStyleSheet);
    }     
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
    {
        $extensionWebPath = PathUtility::getAbsoluteWebPath(ExtensionManagementUtility::extPath($extension));
        if ($extensionWebPath[0] === '/') {
            // Makes the path relative
            $extensionWebPath = substr($extensionWebPath, 1);
        }
        return $extensionWebPath;
    }
!    
    /**
     * Gets the TYPO3 version
     *
     * @todo Will be removed in TYPO3 11
     *
     * @return string
     */
    public static function getTypo3Version()
    {
        if (class_exists(\TYPO3\CMS\Core\Information\Typo3Version::class)) {
            $typo3Version = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class)->getVersion();
        } else {
            // @extensionScannerIgnoreLine
            $typo3Version = TYPO3_version;
        }
        return $typo3Version;
    }     
}
?>
</f:alias>
</sav:function>
