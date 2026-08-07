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

/**
 * A view helper for checking if the type of a value is array of integer.
 *
 *
 * @package SavLibraryKickstarter
 */
final class IsArrayOfIntegerViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'array', 'Array to check', false, null);
        $this->registerArgument('index', 'mixed', 'Index in the array', true);
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
        $index = $this->arguments['index'];

        if ($value === null) {
            $value = $this->renderChildren();
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
