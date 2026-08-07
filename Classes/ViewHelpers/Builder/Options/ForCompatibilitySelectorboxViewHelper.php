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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Options;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A view helper for building the options for the compatibility selector.
 *
 *
 * @package SavLibraryKickstarter
 */
final class ForCompatibilitySelectorboxViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('libraryType', 'string', 'Library type', true);
    }

    /**
     * Renders the view helper
     *
     * @return array
     */
    public function render(): array
    {
        // Gets the arguments
        $libraryType = $this->arguments['libraryType'];

        // Gets the settings
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);
        $options = [];
        foreach (array_reverse($settings['versions']) as $versionKey => $version) {           
            switch ($libraryType) {
                case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                    $options[$versionKey] = $version['compatibility'];
                    break;
                case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                    if ($version['dependencies']['composer']['sav_library_mvc'] ?? false){
                        $options[$versionKey] = $version['compatibility'];
                    }
                    break;
                case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                    if ($version['dependencies']['composer']['sav_library_plus'] ?? false){
                        $options[$versionKey] = $version['compatibility'];
                    }
                    break;
            }
        }
        uksort($options, 'strnatcasecmp');

        return $options;
    }

}
