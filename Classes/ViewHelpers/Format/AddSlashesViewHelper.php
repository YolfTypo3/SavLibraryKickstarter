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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for quoting a string with slashes.
 *
 *
 * @package SavLibraryKickstarter
 */
final class AddSlashesViewHelper extends AbstractViewHelper
{
    
    /**
     * Initializes arguments.
     *
     * return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', 'Value to convert', false, null);
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

        if ($value === null) {
            $value = $this->renderChildren();
        }

        return ($value === null ? '' : addslashes($value));
    }
}
