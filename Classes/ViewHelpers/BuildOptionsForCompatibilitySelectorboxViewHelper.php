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
     *
     * @param string $libraryType
     *            The library type
     *
     * @return array the options
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($libraryType)
    {
        switch($libraryType) {
            case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
            case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                $options = array(
                    ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE => LocalizationUtility::translate('kickstarter.generalItem.compatibility.0', 'sav_library_kickstarter'),
                );
                break;
            case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                $options = array(
                    ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE => LocalizationUtility::translate('kickstarter.generalItem.compatibility.0', 'sav_library_kickstarter'),
                    ConfigurationManager::COMPATIBILITY_TYPO3_6x => LocalizationUtility::translate('kickstarter.generalItem.compatibility.1', 'sav_library_kickstarter'),
                    ConfigurationManager::COMPATIBILITY_TYPO3_6x_7x => LocalizationUtility::translate('kickstarter.generalItem.compatibility.2', 'sav_library_kickstarter'),
                );
                break;
        }

        return $options;
    }
}
?>

