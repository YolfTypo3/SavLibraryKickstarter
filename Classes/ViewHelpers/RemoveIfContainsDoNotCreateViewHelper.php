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
 * A view helper to check if the string contains "DO NOT CREATE".
 *
 * = Examples =
 *
 * <code title="RemoveIfContainsDoNotCreate">
 * <sav:CheckForDoNotCreate>
 * blabla DO NOT CREATE
 * </sav:RemoveIfContainsDoNotCreate>
 * </code>
 *
 * Output:
 *
 *
 * @package SavLibraryKickstarter
 */
class RemoveIfContainsDoNotCreateViewHelper extends AbstractViewHelper
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
     * Renders the viewhelper
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
        if (strpos($string, 'DO NOT CREATE') === false) {
            return $string;
        } else {
            return '';
        }
    }
}
?>

