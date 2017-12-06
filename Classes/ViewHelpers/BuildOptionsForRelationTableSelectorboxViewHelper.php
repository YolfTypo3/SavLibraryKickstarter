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
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForRelationTableSelectorbox">
 * <sav:BuildOptionsForRelationTableSelectorbox />
 * </code>
 *
 * Output:
 * the oprtions
 *
 * @package SavLibraryMvc
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class BuildOptionsForRelationTableSelectorboxViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param array $arguments
     * @return string the options array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($arguments)
    {

        $options = array(
            'pages' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.pages', 'sav_library_kickstarter'),
            'fe_users' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.fe_users', 'sav_library_kickstarter'),
            'fe_groups' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.fe_groups', 'sav_library_kickstarter'),
            'tt_content' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.tt_content', 'sav_library_kickstarter')
        );

        $newTables = $arguments['newTables'];
        if (is_array($newTables)) {
            foreach ($newTables as $table) {
                switch ($arguments['general'][1]['libraryType']) {
                    case ConfigurationManager::TYPE_SAV_LIBRARY:
                    case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                        $tableName = 'tx_' . str_replace('_', '', $arguments['general'][1]['extensionKey']) . ($table['tablename'] ? '_' . $table['tablename'] : '');
                        break;
                    case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                    case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                        $tableName = 'tx_' . str_replace('_', '', $arguments['general'][1]['extensionKey']) . '_domain_model_' . ($table['tablename'] ? $table['tablename'] : 'default');
                        break;
                }
                $options = array_merge($options, array(
                    $tableName => $table['title'] . ', (' . $tableName . ')'
                ));
            }
        }
        $options = array_merge($options, array(
            '_CUSTOM' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.custom', 'sav_library_kickstarter')
        ));

        return $options;
    }
}
?>

