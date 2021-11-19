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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A view helper for building the options for the compatibility selector.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForCompatibilitySelectorbox">
 * <sav:BuildOptionsForCompatibilitySelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 */
class BuildOptionsForCompatibilitySelectorboxViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('libraryType', 'string', 'Library type', true);
    }

    /**
     * Renders the option for the compatibility
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return array the options
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $libraryType = $arguments['libraryType'];

        // Gets the configuration manager
        $configurationManager = self::getConfigurationManager();

        // Gets the settings
        $settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);

        switch ($libraryType) {
            case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                $options = [
                    ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT],
                    ConfigurationManager::COMPATIBILITY_TYPO3_8x_9x => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_8x_9x],
                    ConfigurationManager::COMPATIBILITY_TYPO3_7x => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_7x]
                ];
                break;
            case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                $options = [
                    ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT],
                    ConfigurationManager::COMPATIBILITY_TYPO3_8x_9x => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_8x_9x],
                    ConfigurationManager::COMPATIBILITY_TYPO3_7x => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_7x]
                ];
                break;
            case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                $options = [
                    ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT],
                    ConfigurationManager::COMPATIBILITY_TYPO3_8x_9x => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_8x_9x],
                    ConfigurationManager::COMPATIBILITY_TYPO3_7x => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_7x]
                ];
                break;
        }
        return $options;
    }

    /**
     * Gets the configuration manager
     *
     * @return ConfigurationManagerInterface
     */
    protected static function getConfigurationManager(): ConfigurationManagerInterface
    {
        $typo3Version = GeneralUtility::makeInstance(Typo3Version::class);
        if (version_compare($typo3Version->getVersion(), '11.0', '<')) {
            $configurationManager = GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class)->get(ConfigurationManagerInterface::class);
        } else {
            $configurationManager = GeneralUtility::makeInstance(ConfigurationManagerInterface::class);
        }
        return $configurationManager;
    }
}
