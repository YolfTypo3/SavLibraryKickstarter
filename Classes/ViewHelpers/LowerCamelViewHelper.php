<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

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
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class LowerCamelViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
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
        return Conversion::lowerCamel($string);
    }
}
?>

