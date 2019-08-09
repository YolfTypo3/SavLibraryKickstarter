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
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extensionmanager\Utility\InstallUtility;
use TYPO3\CMS\Extensionmanager\Utility\FileHandlingUtility;

/**
 * This class is the interface with the extension manager.
 *
 * @package SavLibraryKickstarter
 */
class ExtensionManager
{

    /**
     *
     * @var string
     */
    protected $extensionKey;

    /**
     *
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Class for install
     *
     * @var InstallUtility
     */
    public $installUtility;

    /**
     * Class for file handling
     *
     * @var FileHandlingUtility
     */
    public $fileHandlingUtility;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct(string $extensionKey)
    {
        $this->extensionKey = $extensionKey;
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->installUtility = $this->objectManager->get(InstallUtility::class);
        $this->fileHandlingUtility = $this->objectManager->get(FileHandlingUtility::class);
    }

    /**
     * Installs the extension.
     *
     * @param string $extensionKey
     * @return void
     */
    public function installExtension(string $extensionKey = null)
    {
        if ($extensionKey === null) {
            $extensionKey = $this->extensionKey;
        }

        $this->installUtility->install($extensionKey);
    }

    /**
     * Uninstalls the extension
     *
     * @param string $extensionKey
     * @return void
     */
    public function uninstallExtension(string $extensionKey = null)
    {
        if ($extensionKey === null) {
            $extensionKey = $this->extensionKey;
        }

        $this->installUtility->uninstall($extensionKey);
    }

    /**
     * Downloads the extension
     *
     * @param string $extensionKey
     * @return void
     */
    public function downloadExtension(string $extensionKey = null)
    {
        if ($extensionKey === null) {
            $extensionKey = $this->extensionKey;
        }

        $fileName = $this->fileHandlingUtility->createZipFileFromExtension($extensionKey);
        $this->fileHandlingUtility->sendZipFileToBrowserAndDelete($fileName);
    }

    /**
     * Checks the if database must be updated.
     * If true a flash message is added.
     *
     * @param string $extensionKey
     * @return void
     */
    public function checkDbUpdate(string $extensionKey = null)
    {
        if ($extensionKey === null) {
            $extensionKey = $this->extensionKey;
        }

        $extension = $this->installUtility->enrichExtensionWithDetails($extensionKey);
        $this->installUtility->processDatabaseUpdates($extension);
    }
}
?>
