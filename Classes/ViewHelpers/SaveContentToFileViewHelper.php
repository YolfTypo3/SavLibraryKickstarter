<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

/*
 * This script is part of the TYPO3 project - inspiring people to share! *
 * *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by *
 * the Free Software Foundation. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General *
 * Public License for more details. *
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use YolfTypo3\SavLibraryKickstarter\Configuration\ConfigurationManager;

/**
 * A view helper for saving a content into a file.
 *
 * = Examples =
 *
 * <code title="SaveContentToFile">
 * <sav:saveContentToFile content="Text to save" fileName="fileName" extensionKey="extensionKey"/>
 * </code>
 *
 * Output:
 * None
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class SaveContentToFileViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $content
     *            Content to save
     * @param string $extensionKey
     *            The extension name
     * @param string $directory
     *            Directory to create if not empty
     * @param string $fileName
     *            The file name
     * @return void
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     *         @api
     */
    public function render($content, $extensionKey, $fileName, $directory = '')
    {
        // Creates a new directory if needed
        if (!empty($directory)) {
            $extensionDirectory = PATH_typo3conf . 'ext/' . $extensionKey . '/';
            GeneralUtility::mkdir_deep($extensionDirectory, $directory);
        }
        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        GeneralUtility::writeFile($extensionDirectory . '/' . $fileName, $content);
    }
}
?>

