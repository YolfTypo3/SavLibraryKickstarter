<?php
namespace YolfTypo3\SavLibraryKickstarter\Managers;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use YolfTypo3\SavLibraryKickstarter\CodeGenerator;
use YolfTypo3\SavLibraryKickstarter\Compatibility\EnvironmentCompatibility;
use YolfTypo3\SavLibraryKickstarter\Controller\KickstarterController;
use YolfTypo3\SavLibraryKickstarter\Utility\ItemManager;

/**
 * Configuration manager
 *
 * @package Kickstarter
 */
class ConfigurationManager
{

    /**
     * Constants
     */
    const CONFIGURATION_DIRECTORY = 'Configuration/Kickstarter/';

    const CONFIGURATION_FILE_NAME = 'Kickstarter.json';

    const LIBRARY_TYPE_FILE_NAME = 'LibraryType.txt';

    const UGRADE_DIRECTORY = 'Classes/Upgrade/';

    const UPGRADE_ROOT_CLASS_NAME = 'YolfTypo3\\SavLibraryKickstarter\\Upgrade\\';

    // Library types
    const TYPE_SAV_LIBRARY = 0;

    const TYPE_SAV_LIBRARY_PLUS = 1;

    const TYPE_SAV_LIBRARY_MVC = 2;

    const TYPE_SAV_LIBRARY_BASIC = 3;

    // Compatibility
    const COMPATIBILITY_TYPO3_DEFAULT = 0;

    const COMPATIBILITY_TYPO3_6x = 1;

    const COMPATIBILITY_TYPO3_6x_7x = 2;

    const COMPATIBILITY_TYPO3_7x = 3;

    /**
     *
     * @var KickstarterController
     */
    protected $controller;

    /**
     *
     * @var string
     */
    protected $extensionKey;

    /**
     *
     * @var ItemManager
     */
    protected $sectionManager;

    /**
     *
     * @var \YolfTypo3\SavLibraryKickstarter\CodeGenerator\AbstractCodeGenerator
     */
    protected $codeGenerator = null;

    /**
     *
     * @var ExtensionManager
     */
    protected $extensionManager = null;

    /**
     *
     * @var array
     */
    protected $upgradeFiles = null;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct(string $extensionKey)
    {
        $this->extensionKey = $extensionKey;
        $this->sectionManager = GeneralUtility::makeInstance(ItemManager::class);
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
     * Sets the extension key.
     *
     * @param string $extensionKey
     *            The extension key
     * @return void
     */
    public function setExtensionKey(string $extensionKey)
    {
        $this->extensionKey = $extensionKey;
    }

    /**
     * Gets the section manager.
     *
     * @return ItemManager
     */
    public function getSectionManager(): ItemManager
    {
        return $this->sectionManager;
    }

    /**
     * Gets the code generator.
     *
     * @return \YolfTypo3\SavLibraryKickstarter\CodeGenerator
     */
    public function getCodeGenerator()
    {
        if ($this->codeGenerator === null) {
            $type = 'CodeGeneratorFor' . $this->getCurrentLibraryName();
            $this->codeGenerator = GeneralUtility::makeInstance(CodeGenerator::class . '\\' . $type, $this->getSectionManager());
            $this->codeGenerator->injectController($this->controller);
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
            $this->extensionManager = GeneralUtility::makeInstance(ExtensionManager::class, $this->extensionKey);
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
     * @return string The directory
     */
    public static function getExtensionDir(string $extensionKey): string
    {
        // Gets the path, including when the extension is not loaded
        return EnvironmentCompatibility::getTypo3ConfPath() . 'ext/' . $extensionKey . '/';
    }

    /**
     * Gets the extension version.
     *
     * @param string $extensionKey
     *            The extension key
     * @return string The version
     */
    public static function getExtensionVersion(string $extensionKey): string
    {
        if (empty($extensionKey)) {
            return '';
        } else {
            if (ExtensionManagementUtility::isLoaded($extensionKey)) {
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
     * @return void
     */
    public static function createConfigurationDir(string $extensionKey)
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
    public function isSavLibraryKickstarterExtension(): bool
    {
        return file_exists($this->getConfigurationFileName());
    }

    /**
     * Checks if the configuration file exists for a given extension and a given library type.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $libraryName
     *            The library name
     * @return bool
     */
    public function configurationFileExists(string $extensionKey, string $libraryName): bool
    {
        $extensionDirectory = self::getExtensionDir($extensionKey);
        $configurationFileName = $extensionDirectory . self::CONFIGURATION_DIRECTORY . $libraryName . '/' . self::CONFIGURATION_FILE_NAME;

        return file_exists($configurationFileName);
    }

    /**
     * Checks if the extension is loaded.
     *
     * @param string $extensionKey
     *            The extension key
     * @return bool
     */
    public function isLoadedExtension(string $extensionKey = null): bool
    {
        if ($extensionKey === null) {
            $extensionKey = $this->extensionKey;
        }
        return ExtensionManagementUtility::isLoaded($extensionKey);
    }

    /**
     * Loads the configuration.
     *
     * @return void
     */
    public function loadConfiguration(string $version = '')
    {
        // Checks if the file exists
        if ($this->isSavLibraryKickstarterExtension()) {
            if ($this->getSectionManager()->count() == 0) {
                if ($version != '') {
                    $sections = json_decode(GeneralUtility::getURL($this->getConfigurationFileName($this->extensionKey, $version)), true);
                } else {
                    $sections = json_decode(GeneralUtility::getURL($this->getConfigurationFileName()), true);
                }

                foreach ($sections as $key => $section) {
                    if (is_array($section)) {
                        $this->getSectionManager()->addItem([
                            $key => $section
                        ]);
                    } else {
                        $this->getSectionManager()->addItem($key);
                    }
                }
            }
        }
    }

    /**
     * Saves the configuration.
     *
     * @return void
     */
    public function saveConfiguration()
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
     * Method called by array_walk_recursive to encode fields in utf8 (required by json_encode).
     *
     * @param mixed $item
     *            The item
     * @return string The rendered view
     */
    public static function utf8_encode(&$item)
    {
        if (is_string($item)) {
            $item = utf8_encode($item);
        }
        return $item;
    }

    /**
     * Method called by array_walk_recursive to encode fields in utf8 (required by json_encode).
     *
     * @param mixed $item
     *            The item
     * @return string The rendered view
     */
    public static function utf8_decode(&$item)
    {
        if (is_string($item)) {
            $item = utf8_decode($item);
        }
        return $item;
    }

    /**
     * Saves the configuration.
     *
     * @param string $version
     *            The version
     *
     * @return void
     */
    public function saveConfigurationVersion(string $version = '')
    {
        $configuration = $this->getConfiguration();
        $extensionVersion = self::getExtensionVersion($this->extensionKey);
        $jsonContent = json_encode($configuration);
        $fileName = $this->getConfigurationFileName($this->extensionKey, $version);

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
            case self::TYPE_SAV_LIBRARY:
                return '';
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
        $libraryType = $this->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->getItem('libraryType');
        return self::getLibraryName($libraryType);
    }

    /**
     * Gets the library name depending on the library type.
     *
     * @param int $libraryType
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
        $extensionDirectory = self::getExtensionDir($extensionKey);
        return $extensionDirectory . self::CONFIGURATION_DIRECTORY . self::LIBRARY_TYPE_FILE_NAME;
    }

    /**
     * Builds the configuration directory if needed.
     *
     * @param string $extensionKey
     *            The extension key
     * @param int $libraryType
     *            The library type
     * @return void
     */
    public function buildConfigurationDirectory(string $extensionKey, int $libraryType)
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
     * @return string The configuration file name
     */
    public function getConfigurationFileName(string $extensionKey = null, string $version = ''): string
    {
        if ($extensionKey === null) {
            $extensionKey = $this->extensionKey;
        }
        $extensionDirectory = self::getExtensionDir($extensionKey);
        $libraryName = trim(GeneralUtility::getURL(self::getLibraryTypeFileName($extensionKey)));

        // Builds the version if any
        if ($version != '') {
            $version = '_' . str_replace('.', '_', $version);
        }

        // Builds the file name
        $configurationFileNameParts = pathinfo(self::CONFIGURATION_FILE_NAME);
        $fileName = $configurationFileNameParts['filename'] . $version . '.' . $configurationFileNameParts['extension'];

        return $extensionDirectory . self::CONFIGURATION_DIRECTORY . $libraryName . '/' . $fileName;
    }

    /**
     * Checks if an extension should be upgraded.
     *
     * @return void
     */
    public function checkForUpgrade()
    {
        $this->loadConfiguration();
        $upgrades = $this->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->addItem('upgrades')
            ->getItemsAsArray();
        if ($this->isSavLibraryKickstarterExtension()) {
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

                    if ($newVersionNumber >= $currentVersionNumber && $upgrades[$className] !== true) {
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
            $extensionVersion = $this->getExtensionVersion($this->extensionKey);
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
            $wrongCompatibility = ! in_array($compatibility, [
                ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT,
                ConfigurationManager::COMPATIBILITY_TYPO3_7x
            ]);
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
    public function upgradeExtension()
    {
        if ($this->isSavLibraryKickstarterExtension()) {
            $this->loadConfiguration();
            $upgrades = $this->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->addItem('upgrades')
                ->getItemsAsArray();

            // Executes the upgrade files
            foreach ($upgrades as $upgradeKey => $upgrade) {
                if ($upgrade === false) {
                    $upgradeManager = GeneralUtility::makeInstance($upgradeKey, $this->extensionKey);
                    $upgradeManager->preProcessing($this->getSectionManager());
                    $sectionsToDelete = [];
                    foreach ($this->getSectionManager()->getItems() as $sectionName => $section) {
                        $method = 'upgrade' . ucfirst($sectionName) . 'Section';
                        if (method_exists($upgradeManager, $method)) {
                            $upgradedSection = $upgradeManager->$method($section);

                            // Processes the section
                            if ($upgradedSection['deleteSection'] === true) {
                                $sectionsToDelete[] = $sectionName;
                            } else {

                                // Defines the replacement method
                                if ($upgradedSection['replacementMethod']) {
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
                ->getItem('upgrades')
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

            $extensionVersion = self::getExtensionVersion($this->extensionKey);
            $this->saveConfigurationVersion($extensionVersion);
            $this->saveConfigurationVersion();
        }
    }
}
?>
