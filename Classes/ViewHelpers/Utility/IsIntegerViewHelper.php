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
 * A view helper for checking if the type of a value is integer.
 *
 *
 * @package SavLibraryKickstarter
 */
final class IsIntegerViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'mixed', 'Value to check', false, null);
        $this->registerArgument('positive', 'boolean', 'If true, check if the integer is positive', false, false);
    }

    /**
     * Renders the view helper
     *
     * @return bool
     */
    public function render(): bool
    {
        // Gets the arguments
        $value = $this->arguments['value'];
        $positive = $this->arguments['positive'];

        if ($value === null) {
            $value = $this->renderChildren();
        }

        if ($positive) {
            return  is_integer($value) && ($value > 0);
        } else {
            return is_integer($value);
        }
    }
}
