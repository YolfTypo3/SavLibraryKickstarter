<?php
namespace SAV\SavLibraryKickstarter\Utility;

/**
 * *************************************************************
 * Copyright notice
 *
 * (c) 2010 Laurent Foulloy <yolf.typo3@orange.fr>
 * All rights reserved
 *
 * This class is a backport of the corresponding class of FLOW3.
 * All credits go to the v5 team.
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
 * *************************************************************
 */

/**
 * Utilities for converting variables
 *
 * @package SavLibraryKickstarter
 * @subpackage Utility
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class Conversion
{

    /**
     * Converts a string to upperCamel
     *
     * @param string $string
     *            The string to convert
     * @return string The string in upper Camel case
     */
    static public function upperCamel($string)
    {
        $string = str_replace(' ', '_', $string);
        $parts = explode('_', $string);
        foreach ($parts as $part) {
            $output .= ucfirst($part);
        }
        return $output;
    }

    /**
     * Converts a string to lowerCamel
     *
     * @param string $string
     *            The string to convert
     * @return string The string in lower Camel case
     */
    static public function lowerCamel($string)
    {
        $output = self::upperCamel($string);
        if (function_exists('lcfirst')) {
            return lcfirst($output);
        } else {
            $output[0] = strtolower($output[0]);
            return $output;
        }
    }

    /**
     * Converts a string to utf8
     *
     * @param string $string
     *            The string to convert
     * @return string The string in utf8
     */
    static public function stringToUtf8($string)
    {
        if ($GLOBALS['LANG']->charSet == '' || $GLOBALS['LANG']->charSet == 'iso-8859-1') {
            return utf8_encode($string);
        } else {
            return $string;
        }
    }
}

?>
