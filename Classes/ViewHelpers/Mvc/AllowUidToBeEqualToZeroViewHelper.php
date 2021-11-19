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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Mvc;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for building the options for the field selector.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForFieldSelectorbox">
 * <sav:BuildOptionsForFieldSelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 */
class AllowUidToBeEqualToZeroViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('tableName', 'string', 'Name of the table being processeed', true);
        $this->registerArgument('extension', 'array', 'Extension configuration', true);
    }

    /**
     * Renders the viewhelper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return bool Returns true if uid is allowed to be equal to zero
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $extensionKey = $arguments['tableName'];
        $shortName = $arguments['extension'];

        // Checks in the newTables section
        foreach ($extension['newTables'] as $table) {
            foreach ($table['fields'] as $field) {
                if ($field['conf_rel_table'] == $tableName && $field['conf_rel_dummyitem']) {
                    return true;
                }
            }
        }

        // Checks in the existingTables section
        foreach ($extension['existingTables'] as $table) {
            foreach ($table['fields'] as $field) {
                if ($field['conf_rel_table'] == $tableName && $field['conf_rel_dummyitem']) {
                    return true;
                }
            }
        }

        return false;
    }
}
