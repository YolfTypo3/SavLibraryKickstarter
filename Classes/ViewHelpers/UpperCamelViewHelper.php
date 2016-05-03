<?php
namespace SAV\SavLibraryKickstarter\ViewHelpers;

/*
 * This script is part of the TYPO3 project - inspiring people to share! *
 * *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by *
 * the Free Software Foundation. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General *
 * Public License for more details. *
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

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
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class UpperCamelViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $string
     *            String to convert
     * @return string Converted string
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     *         @api
     */
    public function render($string = NULL)
    {
        if ($string === NULL) {
            $string = $this->renderChildren();
        }
        return GeneralUtility::underscoredToUpperCamelCase($string);
    }
}
?>

