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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for removing empty lines.
 *
 *
 * @package SavLibraryKickstarter
 */
final class RemoveEmptyLinesViewHelper extends AbstractViewHelper
{
    
    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', 'String to process', false, null);
        $this->registerArgument('keepLine', 'string', 'If not empty, empty lines starting by this string are kept', false, '');
        $this->registerArgument('htmlentitiesDecode', 'boolean', 'If true html_entity_decode is applied', false, false);
    }

    /**
     * Renders the view helper
     *
     * @return string
     */
    public function render(): string
    {
        // Gets the arguments
        $value = $this->arguments['value'];
        $keepLine = $this->arguments['keepLine'];
        $htmlentitiesDecode = $this->arguments['htmlentitiesDecode'];

        if ($value === null) {
            $value = $this->renderChildren();
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
