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
 * A view helper for building the constraints for the ext_emconf.php.
 *
 * = Examples =
 *
 * <code title="BuildConstraintsForExtensionManager">
 * <sav:BuildConstraintsForExtensionManager />
 * </code>
 *
 * Output:
 * the contraints
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class BuildConstraintsForExtensionManagerViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @inject
     */
    protected $configurationManager;

    /**
     *
     * @param array $extension
     * @param string $type
     * @return string the dependencies array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($extension, $type)
    {
        $dependenciesResult = [];

        // Gets the settings
        $extensionName = $this->controllerContext->getRequest()->getControllerExtensionName();
        $pluginName = $this->controllerContext->getRequest()->getPluginName();
        $settings = $this->getSettings($extensionName, $pluginName);

        // Processes the dependency for the core
        $compatibility = $extension['general'][1]['compatibility'];
        $dependenciesResult['emconf']['typo3'] = $settings['dependency']['emconf'][$compatibility];
        $dependenciesResult['composer']['typo3/cms-core'] = $settings['dependency']['composer'][$compatibility];

        // Processes the library dependancy
        switch ($extension['general'][1]['libraryType']) {
            case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                $libraryDependency = 'sav_library_mvc';
                break;
            case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                $libraryDependency = 'sav_library_plus';
                break;
            default:
                $libraryDependency = '';
        }

        // Processes the other dependencies
        $dependencies = $extension['emconf'][1]['dependencies'];
        if (! empty($dependencies)) {
            $dependenciesArray = explode(',', $dependencies);

            foreach ($dependenciesArray as $dependency) {
                if(preg_match('/^([^[ \(]+)\s*(?:\(([^)]+)\))?/', $dependency, $match)) {
                    $dependencyName = $match[1];
                    $dependencyConstraint = $match[2];
                    // Adds a blank constraint for ext_emconf.php
                    $dependenciesResult['emconf'][$dependencyName] = '';
                    // Adds the dependency in composer.json only if the constaints exists
                    if (!empty($dependencyConstraint)) {
                        $dependenciesResult['composer']['typo3-ter/' . str_replace('_', '-', $dependencyName)] = $dependencyConstraint;
                    } elseif($libraryDependency != '' && $dependencyName == $libraryDependency) {
                        // If the default library is used without constraint, the default constraint will be used
                        unset($dependenciesResult['emconf'][$dependencyName]);
                    }
                }
            }
        }

        if ($libraryDependency != '' && ! array_key_exists($libraryDependency, $dependenciesResult['emconf'])) {
            $dependenciesResult['emconf'][$libraryDependency] = $settings['dependency']['emconf'][$libraryDependency]['default'];
            $dependenciesResult['composer']['typo3-ter/' . str_replace('_', '-', $libraryDependency)] = $settings['dependency']['composer'][$libraryDependency]['default'];
        }

        // Processes the constraints
        $constraints = '';

        foreach ($dependenciesResult[$type] as $dependencyKey => $dependency) {
            switch($type) {
                case 'emconf':
                    $constraints .= '\'' . $dependencyKey . '\' => \'' . $dependency . '\',' . chr(10);
                    break;
                case 'composer':
                    $constraints .= '"' . $dependencyKey . '": "' . $dependency . '",' . chr(10);
            }
        }
        $constraints = substr($constraints, 0, -2);

        return $constraints;
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

