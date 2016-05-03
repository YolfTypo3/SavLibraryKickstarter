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

/**
 * A view helper for building the ORDER BY clause of a relation table.
 *
 * = Examples =
 *
 * <code title="BuildOrderbyClauseForRelationTable">
 * <sav:BuildOrderbyClauseForRelationTable />
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
class BuildOrderByClauseForRelationTableViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param array $arguments
     * @param string $tableName
     * @param boolean $mvc
     * @return string the options array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($arguments, $tableName, $mvc = FALSE)
    {
        // Searches the table name in new tables
        $newTables = $arguments['newTables'];

        $domain = ($mvc ? '_domain_model_' : '_');
        if (is_array($newTables)) {
            foreach ($newTables as $tableKey => $table) {
                $realTableName = 'tx_' . str_replace('_', '', $arguments['general'][1]['extensionKey']) . $domain . $table['tablename'];

                if ($realTableName == $tableName) {
                    // Checks if manual ordering is not set
                    if (empty($table['sorting'])) {
                        // Field-based ordering
                        $orderByClause = 'ORDER BY ' . $realTableName . '.' . $table['sorting_field'];
                        if (empty($table['sorting_desc']) === FALSE) {
                            $orderByClause .= ' DESC';
                        }
                    } else {
                        // Manual ordering
                        $orderByClause .= 'ORDER BY ' . $realTableName . '.sorting';
                    }
                    return $orderByClause;
                }
            }
        }

        // Searches the table name in existing tables
        foreach ($GLOBALS['TCA'] as $tableKey => $table) {
            if ($tableKey == $tableName) {
                // Checks if there is a default ordering
                if (empty($table['default_sortby']) === FALSE) {
                    return 'ORDER BY ' . $table['default_sortby'];
                } elseif (empty($table['sortby']) === FALSE) {
                    return 'ORDER BY ' . $table['sortby'];
                }
            }
        }
        return '';
    }
}
?>

