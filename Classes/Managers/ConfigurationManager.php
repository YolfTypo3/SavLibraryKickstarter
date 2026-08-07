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

namespace YolfTypo3\SavLibraryKickstarter\Managers;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use YolfTypo3\SavLibraryKickstarter\CodeGenerator;
use YolfTypo3\SavLibraryKickstarter\CodeGenerator\AbstractCodeGenerator;
use YolfTypo3\SavLibraryKickstarter\Controller\KickstarterController;

/**
 * Configuration manager
 *
 * @package Kickstarter
 */
final class ConfigurationManager
{

    /**
     * Constants
     */
    const CONFIGURATION_DIRECTORY = 'Configuration/Kickstarter/';

    const CONFIGURATION_FILE_NAME = 'Kickstarter';

    const LIBRARY_TYPE_FILE_NAME = 'LibraryType.txt';

    const UGRADE_DIRECTORY = 'Classes/Upgrade/';

    const UPGRADE_ROOT_CLASS_NAME = 'YolfTypo3\\SavLibraryKickstarter\\Upgrade\\';

    const LOCAL_DOCUMENTATION_INDEX_FILE = 'Result/project/0.0.0/Index.html';

    const LOCAL_DOCUMENTATION_ERROR_FILE = 'Result/project/0.0.0/_buildinfo/warnings.txt';

    // Library types
    const TYPE_SAV_LIBRARY_PLUS = 1;

    const TYPE_SAV_LIBRARY_MVC = 2;

    const TYPE_SAV_LIBRARY_BASIC = 3;

    // Compatibility
    const COMPATIBILITY_TYPO3_13x_14x = '13x-14x';
    const COMPATIBILITY_TYPO3_13x = '13x';
    const COMPATIBILITY_TYPO3_12x_13x = '12x-13x';
    const COMPATIBILITY_TYPO3_12x = '12x';
    const COMPATIBILITY_TYPO3_11x = '11x';

    /**
     *
     * @var string
     */
    protected static string $extensionKey;

    /**
     *
     * @var KickstarterController
     */
    protected KickstarterController $kickstarterController;

    /**
     *
     * @var SectionManager
     */
    protected ?SectionManager $sectionManager = null;

    /**
     *
     * @var AbstractCodeGenerator
     */
    protected ?AbstractCodeGenerator $codeGenerator = null;

    /**
     *
     * @var ExtensionManager
     */
    protected ?ExtensionManager $extensionManager = null;

    /**
     *
     * @var array
     */
    protected ?array $upgradeFiles = null;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct(string $extensionKey, KickstarterController $kickstarterController)
    {
        self::$extensionKey = $extensionKey;
        $this->kickstarterController = $kickstarterController;
    }

    /**
     * changes the extension key.
     *
     * @param string $extensionKey
     *
     * @return void
     */
    public function changeExtensionKey(string $extensionKey): void
    {
        self::$extensionKey = $extensionKey;
    }
    
    /**
     * Gets the controller.
     *
     * @return KickstarterController
     */
    public function getKickstarterController(): KickstarterController
    {
        return $this->kickstarterController;
    }

    /**
     * Gets the section manager.
     *
     * @ param bool $createSectionManager
     *
     * @return SectionManager
     */
    public function getSectionManager($createSectionManager = false): ?SectionManager
    {
        if ($createSectionManager) {
            $this->sectionManager = new SectionManager();
        }
        return $this->sectionManager;
    }

    /**
     * Sets the section manager.
     *
     * @param array $sections
     *
     * @return void
     */
    public function setSectionManager(array $sections = []): void
    {
        $this->sectionManager = new SectionManager($sections);
    }

    /**
     * Gets the code generator.
     *
     * @return AbstractCodeGenerator
     */
    public function getCodeGenerator(): AbstractCodeGenerator
    {
        if ($this->codeGenerator === null) {
            $type = 'CodeGeneratorFor' . $this->getCurrentLibraryName();
            $this->codeGenerator = GeneralUtility::makeInstance(CodeGenerator::class . '\\' . $type);
            $this->codeGenerator->setConfigurationManager($this);
        }
        return $this->codeGenerator;
    }

    /**
     * Gets the code generator.
     *
     * @return ExtensionManager
     */
    public function getExtensionManager(): ExtensionManager
    {
        if ($this->extensionManager === null) {
            $this->extensionManager = GeneralUtility::makeInstance(ExtensionManager::class, self::$extensionKey);
        }
        return $this->extensionManager;
    }

    /**
     * Gets the configuration.
     *
     * @return array The configuration
     */
    public function getConfiguration(): array
    {
        return $this->getSectionManager()->getItemsAsArray();
    }

    /**
     * Gets the SAV Library Kickstarter Version.
     *
     * @return string The SAV Library Kickstarter Version
     */
    public static function getSavLibraryKickstarterVersion(): string
    {
        return ExtensionManagementUtility::getExtensionVersion('sav_library_kickstarter');
    }

    /**
     * Gets the SAV Library Plus Version.
     *
     * @return string The SAV Library Version
     */
    public static function getSavLibraryPlusVersion(): string
    {
        return self::getExtensionVersion('sav_library_plus');
    }

    /**
     * Gets the SAV Library MVC Version.
     *
     * @return string The SAV Library MVC Version
     */
    public static function getSavLibraryMvcVersion(): string
    {
        return self::getExtensionVersion('sav_library_mvc');
    }

    /**
     * Gets the extension directory.
     *
     * @param string $extensionKey
     *            The extension key
     *
     * @return string The directory
     */
    public static function getExtensionDir(string $extensionKey): string
    {
        if (ExtensionManagementUtility::isLoaded($extensionKey)) {
            $fileName =  'EXT:' . $extensionKey . '/ext_localconf.php' ;
            $absFileName = GeneralUtility::getFileAbsFileName($fileName);
            
            return dirname($absFileName) . '/';
        } else {
            // Gets the settings
            $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
            $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
            $packagesDirectory = Environment::getProjectPath() . '/' . $settings['packagesDirectory'];

            return $packagesDirectory . '/' . $extensionKey . '/';
        }

    }

    /**
     * Gets the extension version.
     *
     * @param string $extensionKey
     *            The extension key
     *
     * @return string The version
     */
    public static function getExtensionVersion(string $extensionKey): string
    {
        if (empty($extensionKey)) {
            return '';
        } else {
            if (ExtensionManagementUtility::isLoaded($extensionKey) && ! self::isSavLibraryKickstarterExtension()) {
                return ExtensionManagementUtility::getExtensionVersion($extensionKey);
            } else {
                // Tries a default name
                $extensionConfigurationFileName = self::getExtensionDir($extensionKey) . 'ext_emconf.php';
            }
            // Opens the file if it exists
            if (file_exists($extensionConfigurationFileName)) {
                $_EXTKEY = $extensionKey;
                require ($extensionConfigurationFileName);
                return $EM_CONF[$_EXTKEY]['version'];
            } else {
                return '';
            }
        }
    }

    /**
     * Creates the root directory for the extension.
     *
     * @param string $extensionKey
     *            The extension key
     *
     * @return void
     */
    public static function createConfigurationDir(string $extensionKey): void
    {
        $configurationDirectory = self::getExtensionDir($extensionKey) . self::CONFIGURATION_DIRECTORY;
        if (! is_dir($configurationDirectory)) {
            GeneralUtility::mkdir_deep($configurationDirectory);
        }
    }

    /**
     * Checks if the extension was created with the SAV Library Kickstarter.
     *
     * @return bool
     */
    public static function isSavLibraryKickstarterExtension(): bool
    {
        $configurationFileName = self::getConfigurationFileName();
        if ($configurationFileName === null) {
            return false;
        }

        return file_exists($configurationFileName);
    }

    /**
     * Checks if the configuration file exists for a given extension and a given library type.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $libraryName
     *            The library name
     *
     * @return bool
     */
    public function configurationFileExists(string $extensionKey, string $libraryName): bool
    {
        $configurationFileName = self::getExtensionDir($extensionKey) . self::CONFIGURATION_DIRECTORY . $libraryName . '/' . self::CONFIGURATION_FILE_NAME . '.json';

        return file_exists($configurationFileName);
    }

    /**
     * Checks if the extension is loaded.
     *
     * @param string $extensionKey
     *            The extension key
     *
     * @return bool
     */
    public function isLoadedExtension(?string $extensionKey = null): bool
    {
        if ($extensionKey === null) {
            $extensionKey = self::$extensionKey;
        }
        return ExtensionManagementUtility::isLoaded($extensionKey);
    }

    /**
     * Loads the configuration.
     *
     * @return void
     */
    public function loadConfiguration(string $version = ''): void
    {
        // Checks if the file exists
        if (self::isSavLibraryKickstarterExtension()) {
            if ($this->getSectionManager() === null) {
                if ($version != '') {
                    $fileName = self::getConfigurationFileName(self::$extensionKey, $version);
                } else {
                    $fileName = self::getConfigurationFileName();
                }
                $sections = json_decode(GeneralUtility::getURL($fileName), true);
                $this->sectionManager = new SectionManager($sections);
            }
        }
    }

    /**
     * Saves the configuration.
     *
     * @return void
     */
    public function saveConfiguration(): void
    {
        $version = $this->getSectionManager()
            ->getItem('emconf')
            ->getItem(1)
            ->getItem('version');
        // Saves the configuration with a version
        $this->saveConfigurationVersion($version);
        // Saves the working configuration
        $this->saveConfigurationVersion();
    }

    /**
     * Saves the configuration.
     *
     * @param string $version
     *            The version
     *
     * @return void
     */
    public function saveConfigurationVersion(string $version = ''): void
    {
        $configuration = $this->getConfiguration();
        $jsonContent = json_encode($configuration, JSON_PRETTY_PRINT);
        $fileName = self::getConfigurationFileName(self::$extensionKey, $version);
        GeneralUtility::writeFile($fileName, $jsonContent);
    }

    /**
     * Gets the current library version depending on the library type.
     *
     * @return string The library version
     */
    public function getCurrentLibraryVersion(): string
    {
        $libraryType = $this->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->getItem('libraryType');

        switch ($libraryType) {
            case self::TYPE_SAV_LIBRARY_PLUS:
                return self::getSavLibraryPlusVersion();
            case self::TYPE_SAV_LIBRARY_MVC:
                return self::getSavLibraryMVCVersion();
            case self::TYPE_SAV_LIBRARY_BASIC:
                return '';
            default:
                throw new \RuntimeException('The library type "' . $libraryType . '" is not known !');
        }
    }

    /**
     * Gets the current library name depending on the library type.
     *
     * @return string The current library name
     */
    public function getCurrentLibraryName(): string
    {
        $libraryType = (int) $this->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->getItem('libraryType');

        return self::getLibraryName($libraryType);
    }

    /**
     * Gets the library name depending on the library type.
     *
     * @param int $libraryType
     *
     * @return string The library name
     */
    public static function getLibraryName(int $libraryType): string
    {
        switch ($libraryType) {
            case self::TYPE_SAV_LIBRARY_PLUS:
                return 'SavLibraryPlus';
            case self::TYPE_SAV_LIBRARY_MVC:
                return 'SavLibraryMvc';
            case self::TYPE_SAV_LIBRARY_BASIC:
                return 'SavLibraryBasic';
            default:
                throw new \RuntimeException('The library type "' . $libraryType . '" is not known !');
        }
    }

    /**
     * Gets the library type file name.
     *
     * @param string $extensionKey
     *            The extension key
     * @return string The configuration file name
     */
    public static function getLibraryTypeFileName(string $extensionKey): string
    {
        return self::getExtensionDir($extensionKey) . self::CONFIGURATION_DIRECTORY . self::LIBRARY_TYPE_FILE_NAME;
    }

    /**
     * Builds the configuration directory if needed.
     *
     * @param string $extensionKey
     *            The extension key
     * @param int $libraryType
     *            The library type
     *
     * @return void
     */
    public function buildConfigurationDirectory(string $extensionKey, int $libraryType): void
    {
        // Builds the new configuration directory
        $extensionDirectory = self::getExtensionDir($extensionKey);
        $libraryName = self::getLibraryName($libraryType);
        $configurationDirectory = $extensionDirectory . self::CONFIGURATION_DIRECTORY . $libraryName . '/';

        if (! is_dir($configurationDirectory)) {
            GeneralUtility::mkdir_deep($configurationDirectory);
        }
    }

    /**
     * Gets the configuration file name.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $version
     *            Version
     *
     * @return string|null The configuration file name
     */
    public static function getConfigurationFileName(?string $extensionKey = null, string $version = ''): ?string
    {
        if ($extensionKey === null) {
            $extensionKey = self::$extensionKey;
        }
        $libraryTypeFileName = self::getLibraryTypeFileName($extensionKey);
        if (! file_exists($libraryTypeFileName)) {
            return null;
        }

        $libraryName = trim(GeneralUtility::getURL($libraryTypeFileName));

        // Builds the version if any
        if ($version != '') {
            $version = '_' . str_replace('.', '_', $version);
        }

        // Builds the file name
        $fileName = self::getExtensionDir($extensionKey) .
            self::CONFIGURATION_DIRECTORY . $libraryName . '/' .
            self::CONFIGURATION_FILE_NAME . $version . '.json';

        return $fileName;
    }

    /**
     * Checks if an extension should be upgraded.
     *
     * @return void
     */
    public function checkForUpgrade(): void
    {
        $this->loadConfiguration();
        $upgrades = $this->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->addItem('upgrades')
            ->getItemsAsArray();
        if (self::isSavLibraryKickstarterExtension()) {
            // Checks if upgrade files must be applied
            $files = GeneralUtility::getFilesInDir(self::getExtensionDir('sav_library_kickstarter') . self::UGRADE_DIRECTORY);
            foreach ($files as $file) {
                $match = [];
                if (preg_match('/^UpgradeTo([A-Za-z]+)_([0-9_]+)\.php$/', $file, $match)) {
                    $toExtension = $match[1];
                    $newVersion = $match[2];
                    $currentVersion = self::getExtensionVersion(generalUtility::camelCaseToLowerCaseUnderscored($toExtension));
                    $newVersionNumber = VersionNumberUtility::convertVersionNumberToInteger(str_replace('_', '.', $newVersion));
                    $currentVersionNumber = VersionNumberUtility::convertVersionNumberToInteger(str_replace('_', '.', $currentVersion));
                    $className = self::UPGRADE_ROOT_CLASS_NAME . basename($file, '.php');

                    if ($newVersionNumber >= $currentVersionNumber && ($upgrades[$className] ?? false) !== true) {
                        $upgrades[$className] = false;
                        // Sets extensionMustbeUpgraded to true
                        $this->getSectionManager()
                            ->getItem('general')
                            ->getItem(1)
                            ->replace([
                            'extensionMustbeUpgraded' => true
                        ]);
                    }
                }
            }

            // Replaces the upgrades
            $this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->getItem('upgrades')
                ->replace($upgrades);

            // Checks if library version, if any, has changed
            $newLibraryVersionNumber = VersionNumberUtility::convertVersionNumberToInteger($this->getCurrentLibraryVersion());
            $currentlibraryVersionNumber = VersionNumberUtility::convertVersionNumberToInteger($this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->getItem('libraryVersion'));
            if ($newLibraryVersionNumber != $currentlibraryVersionNumber) {
                // Sets extensionMustbeUpgraded to true
                $this->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->replace([
                    'extensionMustbeUpgraded' => true,
                    'libraryVersionMustbeUpgraded' => true
                ]);
            }

            // Changes the extension version if needed
            $extensionVersion = $this->getExtensionVersion(self::$extensionKey);
            if ($this->getSectionManager()
                ->getItem('emconf')
                ->getItem(1)
                ->getItem('version') != $extensionVersion) {
                $this->getSectionManager()
                    ->getItem('emconf')
                    ->getItem(1)
                    ->replace([
                    'version' => $extensionVersion
                ]);
            }

            // Checks the compatibillity
            $compatibility = $this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->getItem('compatibility');
            if (is_null($compatibility)) {
                $this->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->replace([
                    'extensionMustbeUpgraded' => true
                ]);
            }
                   
            $wrongCompatibility = ! in_array($compatibility, $this->kickstarterController->getCompatibilityKeys());
            $this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->replace([
                'wrongCompatibility' => $wrongCompatibility
            ]);

            $this->saveConfiguration();
        }
    }

    /**
     * Upgrades an extension to a new version.
     *
     * @return void
     */
    public function upgradeExtension(): void
    {
        if (self::isSavLibraryKickstarterExtension()) {
            $this->loadConfiguration();
            $upgrades = $this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->addItem('upgrades')
                ->getItemsAsArray();

            // Executes the upgrade files
            foreach ($upgrades as $upgradeKey => $upgrade) {
                if ($upgrade === false) {
                    $upgradeManager = GeneralUtility::makeInstance($upgradeKey, self::$extensionKey);
                    $upgradeManager->setConfigurationManager($this);
                    $upgradeManager->preProcessing($this->getSectionManager());
                    $sectionsToDelete = [];
                    foreach ($this->getSectionManager()->getItems() as $sectionName => $section) {
                        $method = 'upgrade' . ucfirst($sectionName) . 'Section';
                        if (method_exists($upgradeManager, $method)) {
                            $upgradedSection = $upgradeManager->$method($section);

                            // Processes the section
                            if (($upgradedSection['deleteSection'] ?? false) === true) {
                                $sectionsToDelete[] = $sectionName;
                            } else {

                                // Defines the replacement method
                                if ($upgradedSection['replacementMethod'] ?? false) {
                                    $replacementMethod = $upgradedSection['replacementMethod'];
                                    unset($upgradedSection['replacementMethod']);
                                } else {
                                    $replacementMethod = 'replace';
                                }

                                if (method_exists($section, $replacementMethod)) {
                                    $section->$replacementMethod($upgradedSection);
                                } else {
                                    throw new \RuntimeException('The method "' . $replacementMethod . '" for the replacement does not exists!');
                                }
                            }
                        }
                    }
                    // Deletes sections if requested
                    foreach ($sectionsToDelete as $sectionName) {
                        $this->getSectionManager()
                            ->getItems()
                            ->deleteItem($sectionName);
                    }

                    $upgradeManager->postProcessing($this->getSectionManager());
                    $upgrades[$upgradeKey] = true;
                }
            }

            // Replaces the upgrades
            $this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->addItem('upgrades')
                ->replace($upgrades);

            // Upgrades the library version if needed
            $libraryVersionMustbeUpgraded = $this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->getItem('libraryVersionMustbeUpgraded');
            if ($libraryVersionMustbeUpgraded) {

                $this->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->replace([
                    'libraryVersion' => $this->getCurrentLibraryVersion()
                ]);
            }

            // Sets extensionMustbeUpgraded to false
            $this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->replace([
                'extensionMustbeUpgraded' => false,
                'libraryVersionMustbeUpgraded' => false
            ]);

            $extensionVersion = self::getExtensionVersion(self::$extensionKey);
            $this->saveConfigurationVersion($extensionVersion);
            $this->saveConfigurationVersion();
        }
    }
}
