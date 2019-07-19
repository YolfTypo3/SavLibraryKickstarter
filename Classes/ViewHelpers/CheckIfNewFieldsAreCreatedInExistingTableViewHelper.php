<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper to check if there are new fields created in an existing table.
 *
 * = Examples =
 *
 * <code title="CheckIfNewFieldsAreCreatedInExistingTable">
 * <sav:CheckIfNewFieldsAreCreatedInExistingTable existingTable="existingTable"/>
 * </code>
 *
 * Output:
 * true or false
 *
 * @package SavLibraryKickstarter
 */
class CheckIfNewFieldsAreCreatedInExistingTableViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('existingTable', 'array', 'Existing table array', true);
    }

    /**
     * Returns true if new fields are created
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return bool
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $existingTable = $arguments['existingTable'];

        foreach ($existingTable['fields'] as $field) {
            if ($field['type'] != 'ShowOnly') {
                return true;
            }
        }
        return false;
    }
}
?>

