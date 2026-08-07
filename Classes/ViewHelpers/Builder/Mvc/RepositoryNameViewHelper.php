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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Mvc;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use YolfTypo3\SavLibraryKickstarter\Controller\KickstarterController;

/**
 * A view helper for building the repository name.
 *
 *
 * @package SavLibraryKickstarter
 */
final class RepositoryNameViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('tableName', 'string', 'Table name', false, null);
        $this->registerArgument('extension', 'array', 'Extension', false, null);
        $this->registerArgument('removeFirstBackslash', 'boolean', 'Flag to remove the first backslash', false, false);
        $this->registerArgument('shortName', 'boolean', 'if true returns the short name', false, false);
    }

    /**
     * Renders the view helper
     *
     * @return string
     */
    public function render(): string
    {
        // Gets the arguments
        $tableName = $this->arguments['tableName'];
        $extension = $this->arguments['extension'];
        $removeFirstBackslash = $this->arguments['removeFirstBackslash'];
        $shortName = $this->arguments['shortName'];

        if ($tableName === null) {
            $tableName = $this->renderChildren();
        }
        
        // Extracts the extension and the short model names
        $match = [];
        if (preg_match('/^tx_(?P<extensionName>\w+)_domain_model_(?P<shortModelName>\w+)$/', $tableName, $match)) {
            if ($match['extensionName'] == str_replace('_', '', $extension['general'][1]['extensionKey'])) {
                // The model is in the extension
                $extensionKey = $extension['general'][1]['extensionKey'];
            } else {
                // Gets the extension key from the prefix
                $extensionKey = KickstarterController::getExtensionKeyByPrefix('tx_' . $match['extensionName']);
            }
            $shortModelName = GeneralUtility::underscoredToUpperCamelCase($match['shortModelName']);
        } else {
            // The model is in the extension
            $extensionKey = $extension['general'][1]['extensionKey'];
            $shortModelName = GeneralUtility::underscoredToUpperCamelCase($tableName);
        }

        // Returns the short name if required
        if ($shortName) {
            return $shortModelName . 'Repository';
        }

        // Returns the repository name
        $repositoryName = $extension['general'][1]['vendorName'] .
            '\\' . GeneralUtility::underscoredToUpperCamelCase($extensionKey) .
            '\\Domain\Repository\\' . $shortModelName . 'Repository';
        if (! $removeFirstBackslash) {
            $repositoryName = '\\' . $repositoryName;
        }
        return $repositoryName;
    }

}
