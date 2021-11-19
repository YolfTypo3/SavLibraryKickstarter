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

use YolfTypo3\SavLibraryKickstarter\Utility\ItemManager;

/**
 * Upgrades the extension from the kickstarter
 *
 * @package Kickstarter
 */
class UpgradeToSavLibraryKickstarter_9_5_0 extends AbstractUpgradeManager
{

    /**
     * Pre processing
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $sectionManager
     *            The section manager
     * @return void
     */
    public function preProcessing(ItemManager $sectionManager)
    {
        $sectionManager->addItem('documentation')->addItem(1);
    }

}
