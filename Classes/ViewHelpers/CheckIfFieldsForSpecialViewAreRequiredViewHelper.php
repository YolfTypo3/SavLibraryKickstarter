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

/**
 * A view helper to check if there are new fields created in an existing table.
 *
 * = Examples =
 *
 * <code title="CheckIfFieldsForSpecialViewAreRequired">
 * <sav:CheckIfFieldsForSpecialViewAreRequired extension="extension"/>
 * </code>
 *
 * Output:
 * true or false
 *
 * @package SavLibraryKickstarter
 */
class CheckIfFieldsForSpecialViewAreRequiredViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('extension', 'array', 'Extension', true);
        $this->registerArgument('model', 'string', 'Model', true);
    }

    /**
     * Returns true if fields are required
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
        $extension = $arguments['extension'];
        $model = $arguments['model'];

        if (is_array($extension['forms'])) {
            foreach ($extension['forms'] as $form) {
                if (! empty($form['specialView'])) {
                    $queryKey = $form['query'];
                    if ($extension['queries'][$queryKey]['mainTable'] == $model) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
