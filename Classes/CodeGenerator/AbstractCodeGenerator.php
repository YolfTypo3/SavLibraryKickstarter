<?php
namespace SAV\SavLibraryKickstarter\CodeGenerator;

/**
 * Copyright notice
 *
 * (c) 2015 Laurent Foulloy (yolf.typo3@orange.fr)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

/**
 * This abstract class generates the code for a front end plugin.
 *
 * It is based on the same idea developed by Ingmar Schlecht for the extbase_kickstater.
 * Code templates are used to build the file contents. They are processed by a fluid parser.
 */
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;
use SAV\SavLibraryKickstarter\Configuration\ConfigurationManager;

abstract class AbstractCodeGenerator
{

    /**
     * The code templates directory
     *
     * @var string
     */
    protected static $codeTemplatesDirectory = 'Resources/Private/CodeTemplates/Default/';

    /**
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     */
    protected $objectManager;

    /**
     *
     * @var \SAV\SavLibraryKickstarter\Configuration\SectionManager
     */
    protected $sectionManager;

    /**
     *
     * @var string
     */
    protected $extensionDirectory;

    /**
     *
     * @var string
     */
    protected $extensionKey;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct($sectionManager)
    {
        $this->sectionManager = $sectionManager;
        $this->extensionKey = $this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('extensionKey');
        $this->extensionDirectory = PATH_typo3conf . 'ext/' . $this->extensionKey . '/';

        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * Gets the code template directory
     *
     * @return string
     */
    public static function getCodeTemplatesDirectory()
    {
        return static::$codeTemplatesDirectory;
    }

    /**
     * Builds all the files for the extension.
     *
     * @return void
     */
    public function buildExtension()
    {}

    /**
     * Gets the content of a file.
     *
     * @param string $templateFilePath
     *            The relative template file path
     * @return string The file content
     */
    public function getFileContent($templateFilePath)
    {
        $filePath = ExtensionManagementUtility::extPath('sav_library_kickstarter') . static::$codeTemplatesDirectory . $templateFilePath;
        if (! file_exists($filePath)) {
            $filePath = ExtensionManagementUtility::extPath('sav_library_kickstarter') . self::$codeTemplatesDirectory . $templateFilePath;
        }
        $fileContent = file_get_contents($filePath);

        return $fileContent;
    }

    /**
     * Generates a file using a file template.
     *
     * @param string $templateFilePath
     *            The relative template file path
     * @param integer $itemKey
     *            The itemKey used for the file generation
     * @param array $extensionArray
     *            The extension array
     * @return string The parsed file content
     */
    public function generateFile($templateFilePath, $itemKey = NULL, $extensionArray = NULL)
    {
        $arguments = array(
            'extension' => ($extensionArray === NULL ? $this->sectionManager->getItemsAsArray() : $extensionArray)
        );
        if ($itemKey !== NULL) {
            $arguments = array_merge($arguments, array(
                'itemKey' => $itemKey
            ));
        }

        $fileContent = $this->getFileContent($templateFilePath);
        return $this->parse($fileContent, $arguments);
    }

    /**
     * Parses a content
     *
     * @param string $content
     *            The content to parse.
     * @param array $arguments
     *            The arguments for the parser.
     * @param string $nameSpace
     *            The name space.
     * @return string The parsed content
     */
    public function parse($content, $arguments = array(), $nameSpace = '{namespace sav=SAV\\SavLibraryKickstarter\\ViewHelpers}')
    {
        // Gets a standalone view
        $standaloneView = $this->objectManager->get(StandaloneView::class);

        // Sets the partial root paths
        $codeTemplatesPath = ExtensionManagementUtility::extPath('sav_library_kickstarter') . static::$codeTemplatesDirectory;
        $codeDefaultTemplatesPath = ExtensionManagementUtility::extPath('sav_library_kickstarter') . AbstractCodeGenerator::$codeTemplatesDirectory;
        $standaloneView->setPartialRootPaths(array($codeDefaultTemplatesPath, $codeTemplatesPath));

        // Sets the template source
        $standaloneView->setTemplateSource($nameSpace . '<f:format.raw>' . $content . '</f:format.raw>');

        // Assigns the arguments
        $standaloneView->assign('codeTemplatesPath', $codeTemplatesPath);
        $standaloneView->assign('mvc', $this->isMvc());
        foreach ($arguments as $argumentKey => $argument) {
            $standaloneView->assign($argumentKey, $argument);
        }

        // Renders the view
        return $standaloneView->render();
    }

    /**
     * Gets the current library version depending on the library type.
     *
     * @param
     *            none
     * @return integer The library version
     */
    protected function isMvc()
    {
        $libraryType = $this->sectionManager
        ->getItem('general')
        ->getItem(1)
        ->getItem('libraryType');

        switch ($libraryType) {
            case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                return FALSE;
            case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                return TRUE;
            case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                return TRUE;
            default:
                throw new RuntimeException('The library type "' . $libraryType . '" is not known !');
        }
    }

}
?>
