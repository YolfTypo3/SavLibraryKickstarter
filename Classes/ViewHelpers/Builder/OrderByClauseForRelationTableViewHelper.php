<?php

declare(strict_types=1);

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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for building the ORDER BY clause of a relation table.
 *
 *
 * @package SavLibraryKickstarter
 */
class OrderByClauseForRelationTableViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('arguments', 'array', 'Arguments', true);
        $this->registerArgument('tableName', 'string', 'Table name', true);
        $this->registerArgument('mvc', 'boolean', 'Mvc flag', false, false);
    }

    /**
     * Renders the viewhelper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string The order clause
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $argumentsOption = $arguments['arguments'];
        $tableName = $arguments['tableName'];
        $mvc = $arguments['mvc'];

        // Searches the table name in new tables
        $newTables = $argumentsOption['newTables'];

        $domain = ($mvc ? '_domain_model_' : '_');
        if (is_array($newTables)) {
            foreach ($newTables as $tableKey => $table) {
                $realTableName = 'tx_' . str_replace('_', '', $argumentsOption['general'][1]['extensionKey']) . $domain . $table['tablename'];

                if ($realTableName == $tableName) {
                    // Checks if manual ordering is not set
                    if (empty($table['sorting'])) {
                        // Field-based ordering
                        $orderByClause = 'ORDER BY ' . $realTableName . '.' . $table['sorting_field'];
                        if (empty($table['sorting_desc']) === false) {
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
                if (empty($table['default_sortby']) === false) {
                    return 'ORDER BY ' . $table['default_sortby'];
                } elseif (empty($table['sortby']) === false) {
                    return 'ORDER BY ' . $table['sortby'];
                }
            }
        }
        return '';
    }
}
