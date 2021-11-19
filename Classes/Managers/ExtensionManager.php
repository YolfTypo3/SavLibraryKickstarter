<?php

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\PathUtility;
use TYPO3\CMS\Core\Information\Typo3Version;
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

        $typo3Version = GeneralUtility::makeInstance(Typo3Version::class);
        if (version_compare($typo3Version->getVersion(), '11.0', '<')) {
            $fileName = $this->fileHandlingUtility->createZipFileFromExtension($extensionKey);
        } else {
            $fileName = $this->createZipFileFromExtension($extensionKey);
        }
        $this->sendZipFileToBrowserAndDelete($fileName);
    }

    /**
     * Sends a zip file to the browser and deletes it afterwards
     *
     * Code taken from extensionmanager (sendZipFileToBrowserAndDelete is no more a public method)
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

    /**
     * Creates a zip file from an extension
     *
     * Code taken from extensionmanager (createZipFileFromExtension is no more a public method)
     *
     * @param string $extensionKey
     * @return string Name and path of create zip file
     */
    protected function createZipFileFromExtension(string $extensionKey): string
    {
        $extensionDetails = $this->installUtility->enrichExtensionWithDetails($extensionKey);
        $extensionPath = $extensionDetails['packagePath'];

        // Add trailing slash to the extension path, getAllFilesAndFoldersInPath explicitly requires that.
        $extensionPath = PathUtility::sanitizeTrailingSeparator($extensionPath);

        $version = (string)$extensionDetails['version'];
        if (empty($version)) {
            $version = '0.0.0';
        }

        $temporaryPath = Environment::getVarPath() . '/transient/';
        if (!@is_dir($temporaryPath)) {
            GeneralUtility::mkdir($temporaryPath);
        }
        $fileName = $temporaryPath . $extensionKey . '_' . $version . '_' . date('YmdHi', $GLOBALS['EXEC_TIME']) . '.zip';

        $zip = new \ZipArchive();
        $zip->open($fileName, \ZipArchive::CREATE);

        $excludePattern = $GLOBALS['TYPO3_CONF_VARS']['EXT']['excludeForPackaging'];

        // Get all the files of the extension, but exclude the ones specified in the excludePattern
        $files = GeneralUtility::getAllFilesAndFoldersInPath(
            [], // No files pre-added
            $extensionPath, // Start from here
            '', // Do not filter files by extension
            true, // Include subdirectories
            PHP_INT_MAX, // Recursion level
            $excludePattern        // Files and directories to exclude.
            );

        // Make paths relative to extension root directory.
        $files = GeneralUtility::removePrefixPathFromList($files, $extensionPath);
        $files = is_array($files) ? $files : [];

        // Remove the one empty path that is the extension dir itself.
        $files = array_filter($files);

        foreach ($files as $file) {
            $fullPath = $extensionPath . $file;
            // Distinguish between files and directories, as creation of the archive
            // fails on Windows when trying to add a directory with "addFile".
            if (is_dir($fullPath)) {
                $zip->addEmptyDir($file);
            } else {
                $zip->addFile($fullPath, $file);
            }
        }

        $zip->close();
        return $fileName;
    }

}
