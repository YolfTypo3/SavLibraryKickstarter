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
use TYPO3\CMS\Core\Utility\PathUtility;
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
     * Class for install
     *
     * @var InstallUtility
     */
    protected $installUtility;

    /**
     * Class for file handling
     *
     * @var FileHandlingUtility
     */
    protected $fileHandlingUtility;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct(string $extensionKey)
    {
        $this->extensionKey = $extensionKey;
        $this->installUtility = GeneralUtility::makeInstance(InstallUtility::class);
        $this->fileHandlingUtility = GeneralUtility::makeInstance(FileHandlingUtility::class);
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
        $this->sendZipFileToBrowserAndDelete($fileName);
    }

    /**
     * Sends a zip file to the browser and deletes it afterwards
     * Method copied from \TYPO3\CMS\Extensionmanager\Controller\ActionController
     *
     * @param string $fileName
     */
    protected function sendZipFileToBrowserAndDelete(string $fileName): void
    {
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($fileName));
        header('Content-Disposition: attachment; filename="' . PathUtility::basename($fileName) . '"');
        readfile($fileName);
        unlink($fileName);
        die;
    }
}
?>
