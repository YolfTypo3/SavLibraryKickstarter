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
use YolfTypo3\SavLibraryKickstarter\Utility\Conversion;

/**
 * A view helper for transforming a string to LowerCamel case.
 *
 * = Examples =
 *
 * <code title="lowerCamel">
 * <sav:lowerCamel string="sav_library_kickstarter" />
 * </code>
 *
 * Output:
 * savLibraryKickstarter
 *
 * @package SavLibraryKickstarter
 */
class LowerCamelViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('string', 'string', 'String to convert', false, null);
    }

    /**
     * Renders the string in lowerCamel
     *
     * @return string String in lowerCamel
     */
    public function render(): string
    {
        // Gets the arguments
        $string = $this->arguments['string'];

        if ($string === null) {
            $string = $this->renderChildren();
        }
        return ($string === null ? '' : Conversion::lowerCamel($string));
    }
}
