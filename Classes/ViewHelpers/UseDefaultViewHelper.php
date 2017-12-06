<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

/**
 * Copyright notice
 *
 * (c) 2015 Laurent Foulloy (yolf.typo3@orange.fr)
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

/**
 * A view helper which returns a file if its exists in the SAV Library Kickstarter
 * and the default one otherwise.
 *
 * = Examples =
 *
 * <code title="useDefault">
 * <sav:useDefault fileName="file to check" default="default file" />
 * </code>
 *
 *
 * @package SavLibraryKickstarter
 */
class UseDefaultViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $path
     *            path
     * @param string $fileName
     *            fileName to check
     * @param string $default
     *            default file
     * @return string Either the fileName if the file exits in the SAV Library Kickstarter or the defaut
     */
    public function render($path, $fileName, $default)
    {
        if (file_exists($path. $fileName)) {
            return $fileName;
        } else {
            return $default;
        }
    }
}
?>

