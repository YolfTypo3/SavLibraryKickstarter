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
 * Returns an item in an array
 *
 * @package SavLibraryMvc
 * @version $Id:
 */
class GetItemViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * viewhelper.
     *
     * @param array $value
     *            The value of the parameter to change
     * @param string $key
     *            The key of the parameter to change
     * @return string The modified compressed parameters
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     *         @api
     */
    public function render($value = NULL, $key = NULL)
    {
        if ($value === NULL) {
            $value = $this->renderChildren();
        }

        if ($value === NULL) {
            return NULL;
        } elseif ($key === NULL) {
            return current($value);
        } else {
            return $value[$key];
        }
    }
}
?>
