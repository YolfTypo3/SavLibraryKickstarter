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

/**
 * A view helper for transforming a string to lower case.
 *
 *
 * @package SavLibraryKickstarter
 */
class RegexpViewHelper extends AbstractViewHelper
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
        $this->registerArgument('pattern', 'string', 'Pattern', true);
        $this->registerArgument('replacement', 'string', 'Replacement string', true);
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
        $pattern = $arguments['pattern'];
        $replacement = $arguments['replacement'];

        if ($value === null) {
            $value = $renderChildrenClosure() ?? '';
        }

        return preg_replace($pattern, $replacement, $value);

    }
}
