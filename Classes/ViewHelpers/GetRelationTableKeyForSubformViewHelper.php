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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

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
 *
 */
class GetRelationTableKeyForSubformViewHelper extends AbstractViewHelper
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
    }

    /**
     * Renders the table key
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return int The table key
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $argumentsOption = $arguments['arguments'];
        $tableName = $arguments['tableName'];

        $extensionKey = $argumentsOption['general'][1]['extensionKey'];
        $libraryType = $argumentsOption['general'][1]['libraryType'];
        foreach ($argumentsOption['newTables'] as $tableKey => $table) {
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
                return [
                    'section' => 'newTables',
                    'key' => $tableKey
                ];
            }
        }
        foreach ($argumentsOption['existingTables'] as $tableKey => $table) {
            if ($table['tablename'] == $tableName) {
                return [
                    'section' => 'existingTables',
                    'key' => $tableKey
                ];
            }
        }
        return [
            'section' => 'newTables',
            'key' => 0
        ];
    }
}
