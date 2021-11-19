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

namespace YolfTypo3\SavLibraryKickstarter\Upgrade;

use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Utility\ItemManager;

/**
 * Upgrades the extension from the kickstarter
 *
 * @package Kickstarter
 */
class UpgradeToSavLibraryPlus_1_0_0 extends AbstractUpgradeManager
{

    /**
     * Upgrades the general section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *
     * @return array The new configuration
     */
    public function upgradeGeneralSection(ItemManager $configuration): array
    {
        $newConfiguration = $configuration->getItemsAsArray();

        // Sets the compatibility
        $newConfiguration[1]['compatibility'] = ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT;

        // Sets the library version
        $newConfiguration[1]['libraryVersion'] = '1.0.0';

        return $newConfiguration;
    }
}
