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
 * A view helper for returing the current item of an array.
 *
 *
 * @package SavLibraryKickstarter
 */
final class CountLinesViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', 'Value to process', false, null);
    }

    /**
     * Renders the view helper
     *
     * @return int
     */
    public function render(): int
    {
        // Gets the arguments
        $value = $this->arguments['value'];

        if ($value === null) {
            $value = $this->renderChildren();
        }

        if (empty($value)) {
            return 0;
        } else {
            return substr_count($value, chr(10)) + 1;
        }
    }
}
