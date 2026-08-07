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

namespace YolfTypo3\SavLibraryKickstarter\CodeGenerator;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use YolfTypo3\SavLibraryKickstarter\Controller\KickstarterController;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Managers\SectionManager;
use PhpParser\Node\Name\Relative;

abstract class AbstractCodeGenerator
{

    /**
     * The code templates directory
     *
     * @var string
     */
    protected static string $codeTemplatesDirectory = 'Resources/Private/CodeTemplates/Default/';

    /**
     *
     * @var SectionManager
     */
    protected SectionManager $sectionManager;

    /**
     *
     * @var KickstarterController
     */
    protected KickstarterController $controller;

    /**
     *
     * @var string
     */
    protected string $extensionDirectory;

    /**
     *
     * @var string
     */
    protected string $extensionKey;

    /**
     * Sets the configuration manager
     *
     * @param ConfigurationManager $configurationManager
     *
     * @return void
     */
    public function setConfigurationManager(ConfigurationManager $configurationManager): void
    {
        // Sets the section manager
        $this->sectionManager = $configurationManager->getSectionManager();

        // Sets the extension key
        $this->extensionKey = $this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('extensionKey');

        // Gets the path, including when the extension is not loaded
        $this->extensionDirectory = ConfigurationManager::getExtensionDir($this->extensionKey);

        // Sets the controller
        $this->controller = $configurationManager->getKickstarterController();
    }


    /**
     * Builds composer.json.
     *
     * @return void
     */
    protected function buildComposer(): void
    {
        $fileContents = $this->generateFile('composer.jsont');
        GeneralUtility::writeFile($this->extensionDirectory . 'composer.json', $fileContents);
    }

    /**
     * Builds icons files.
     *
     * @return void
     */
    protected function buildIcons(): void
    {
        // Generates the Resources/Public/Icons directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Resources/Public/Icons/');

        // Generates the icons
        $this->generateFile('icons.t');
        
        // Generates Configuration/Icons.php
        if (! file_exists($this->extensionDirectory . 'Configuration/Icons.php')) {
            $fileContents = $this->generateFile('Configuration/Icons.phpt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Icons.php', $fileContents);
        }
    }

    /**
     * Builds the Configuration/Sets file(s).
     *
     * @return void
     */
    protected function buildConfigurationSets(): void
    {       
        // Creates the directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Configuration/Sets/Default');
        
        // Builds config.yaml
        if (! file_exists($this->extensionDirectory . 'Configuration/Sets/Default/config.yaml')) {            
            $fileContents = $this->generateFile('Configuration/Sets/Default/config.yamlt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Sets/Default/config.yaml', $fileContents);
        }
        // Builds constants.typoscript
        if (! file_exists($this->extensionDirectory . 'Configuration/Sets/Default/constants.typoscript')) {
            $fileContents = $this->generateFile('Configuration/Sets/Default/constants.typoscriptt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Sets/Default/constants.typoscript', $fileContents);
        }
        // Builds setup.typoscript
        if (! file_exists($this->extensionDirectory . 'Configuration/Sets/Default/setup.typoscript')) {
            $fileContents = $this->generateFile('Configuration/Sets/Default/setup.typoscriptt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Sets/Default/setup.typoscript', $fileContents);
        }
        // Builds settings.definitions.yaml
        if (! file_exists($this->extensionDirectory . 'Configuration/Sets/Default/settings.definitions.yaml')) {
            $fileContents = $this->generateFile('Configuration/Sets/Default/settings.definitions.yamlt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Sets/Default/settings.definitions.yaml', $fileContents);
        }
    }
    
       
    /**
     * Builds the Configuration/TCA file(s).
     *
     * @return void
     */
    protected function buildConfigurationTCA(): void
    {
        // Removes existing directories
        GeneralUtility::rmdir($this->extensionDirectory . 'Configuration/TCA', true);

        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Configuration/TCA/');

        // For TCA, files are written during the generation
        $this->generateFile('Configuration/TCA/tca.phpt');
    }
 
    /**
     * Builds the Configuration/page.tsconfig.
     *
     * @return void
     */
    protected function buildConfigurationPageTsConfig(): void
    {
        // Builds the page TSconfig
        if (! file_exists($this->extensionDirectory . 'Configuration/page.tsconfig')) {
            $fileContents = $this->generateFile('Configuration/page.tsconfigt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/page.tsconfig', $fileContents);
        }
    }

    /**
     * Builds ext_emconf.php.
     *
     * @return void
     */
    protected function buildExtEmConf(): void
    {
        $fileContents = $this->generateFile('extEmconf.phpt');
        GeneralUtility::writeFile($this->extensionDirectory . 'ext_emconf.php', $fileContents);
        
    }

    /**
     * Builds ext_localconf.php.
     *
     * @return void
     */
    protected function buildExtLocalConf(): void
    {
        if ($this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('BuildMigration') &&
            file_exists($this->extensionDirectory . 'ext_localconf.php')) {
            if (! file_exists($this->extensionDirectory . 'ext_localconf.save')) {
                $fileContents = GeneralUtility::getUrl($this->extensionDirectory . 'ext_localconf.php');
                GeneralUtility::writeFile($this->extensionDirectory . 'ext_localconf.save', $fileContents);
            }
            $fileContents = $this->generateFile('extLocalconf.phpt');
            GeneralUtility::writeFile($this->extensionDirectory . 'ext_localconf.php', $fileContents);
        } elseif ($this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('keepExtLocalConf') &&
            file_exists($this->extensionDirectory . 'ext_localconf.php')) {
            $fileContents = GeneralUtility::getUrl($this->extensionDirectory . 'ext_localconf.php');
            GeneralUtility::writeFile($this->extensionDirectory . 'ext_localconf.save', $fileContents);
        } elseif (! $this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('keepExtLocalConf') || ($this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('keepExtLocalConf') && ! file_exists($this->extensionDirectory . 'ext_localconf.php'))) {
            $fileContents = $this->generateFile('extLocalconf.phpt');
            GeneralUtility::writeFile($this->extensionDirectory . 'ext_localconf.php', $fileContents);
        }
    }

    /**
     * Builds ext_tables files.
     *
     * @return void
     */
    protected function buildExtTablesFiles(): void
    {
        // Generates ext_tables.sql
        $fileContents = $this->generateFile('extTables.sqlt');
        GeneralUtility::writeFile($this->extensionDirectory . 'ext_tables.sql', $fileContents);

        // Generates ext_tables.php
        $fileContents = $this->generateFile('extTables.phpt');
        GeneralUtility::writeFile($this->extensionDirectory . 'ext_tables.php', $fileContents);
    }

    /**
     * Builds the Configuration Flexforms file.
     *
     * @return void
     */
    protected function buildConfigurationFlexform(): void
    {
        // Generates the Configuration/Flexforms directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Configuration/Flexforms/');

        // Generates the extension flexform
        $fileContents = $this->generateFile('Configuration/Flexforms/ExtensionFlexform.xmlt');
        GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Flexforms/ExtensionFlexform.xml', $fileContents);
    }

    /**
     * Builds the Configuration/Services.yaml file.
     *
     * @return void
     */
    protected function buildConfigurationServices(): void
    {
        // Generates Services.yaml file if it does not exist
        if (! file_exists($this->extensionDirectory . 'Configuration/Services.yaml')) {
            $fileContents = $this->generateFile('Configuration/Services.yamlt');
            if (!empty($fileContents)) {
                GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Services.yaml', $fileContents);
            }
        }
    }

    /**
     * Builds Language files.
     *
     * @return void
     */
    protected function buildLanguageFiles(): void
    {
        // Generates the Resources/Private/Language directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Resources/Private/Language/');

        // Generates locallang.xlf file if it does not exist
        if (! file_exists($this->extensionDirectory . 'Resources/Private/Language/locallang.xlf')) {
            $fileContents = $this->generateFile('Resources/Private/Language/locallang.xlft');
            GeneralUtility::writeFile($this->extensionDirectory . 'Resources/Private/Language/locallang.xlf', $fileContents);
        }

        // Generates locallang_db.xlf file
        $fileContents = $this->generateFile('Resources/Private/Language/locallang_db.xlft');
        GeneralUtility::writeFile($this->extensionDirectory . 'Resources/Private/Language/locallang_db.xlf', $fileContents);
    }
    
    /**
     * Builds Updates files.
     *
     * @return void
     */
    protected function buildUpdatesFiles(): void
    {
        $typo3Version = new (Typo3Version::class);
        if ($typo3Version->getMajorVersion() >= 13) {
            GeneralUtility::rmdir($this->extensionDirectory . 'Classes/Updates/', true);
        } else {
            // Generates the Classes/Updates directory
            GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Updates/');
            
            // Generates the PluginListTypeToCTypeUpdate.php file
            $fileContents = $this->generateFile('Classes/Updates/PluginListTypeToCTypeUpdate.phpt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Classes/Updates/PluginListTypeToCTypeUpdate.php', $fileContents);
        }
    }
    
    /**
     * Builds Documentation files.
     *
     * @return void
     */
    protected function buildDocumentation(): void
    {
        // Generates the documentation directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/');
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/Introduction/');
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/Changelog/');
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/Images/');
        
        $fileContents = $this->generateFile('Documentation/guides.xmlt');
        GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/guides.xml', $fileContents);
        
        // Documentation/Includes.txt
        if (! file_exists($this->extensionDirectory . 'Documentation/Includes.txt')) {
            $fileContents = $this->generateFile('Documentation/Includes.txtt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Includes.txt', $fileContents);
        }

        // Documentation/Index.rst
        $fileContents = $this->generateFile('Documentation/Index.rstt');
        GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Index.rst', $fileContents);

        // Documentation/Sitemap.rst
        $fileContents = $this->generateFile('Documentation/Sitemap.rstt');
        GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Sitemap.rst', $fileContents);

        // Documentation/Introduction/Index.rst
        if (! file_exists($this->extensionDirectory . 'Documentation/Introduction/Index.rst')) {
            $fileContents = $this->generateFile('Documentation/Introduction/Index.rstt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Introduction/Index.rst', $fileContents);
        }

        // Documentation/Changelog/Index.rst
        if (! file_exists($this->extensionDirectory . 'Documentation/Changelog/Index.rst')) {
            $fileContents = $this->generateFile('Documentation/Changelog/Index.rstt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Changelog/Index.rst', $fileContents);
        }

        // Documentation/EntityRelationshipDiagram
        GeneralUtility::rmdir($this->extensionDirectory . 'Documentation/EntityRelationshipDiagram', true);

        if ($this->sectionManager->getItem('documentation')
            ->getItem(1)
            ->getItem('AddEntityRelationshipDiagram')) {

            GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/EntityRelationshipDiagram/');

            $fileContents = $this->generateFile('Documentation/EntityRelationshipDiagram/Index.rstt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/EntityRelationshipDiagram/Index.rst', $fileContents);
        }
    }

    /**
     * Removes the directory
     *
     * @param string directoryName
     * @return void
     */
    protected function removeDirectory(string $directoryName): void
    {
        GeneralUtility::rmdir($this->extensionDirectory . $directoryName, true);
    }


    /**
     * Gets the code template directory
     *
     * @return string
     */
    public static function getCodeTemplatesDirectory(): string
    {
        return static::$codeTemplatesDirectory;
    }

    /**
     * Builds all the files for the extension.
     *
     * @return void
     */
    public function buildExtension(): void
    {}

    /**
     * Gets the content of a file.
     *
     * @param string $templateFilePath
     *            The relative template file path
     * @return string The file content
     */
    public function getFileContent(string $templateFilePath): string
    {
        $controllerExtensionKey = $this->controller
            ->getRequest()
            ->getControllerExtensionKey();
        $compatibility = $this->sectionManager->getItem('general')->getItem(1)->getItem('compatibility');

        $dirName = pathinfo($templateFilePath, PATHINFO_DIRNAME);
        $templateFileName = pathinfo($templateFilePath, PATHINFO_FILENAME);
        $templateFileExtension = pathinfo($templateFilePath, PATHINFO_EXTENSION);
        $filePath = ExtensionManagementUtility::extPath($controllerExtensionKey) . static::$codeTemplatesDirectory . $dirName . '/' . $templateFileName . $compatibility . '.' . $templateFileExtension;

        if (! file_exists($filePath)) {
            $filePath = ExtensionManagementUtility::extPath($controllerExtensionKey) . static::$codeTemplatesDirectory . $templateFilePath;
            if(! file_exists($filePath)) {
                // Try to find it in the default directory
                $filePath = ExtensionManagementUtility::extPath($controllerExtensionKey) . self::$codeTemplatesDirectory . $dirName . '/' . $templateFileName . $compatibility . '.' . $templateFileExtension;
                if(! file_exists($filePath)) {
                    $filePath = ExtensionManagementUtility::extPath($controllerExtensionKey) . self::$codeTemplatesDirectory . $templateFilePath;
                    if(! file_exists($filePath)) {
                        return '';
                    }
                }
            }
        }
        $fileContent = file_get_contents($filePath);

        return $fileContent;
    }

    /**
     * Generates a file using a file template.
     *
     * @param string $templateFilePath
     *            The relative template file path
     * @param int $itemKey
     *            The itemKey used for the file generation
     * @param array $extensionArray
     *            The extension array
     * @return string The parsed file content
     */
    public function generateFile(string $templateFilePath, ?int $itemKey = null, ?array $extensionArray = null): string
    {
        $arguments = [
            'extension' => ($extensionArray === null ? $this->sectionManager->getItemsAsArray() : $extensionArray),
            'isMvc' => $this->isMvc()
        ];

        if ($itemKey !== null) {
            $arguments = array_merge($arguments, [
                'itemKey' => $itemKey
            ]);
        }

        $fileContent = $this->getFileContent($templateFilePath);
        if (empty($fileContent)) {
            return '';
        } else {
            return $this->parse($fileContent, $arguments);
        }
    }

    /**
     * Parses a content
     *
     * @param string $content
     *            The content to parse.
     * @param array $arguments
     *            The arguments for the parser.
     * @return string The parsed content
     */
    public function parse(string $content, array $arguments = []): string
    {
       
        // Gets a standalone view
        $template = '<f:format.raw>' . $content . '</f:format.raw>';
        $view = $this->createView($template, false);

        // Assigns the arguments
        $view->assign('isMvc', $this->isMvc());
        $view->assign('libraryName', $this->getLibraryName());
        foreach ($arguments as $argumentKey => $argument) {
            $view->assign($argumentKey, $argument);
        }

        // Renders the view
        return $view->render();
    }

    /**
     * Creates the view
     *
     * @param string $template
     * @param string $isTemplateFile
     *
     * @return mixed
     */
    protected function createView(string $templateSource): mixed
    {
        // Defines the paths
        $controllerExtensionKey = $this->controller
            ->getRequest()
            ->getControllerExtensionKey();
        $codeTemplatesPath = ExtensionManagementUtility::extPath($controllerExtensionKey) . static::$codeTemplatesDirectory;
        $codeDefaultTemplatesPath = ExtensionManagementUtility::extPath($controllerExtensionKey) . AbstractCodeGenerator::$codeTemplatesDirectory;

        $viewFactory = GeneralUtility::makeInstance(ViewFactoryInterface::class);
        $viewFactoryData = new (ViewFactoryData::class)(
            partialRootPaths: [
                $codeDefaultTemplatesPath,
                $codeTemplatesPath
            ],
            request: $this->controller->getRequest(),
            );
        
        $view = $viewFactory->create($viewFactoryData);
        $view->getRenderingContext()->getTemplatePaths()->setTemplateSource($templateSource);
        $view->assign('codeTemplatesPath', $codeTemplatesPath);
        
        return $view;

    }
     
    /**
     * Checks if the library type is mvc.
     *
     * @return bool
     */
    protected function isMvc(): bool
    {
        $libraryType = $this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('libraryType');

        switch ($libraryType) {
            case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                return false;
            case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                return true;
            case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                return true;
            default:
                throw new \RuntimeException('The library type "' . $libraryType . '" is not known !');
        }
    }

    /**
     * Gets the current library version name.
     *
     * @return string The library name
     */
    protected function getLibraryName(): string
    {
        $libraryType = $this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('libraryType');

        switch ($libraryType) {
            case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                return 'SavLibraryPlus';
            case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                return 'SavLibraryMvc';
            case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                return 'SavLibraryBasic';
            default:
                throw new \RuntimeException('The library type "' . $libraryType . '" is not known !');
        }
    }

    /**
     * Checks if the extension can be built.
     *
     * @return bool True if the extension can be built
     */
    protected function CanBuildExtension(): bool
    {
        // Checks if the vendor name is set
        $vendorName = $this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('vendorName');

        if (empty($vendorName)) {
            $controllerExtensionKey = $this->controller
                ->getRequest()
                ->getControllerExtensionKey();
            $message = LocalizationUtility::translate('kickstarter.error.vendorNameMissing', $controllerExtensionKey);
            $this->controller->addFlashMessage($message, '', ContextualFeedbackSeverity::ERROR);
            return false;
        }
        return true;
    }
    
}
