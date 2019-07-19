<?php
namespace YolfTypo3\SavLibraryKickstarter\Upgrade;

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
use YolfTypo3\SavLibraryKickstarter\Utility\ItemManager;

/**
 * Upgrades the extension from the kickstarter
 *
 * @package Kickstarter
 */
class UpgradeToSavLibraryPlus_1_1_0 extends AbstractUpgradeManager
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
        // Items to keep in the general section
        $itemsToKeep = [
            'addWizardPluginIcon',
            'compatibility',
            'currentLibraryVersion',
            'extensionMustbeUpgraded',
            'debug',
            'extensionKey',
            'fieldKey',
            'isLoadedExtension',
            'itemKey',
            'keepExtLocalConf',
            'libraryType',
            'libraryVersion',
            'pluginTitle',
            'section',
            'showFieldConfiguration',
            'vendorName'
        ];

        // Sets the new configuration with the old one
        $newConfiguration = $configuration->getItemsAsArray();

        // Cleans the section
        foreach ($newConfiguration[1] as $itemKey => $item)
            if (! in_array($itemKey, $itemsToKeep)) {
                unset($newConfiguration[1][$itemKey]);
            }
        // Defines the upgrade methods
        $newConfiguration['replacementMethod'] = 'deleteAndReplace';

        // Sets the library version
        $newConfiguration[1]['libraryVersion'] = '1.1.0';

        return $newConfiguration;
    }

    /**
     * Deletes the pi section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradePiSection(ItemManager $configuration): array
    {
        $newConfiguration = [];
        // Defines the upgrade methods
        $newConfiguration['deleteSection'] = true;
        return $newConfiguration;
    }

    /**
     * Deletes the languages section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeLanguagesSection(ItemManager $configuration): array
    {
        $newConfiguration = [];
        // Defines the upgrade methods
        $newConfiguration['deleteSection'] = true;
        return $newConfiguration;
    }
}
?>
