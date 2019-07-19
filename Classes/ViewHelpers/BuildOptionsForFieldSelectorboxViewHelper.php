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
class BuildOptionsForFieldSelectorboxViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('fields', 'array', 'Fields', true);
        $this->registerArgument('options', 'array', 'Intitial option values', false, []);
    }

    /**
     * Renders the options
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return array the options array
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $fields = $arguments['fields'];
        $options = $arguments['options'];

        if (is_array($fields)) {
            foreach ($fields as $field) {
                $options = array_merge($options, [
                    $field['fieldname'] => $field['fieldname']
                ]);
            }
        }

        return $options;
    }
}
?>

