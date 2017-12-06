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

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use YolfTypo3\SavLibraryKickstarter\Configuration\ConfigurationManager;

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
 * @subpackage ViewHelpers
 */
class BuildOptionsForCompatibilitySelectorboxViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    /**
     *
     * @param string $libraryType
     *            The library type
     *
     * @return array the options
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($libraryType)
    {
        // Gets the settings
        $extensionName = $this->controllerContext->getRequest()->getControllerExtensionName();
        $pluginName = $this->controllerContext->getRequest()->getPluginName();
        $settings = $this->getSettings($extensionName, $pluginName);

        switch($libraryType) {
            case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
            case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                $options = array(
                    ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE],
                );
                break;
            case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                $options = array(
                    ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE],
                    ConfigurationManager::COMPATIBILITY_TYPO3_6x => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_6x],
                    ConfigurationManager::COMPATIBILITY_TYPO3_6x_7x => $settings['compatibility'][ConfigurationManager::COMPATIBILITY_TYPO3_6x_7x],
                );
                break;
        }
        return $options;
    }


    /**
     * Returns TypoScript settings array
     *
     * @param string $extensionName Name of the extension
     * @param string $pluginName Name of the plugin
     * @return array
     */
    public function getSettings($extensionName, $pluginName)
    {

        $typoScript = $this->configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            $extensionName,
            $pluginName);

        return $typoScript;

    }
}
?>

