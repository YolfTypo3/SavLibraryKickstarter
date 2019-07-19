<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for transforming a string to lower case.
 *
 * = Examples =
 *
 * <code title="tolower">
 * <sav:tolower string="SavLibraryKickstarter" />
 * </code>
 *
 * Output:
 * savlibrarykickstarter
 *
 * @package SavLibraryKickstarter
 */
class ToLowerViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('string', 'string', 'String to convert', false, null);
    }

    /**
     * Renders the string
     *
     * @return string Converted string
     */
    public function render(): string
    {
        // Gets the arguments
        $string = $this->arguments['string'];

        if ($string === null) {
            $string = $this->renderChildren();
        }
        return strtolower($string);
    }
}
?>

