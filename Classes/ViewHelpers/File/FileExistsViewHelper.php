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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A view helper to check if a file exists.
 *
 *
 * @package SavLibraryKickstarter
 */
final class FileExistsViewHelper extends AbstractViewHelper
{
    
    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
        $this->registerArgument('fileName', 'string', 'File name', true);
    }

    /**
     * Renders the view helper
     *
     * @return bool
     */
    public function render(): bool
    {
        // Gets the arguments
        $extensionKey = $this->arguments['extensionKey'];
        $fileName = $this->arguments['fileName'];

        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        $fileName = $extensionDirectory . $fileName;

        return @file_exists($fileName);
    }

}
