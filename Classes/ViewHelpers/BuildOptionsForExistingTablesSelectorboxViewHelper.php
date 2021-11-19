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

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForFieldTypeSelectorbox">
 * <sav:BuildOptionsForFieldTypeSelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 */
class BuildOptionsForExistingTablesSelectorboxViewHelper extends AbstractViewHelper
{

    /**
     * Renders the viewhelper
     *
     * @return array the options array
     */
    public static function render()
    {
        $options = [
            '' => '',
            'tt_content' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.tt_content', 'sav_library_kickstarter'),
            'fe_users' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.fe_users', 'sav_library_kickstarter'),
            'fe_groups' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.fe_groups', 'sav_library_kickstarter'),
            'be_users' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.be_users', 'sav_library_kickstarter'),
            'be_groups' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.be_groups', 'sav_library_kickstarter'),
            'pages' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.pages', 'sav_library_kickstarter')
        ];

        foreach ($GLOBALS['TCA'] as $tableKey => $table) {
            if (! $options[$tableKey]) {
                $options[$tableKey] = $tableKey . ' (' . $GLOBALS['LANG']->sL($table['ctrl']['title']) . ')';
            }
        }
        asort($options);

        return $options;
    }
}
