{namespace sav=YolfTypo3\SavLibraryKickstarter\ViewHelpers}<sav:utility.removeEmptyLines keepLine="!">
<?php
!
declare(strict_types=1);
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
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
!
/**
 * {controllerName} Controller
 *
 * @author {extension.emconf.1.author} <{extension.emconf.1.author_email}>
 * @package {extension.general.1.extensionKey}
 */
!
final class {controllerName}Controller extends ActionController
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
     * Constructor
     */
    public function __construct(
        private readonly FrontendConfigurationManager $frontendConfigurationManager,
        ) {openBrace}
    {closeBrace}    
!    
    /**
     * Initializes the controller before invoking an action method.
     *
     * @return void
     */
    protected function initializeAction(): void 
	{openBrace} 
        // Gets the extension key
        $extensionKey = $this->request->getControllerExtensionKey();
!         
        // Checks if the extension is included in the site configuration
        $lowerCamelExtensionKey = GeneralUtility::underscoredToLowerCamelCase($extensionKey);
        $siteSettings = $this->request->getAttribute('site')->getSettings();
        if (! $siteSettings->has($lowerCamelExtensionKey)) {
            throw new \RuntimeException('You have to include the extension ' . $extensionKey . ' in the site setup.');
        {closeBrace}
!         
        // Adds the css file
        $extensionWebPath = 'EXT:' . $extensionKey . '/';
        $cssFile = $extensionWebPath . self::$cssPath;
        $this->addCascadingStyleSheet($cssFile);    
	{closeBrace}
! 
<f:comment>Do not remove</f:comment>
    /**
     * {actionName} action
     *
     * @return ResponseInterface
     */
    public function {actionName}Action(): ResponseInterface
	{openBrace}   
        $this->view->assign('extension', $this->request->getControllerExtensionKey());         
        $this->view->assign('controller', $this->request->getControllerName());  
        $this->view->assign('action', $this->request->getControllerActionName());    
!        
        return $this->htmlResponse($this->view->render());                         
	{closeBrace}
!    
    /**
     * Adds a cascading style Sheet
     *
     * @param string $cascadingStyleSheet
     *
     * @return void
     */
    protected function addCascadingStyleSheet($cascadingStyleSheet): void
	{openBrace} 
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->addCssFile($cascadingStyleSheet);
	{closeBrace}        
}  
</f:alias>
</sav:utility.removeEmptyLines>