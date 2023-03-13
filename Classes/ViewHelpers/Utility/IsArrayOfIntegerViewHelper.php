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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Utility;

use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for checking if the type of a value is array of integer.
 *
 *
 * @package SavLibraryKickstarter
 */
class IsArrayOfIntegerViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('value', 'array', 'Array to check', false, null);
        $this->registerArgument('index', 'mixed', 'Index in the array', true);
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
        $value = $arguments['value'];
        $index = $arguments['index'];

        if ($value === null) {
            $value = $renderChildrenClosure();
        }

        $isInteger = true;
        if (is_array($value)) {
            foreach ($value as $item) {
                $isInteger = $isInteger && MathUtility::canBeInterpretedAsInteger($item[$index]);
            }
            return $isInteger;
        }
        return false;

    }
}
