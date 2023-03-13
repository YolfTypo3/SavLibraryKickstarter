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

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use YolfTypo3\SavLibraryKickstarter\Utility\Conversion;

/**
 * A view helper for removing empty lines.
 *
 *
 * @package SavLibraryKickstarter
 */
class RemoveEmptyLinesViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('value', 'string', 'String to process', false, null);
        $this->registerArgument('keepLine', 'string', 'If not empty, empty lines starting by this string are kept', false, '');
        $this->registerArgument('htmlentitiesDecode', 'boolean', 'If true html_entity_decode is applied', false, false);
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
        $keepLine = $arguments['keepLine'];
        $htmlentitiesDecode = $arguments['htmlentitiesDecode'];

        if ($value === null) {
            $value = $renderChildrenClosure();
        }

        if (empty($keepLine)) {
            $value = preg_replace('/([ \t]*[\r\n]){2,}/', chr(10), $value);
        } else {
            $value = preg_replace('/([ \t]*[\r\n]){2,}/', chr(10), $value);
            $value = preg_replace('/' . $keepLine . '([ \t]*[\r\n]){1,2}/', chr(10), $value);
        }
        if ($htmlentitiesDecode) {
            $value = html_entity_decode($value, ENT_QUOTES);
        }

        return trim($value);
    }
}
