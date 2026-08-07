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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\File;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

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
 */
final class SaveContentToFileViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('content', 'string', 'Content to save', false, '');
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
        $this->registerArgument('fileName', 'string', 'File name', true);
        $this->registerArgument('directory', 'string', 'Directory to create', false, '');
        $this->registerArgument('doNotCreateIfFileExists', 'bool', 'If true, the file is not created ', false, false);
    }

    /**
     * Saves the content into the file
     *
     * @return void
     */
    public function render(): void
    {
        // Gets the arguments
        $content = $this->arguments['content'] ?? '';
        $extensionKey = $this->arguments['extensionKey'];
        $fileName = $this->arguments['fileName'];
        $directory = rtrim($this->arguments['directory'], '/');
        $doNotCreateIfFileExists = $this->arguments['doNotCreateIfFileExists'];
        
        // Creates a new directory if needed
        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        if (! empty($directory)) {
            GeneralUtility::mkdir_deep($extensionDirectory . $directory .'/');
        }
        if (! $doNotCreateIfFileExists || ! file_exists($extensionDirectory . $directory . '/' . $fileName)) {
            GeneralUtility::writeFile($extensionDirectory . $directory . '/' . $fileName, $content);
        }
    }
}
