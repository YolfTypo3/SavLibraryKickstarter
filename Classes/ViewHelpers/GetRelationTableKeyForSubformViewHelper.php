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

use SAV\SavLibraryKickstarter\Configuration\ConfigurationManager;

/**
 * A view helper for getting the relation table.
 *
 * = Examples =
 *
 * <code title="GetRelationTableKeyForSubform">
 * <sav:GetRelationTableForSubform />
 * </code>
 *
 * Output:
 * the oprtions
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class GetRelationTableKeyForSubformViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param array $arguments
     * @param string $tableName
     * @return string the options array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($arguments, $tableName)
    {
        $extensionKey = $arguments['general'][1]['extensionKey'];
        $libraryType = $arguments['general'][1]['libraryType'];
        foreach ($arguments['newTables'] as $tableKey => $table) {
            switch ($libraryType) {
                case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                    $realTableName = 'tx_' . str_replace('_', '', $extensionKey) . '_' . $table['tablename'];
                    break;
                case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                    $realTableName = 'tx_' . str_replace('_', '', $extensionKey) . '_domain_model_' . $table['tablename'];
                    break;
            }

            if ($realTableName == $tableName) {
                return $tableKey;
            }
        }
        return 0;
    }
}
?>

