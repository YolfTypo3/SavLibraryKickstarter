<?php
namespace YolfTypo3\SavLibraryKickstarter\Compatibility;

/**
 * Copyright notice
 *
 * (c) 2010 Laurent Foulloy (yolf.typo3@orange.fr)
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extensionmanager\Utility\InstallUtility;
use TYPO3\CMS\Extensionmanager\Utility\ListUtility;
use TYPO3\CMS\Extensionmanager\Utility\FileHandlingUtility;

/**
 * This abstract class generates the code for a front end plugin.
 *
 * It is based on the same idea developed by Ingmar Schlecht for the extbase_kickstater.
 * Code templates are used to build the file contents. They are processed by a fluid parser.
 *
 * @package SavLibraryKickstarter
 * @version $ID:$
 */
class ExtensionManagerForTypo3VersionGreaterOrEqualTo6_0
{

    /**
     *
     * @var array
     */
    protected $generalArguments;

    /**
     * Class for install
     *
     * @var \TYPO3\CMS\Extensionmanager\Utility\InstallUtility
     */
    public $installUtility;

    /**
     * Class for file handling
     *
     * @var \TYPO3\CMS\Extensionmanager\Utility\FileHandlingUtility
     */
    public $fileHandlingUtility;

    /**
     * Constructor.
     *
     * return none
     */
    public function __construct($extensionKey)
    {
        $this->extensionKey = $extensionKey;
        $this->installUtility = GeneralUtility::makeInstance(InstallUtility::class);
        $listUtility = GeneralUtility::makeInstance(ListUtility::class);
        $this->installUtility->injectListUtility($listUtility);
        $this->fileHandlingUtility = GeneralUtility::makeInstance(FileHandlingUtility::class);
        $this->installUtility->injectFileHandlingUtility($this->fileHandlingUtility);
    }

    /**
     * injects arguments.
     *
     * return none
     */
    public function injectGeneralArguments($generalArguments)
    {
        $this->generalArguments = $generalArguments;
    }

    /**
     * Installs the extension.
     *
     * @param string $extensionKey
     *            return none
     */
    public function installExtension($extensionKey = NULL)
    {
        if ($extensionKey === NULL) {
            $extensionKey = $this->extensionKey;
        }

        $this->installUtility->install($extensionKey);
    }

    /**
     * Uninstalls the extension
     *
     * @param string $extensionKey
     *            return none
     */
    public function uninstallExtension($extensionKey = NULL)
    {
        if ($extensionKey === NULL) {
            $extensionKey = $this->extensionKey;
        }

        $this->installUtility->uninstall($extensionKey);
    }

    /**
     * Downloads the extension
     *
     * @param string $extensionKey
     *            return none
     */
    public function downloadExtension($extensionKey = NULL)
    {
        if ($extensionKey === NULL) {
            $extensionKey = $this->extensionKey;
        }

        $fileName = $this->fileHandlingUtility->createZipFileFromExtension($extensionKey);
        $this->fileHandlingUtility->sendZipFileToBrowserAndDelete($fileName);
    }

    /**
     * Checks the if database must be updated.
     * If TRUE a flash message is added.
     *
     * @param string $extensionKey
     *            return none
     */
    public function checkDbUpdate($extensionKey = NULL)
    {
        if ($extensionKey === NULL) {
            $extensionKey = $this->extensionKey;
        }

        $extension = $this->installUtility->enrichExtensionWithDetails($extensionKey);
        $this->installUtility->processDatabaseUpdates($extension);
    }

    /**
     * Checks the if database must be updated.
     * If TRUE a flash message is added.
     *
     * @param array $argument
     *            return none
     */
    private function CreateHiddenTag($argument)
    {
        return '<input type="hidden" name="tx_savlibrarykickstarter_' . strtolower(t3lib_div::_GET('M')) . key($argument) . '" value="' . current($argument) . '" />';
    }
}
?>
