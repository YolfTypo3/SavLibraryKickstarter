<?php
namespace SAV\SavLibraryKickstarter\ViewHelpers;

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
use SAV\SavLibraryKickstarter\Configuration\ConfigurationManager;

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
     *
     * @param array $extension
     * @return string the dependencies array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($extension)
    {
        $dependenciesResult = array();

        // Processes the dependency for typo3
        $typo3DependencyKey = 'emconf.dependency.typo3.' . $extension['general'][1]['compatibility'];
        $dependenciesResult['typo3'] = LocalizationUtility::translate($typo3DependencyKey, 'SavLibraryKickstarter');

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
            if (! in_array($libraryDependency, $dependenciesArray)) {
                $dependenciesResult[$libraryDependency] = '';
            }
        }
        foreach ($dependenciesArray as $dependency) {
            $dependenciesResult[trim($dependency)] = '';
        }

        // Processes the constraints
        $constraints = '';
        foreach ($dependenciesResult as $dependencyKey => $dependency) {
            $constraints .= '\'' . $dependencyKey . '\' => \'' . $dependency . '\',' . chr(10);
        }
        $constraints = substr($constraints, 0, - 1);

        return $constraints;
    }
}
?>

