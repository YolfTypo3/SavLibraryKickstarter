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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for transforming a string to UpperCamel case.
 *
 * = Examples =
 *
 * <code title="UpperCamel">
 * <sav:upperCamel string="sav_library_kickstarter" />
 * </code>
 *
 * Output:
 * SavLibraryKickstarter
 *
 * @package SavLibraryKickstarter
 */
class UpperCamelViewHelper extends AbstractViewHelper
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
     * Renders the string in UpperCamel
     *
     * @return string String in UpperCamel
     */
    public function render(): string
    {
        // Gets the arguments
        $string = $this->arguments['string'];

        if ($string === null) {
            $string = $this->renderChildren();
        }
        if ($this->arguments['noAccent']) {
            $string = $this->replaceAccents($string);
        }

        return ($string === null ? '' : GeneralUtility::underscoredToUpperCamelCase($string));
    }

}
