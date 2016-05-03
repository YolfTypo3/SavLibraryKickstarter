<?php
namespace SAV\SavLibraryKickstarter\Upgrade;

/**
 * Copyright notice
 *
 * (c) 2010 Laurent Foulloy <yolf.typo3@orange.fr>
 * All rights reserved
 *
 * This class is a backport of the corresponding class of FLOW3.
 * All credits go to the v5 team.
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

use SAV\SavLibraryKickstarter\Configuration\ConfigurationManager;

/**
 * Upgrades the extension from the kickstarter
 *
 * @package Kickstarter
 * @subpackage Upgrade
 * @version SVN: $Id$
 */
class UpgradeToSavLibraryPlus_1_0_0 extends AbstractUpgradeManager
{

    /**
     * Upgrades the general section.
     *
     * @param array $configuration
     *            The actual configuration
     *
     * @return array The new configuration
     */
    public function upgradeGeneralSection($configuration)
    {
        $newConfiguration = $configuration->getItemsAsArray();

        // Sets the compatibility
        $newConfiguration[1]['compatibility'] = ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE;

        // Sets the library version
        $newConfiguration[1]['libraryVersion'] = '1.0.0';

        return $newConfiguration;
    }

}
?>
