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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Format;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use YolfTypo3\SavLibraryKickstarter\Utility\Conversion;

/**
 * A view helper for quoting a string with slashes.
 *
 *
 * @package SavLibraryKickstarter
 */
class AddSlashesViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
    /**
     * Initializes arguments.
     *
     * return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('value', 'string', 'Value to convert', false, null);
    }

    /**
     * Renders the item
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
        $value = $arguments['value'];

        if ($value === null) {
            $value = $renderChildrenClosure();
        }

        return ($value === null ? '' : addslashes($value));
    }
}
