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
 * A view helper for copying a file.
 *
 *
 * @package SavLibraryKickstarter
 */
final class CopyFileViewHelper extends AbstractViewHelper
{
    
    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('source', 'string', 'Source file', true);
        $this->registerArgument('sourceExtension', 'string', 'Extension for the source file', false, null);
        $this->registerArgument('destination', 'string', 'Destination file', true);
        $this->registerArgument('destinationExtension', 'string', 'Extension for the destination file', false, null);
        $this->registerArgument('doNotCopyIfDestinationExists', 'boolean', 'If true the file is not copied if the destination exists', false, false);
    }

    /**
     * Renders the view helper
     *
     * @return void
     */
    public function render(): void
    {
        // Gets the arguments
        $source = $this->arguments['source'];
        $sourceExtension = $this->arguments['sourceExtension'];
        $destination = $this->arguments['destination'];
        $destinationExtension = $this->arguments['destinationExtension'];
        $doNotCopyIfDestinationExists = $this->arguments['doNotCopyIfDestinationExists'];

        if ($sourceExtension === null) {
            $sourceExtensionDirectory = ConfigurationManager::getExtensionDir('sav_library_kickstarter');
        } else {
            $sourceExtensionDirectory = ConfigurationManager::getExtensionDir($sourceExtension);
        }
        if ($destinationExtension === null) {
            $destinationExtensionDirectory = ConfigurationManager::getExtensionDir('sav_library_kickstarter');
        } else {
            $destinationExtensionDirectory = ConfigurationManager::getExtensionDir($this->arguments['destinationExtension']);
        }
        if (! $doNotCopyIfDestinationExists || ($doNotCopyIfDestinationExists && ! file_exists($destinationExtensionDirectory . $destination))) {
            if (! @copy($sourceExtensionDirectory . $source, $destinationExtensionDirectory . $destination)) {
                throw new \RuntimeException('Copy failed.');
            }
        }
    }

}
