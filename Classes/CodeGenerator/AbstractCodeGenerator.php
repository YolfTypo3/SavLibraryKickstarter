<?php
namespace YolfTypo3\SavLibraryKickstarter\CodeGenerator;

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
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use YolfTypo3\SavLibraryKickstarter\Compatibility\EnvironmentCompatibility;
use YolfTypo3\SavLibraryKickstarter\Controller\KickstarterController;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

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
     * @var \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager
     */
    protected $sectionManager;

    /**
     *
     * @var KickstarterController
     */
    protected $controller;

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

        // Gets the path, including when the extension is not loaded
        $this->extensionDirectory = EnvironmentCompatibility::getTypo3ConfPath() . 'ext/' . $this->extensionKey . '/';

        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
    }

    /**
     * Injects the controller
     *
     * @param KickstarterController $controller
     */
    public function injectController(KickstarterController $controller)
    {
        $this->controller = $controller;
    }

    /**
     * Builds composer.json.
     *
     * @return void
     */
    protected function buildComposer()
    {
        $fileContents = $this->generateFile('composer.jsont');
        GeneralUtility::writeFile($this->extensionDirectory . 'composer.json', $fileContents);
    }

    /**
     * Builds icons files.
     *
     * @return void
     */
    protected function buildIcons()
    {
        // Generates the Resources/Public/Icons directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Resources/Public/Icons/');

        // Generates the icons
        $this->generateFile('icons.t');

        // Builds the page TSconfig the Wizard Icon if any
        if ($this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('addWizardPluginIcon')) {
            GeneralUtility::mkdir_deep($this->extensionDirectory . '/Configuration/TsConfig/Page/Mod/Wizards/');

            $fileContents = $this->generateFile('Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfigt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/TsConfig/Page/Mod/Wizards/NewContentElement.tsconfig', $fileContents);
        }
    }

    /**
     * Builds the Configuration/TCA file(s).
     *
     * @return void
     */
    protected function buildConfigurationTCA()
    {
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Configuration/TCA/');

        // For TCA, files are written during the generation
        $this->generateFile('Configuration/TCA/tca.phpt');
    }

    /**
     * Builds ext_emconf.php.
     *
     * @return void
     */
    protected function buildExtEmConf()
    {
        $fileContents = $this->generateFile('extEmconf.phpt');
        GeneralUtility::writeFile($this->extensionDirectory . 'ext_emconf.php', $fileContents);
    }

    /**
     * Builds ext_localconf.php.
     *
     * @return void
     */
    protected function buildExtLocalConf()
    {
        if (! $this->sectionManager->getItem('general')
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
    protected function buildExtTablesFiles()
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
    protected function buildConfigurationFlexform()
    {
        // Generates the Configuration/Flexforms directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Configuration/Flexforms/');

        // Generates the extension flexform
        $fileContents = $this->generateFile('Configuration/Flexforms/ExtensionFlexform.xmlt');
        GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Flexforms/ExtensionFlexform.xml', $fileContents);
    }

    /**
     * Builds Language files.
     *
     * @return void
     */
    protected function buildLanguageFiles()
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
     * Builds Documentation files.
     *
     * @return void
     */
    protected function buildDocumentation()
    {
        // Generates the Documentation directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/');
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/Introduction/');
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/Changelog/');
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/Images/');

        // Documentation/Settings.cfg
        if (! $this->sectionManager->getItem('documentation')
            ->getItem(1)
            ->getItem('keepSettingsCfg') || ($this->sectionManager->getItem('documentation')
            ->getItem(1)
            ->getItem('keepSettingsCfg') && ! file_exists($this->extensionDirectory . 'Documentation/Settings.cfg'))) {
            $fileContents = $this->generateFile('Documentation/Settings.cfgt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Settings.cfg', $fileContents);
        }
        // docker-compose.yml
        if ($this->sectionManager->getItem('documentation')
            ->getItem(1)
            ->getItem('AddDockerCompose')) {
            $fileContents = $this->generateFile('docker-compose.ymlt');
            GeneralUtility::writeFile($this->extensionDirectory . 'docker-compose.yml', $fileContents);
        }
        // Documentation/Includes.txt
        if (! file_exists($this->extensionDirectory . 'Documentation/Includes.txt')) {
            $fileContents = $this->generateFile('Documentation/Includes.txtt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Includes.txt', $fileContents);
        }
        // Documentation/Index.rst
        if (! file_exists($this->extensionDirectory . 'Documentation/Index.rst')) {
            $fileContents = $this->generateFile('Documentation/Index.rstt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Index.rst', $fileContents);
        }

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
    public function buildExtension()
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
        $controllerExtensionKey = $this->controller->getControllerContext()
            ->getRequest()
            ->getControllerExtensionKey();
        $filePath = ExtensionManagementUtility::extPath($controllerExtensionKey) . static::$codeTemplatesDirectory . $templateFilePath;
        if (! file_exists($filePath)) {
            $filePath = ExtensionManagementUtility::extPath($controllerExtensionKey) . self::$codeTemplatesDirectory . $templateFilePath;
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
    public function generateFile(string $templateFilePath, int $itemKey = null, array $extensionArray = null): string
    {
        $arguments = [
            'extension' => ($extensionArray === null ? $this->sectionManager->getItemsAsArray() : $extensionArray)
        ];
        if ($itemKey !== null) {
            $arguments = array_merge($arguments, [
                'itemKey' => $itemKey
            ]);
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
    public function parse(string $content, array $arguments = [], string $nameSpace = '{namespace sav=YolfTypo3\\SavLibraryKickstarter\\ViewHelpers}'): string
    {
        // Gets a standalone view
        $standaloneView = $this->objectManager->get(StandaloneView::class);

        // Sets the partial root paths
        $controllerExtensionKey = $this->controller->getControllerContext()
            ->getRequest()
            ->getControllerExtensionKey();
        $codeTemplatesPath = ExtensionManagementUtility::extPath($controllerExtensionKey) . static::$codeTemplatesDirectory;
        $codeDefaultTemplatesPath = ExtensionManagementUtility::extPath($controllerExtensionKey) . AbstractCodeGenerator::$codeTemplatesDirectory;
        $standaloneView->setPartialRootPaths([
            $codeDefaultTemplatesPath,
            $codeTemplatesPath
        ]);

        // Sets the template source
        $standaloneView->setTemplateSource($nameSpace . '<f:format.raw>' . $content . '</f:format.raw>');

        // Assigns the arguments
        $standaloneView->assign('codeTemplatesPath', $codeTemplatesPath);
        $standaloneView->assign('mvc', $this->isMvc());
        $standaloneView->assign('libraryName', $this->getLibraryName());
        foreach ($arguments as $argumentKey => $argument) {
            $standaloneView->assign($argumentKey, $argument);
        }

        // Renders the view
        return $standaloneView->render();
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
            $controllerExtensionKey = $this->controller->getControllerContext()
                ->getRequest()
                ->getControllerExtensionKey();
            $message = LocalizationUtility::translate('kickstarter.error.vendorNameMissing', $controllerExtensionKey);
            $this->controller->addFlashMessage($message, '', AbstractMessage::ERROR);
            return false;
        }
        return true;
    }
}
?>
