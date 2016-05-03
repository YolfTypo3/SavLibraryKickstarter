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
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class ToLowerViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $string
     *            String to convert
     * @return string Converted string
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($string = NULL)
    {
        if ($string === NULL) {
            $string = $this->renderChildren();
        }
        return strtolower($string);
    }
}
?>

