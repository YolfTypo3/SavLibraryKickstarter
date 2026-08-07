<?php

declare(strict_types=1);

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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\File;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A view helper to get the template file.
 *
 *
 * @package SavLibraryKickstarter
 */
final class GetTemplateFileViewHelper extends AbstractViewHelper
{
    const codeTemplatesRootDirectory = 'Resources/Private/CodeTemplates/';
    
    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('templateFilePath', 'string', 'The file path to process', false, null);       
        $this->registerArgument('extension', 'array', 'Extension configuration', true);
    }

    /**
     * Renders the view helper
     *
     * @return bool
     */
    public function render(): string
    {
        // Gets the arguments
        $templateFilePath = $this->arguments['templateFilePath'];
        $extension = $this->arguments['extension'];

        if ($templateFilePath === null) {
            $templateFilePath = $this->renderChildren();
        }

        $controllerExtensionKey = 'sav_library_kickstarter'; 
        $compatibility = $extension['general'][1]['compatibility'];
        $libraryType = $extension['general'][1]['libraryType'];
        
        $templateDirectoryName = pathinfo($templateFilePath, PATHINFO_DIRNAME);
        $templateFileName = pathinfo($templateFilePath, PATHINFO_FILENAME);
        $templateFileExtension = pathinfo($templateFilePath, PATHINFO_EXTENSION);

        //Tries to find the template in the Library directory with compatibility
        $filePath = $templateDirectoryName . '/' . $templateFileName. $compatibility . '.' . $templateFileExtension;
        if (! file_exists(ExtensionManagementUtility::extPath($controllerExtensionKey) . self::codeTemplatesRootDirectory . $this->getLibraryDirectoryName($libraryType) . $filePath)) {
            //Tries to find the template in the Library directory without compatibility
            $filePath = $templateFilePath;              
            if(! file_exists(ExtensionManagementUtility::extPath($controllerExtensionKey) . self::codeTemplatesRootDirectory . $this->getLibraryDirectoryName($libraryType) . $filePath)) {
                //Tries to find the template in the Default directory with compatibility
                $filePath = $templateDirectoryName . '/' . $templateFileName . $compatibility . '.' . $templateFileExtension;
                if(! file_exists(ExtensionManagementUtility::extPath($controllerExtensionKey) . self::codeTemplatesRootDirectory . $this->getLibraryDirectoryName() . $filePath)) {
                    //Tries to find the template in the Default directory without compatibility                    
                    $filePath = $templateFilePath;
                }
            }
        }

        return $filePath;
    }

    /**
     * Gets the library directory name depending on the library type.
     *
     * @param int $libraryType
     *
     * @return string The library name
     */
    public function getLibraryDirectoryName(int $libraryType = 0): string
    {
        switch ($libraryType) {
            case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                return 'ForSavLibraryPlus/';
            case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                return 'ForSavLibraryMvc/';
            case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                return 'ForSavLibraryBasic/';
            default:
                return 'Default/';
        }
    }
    
}
