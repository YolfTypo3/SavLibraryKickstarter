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
 * @subpackage ViewHelpers
 */
class BuildOptionsForExistingTablesSelectorboxViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @return string the options array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public static function render()
    {
        $options = array(
            '' => '',
            'tt_content' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.tt_content', 'sav_library_kickstarter'),
            'fe_users' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.fe_users', 'sav_library_kickstarter'),
            'fe_groups' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.fe_groups', 'sav_library_kickstarter'),
            'be_users' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.be_users', 'sav_library_kickstarter'),
            'be_groups' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.be_groups', 'sav_library_kickstarter'),
            'pages' => LocalizationUtility::translate('kickstarter.existingTablesItem.tablename.pages', 'sav_library_kickstarter')
        );
        
        foreach ($GLOBALS['TCA'] as $tableKey => $table) {
            if (! $options[$tableKey]) {
                $options[$tableKey] = $tableKey . ' (' . $GLOBALS['LANG']->sL($table['ctrl']['title']) . ')';
            }
        }
        asort($options);
        
        return $options;
    }
}
?>

