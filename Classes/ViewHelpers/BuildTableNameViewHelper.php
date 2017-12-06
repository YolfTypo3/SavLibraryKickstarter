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

/**
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildTableName">
 * <sav:BuildTableName />
 * </code>
 *
 * Output:
 * the oprtions
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class BuildTableNameViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $shortName
     * @param string $extensionKey
     * @param string $prefix
     * @param boolean $shortNameOnly
     * @param boolean $mvc
     * @return string the table name
     */
    public function render($shortName = '', $extensionKey, $prefix = '', $shortNameOnly = FALSE, $mvc = FALSE)
    {
        if ($prefix != '') {
            $prefix = $prefix . '_';
        }
        if ($shortNameOnly === TRUE) {
            return $shortName;
        } else {
            $domain = ($mvc ? '_domain_model' : '');
            $defaultShortName = ($mvc ? '_default' : '');
            return strtolower($prefix . 'tx_' . str_replace('_', '', $extensionKey) . $domain . ($shortName ? '_' . $shortName : $defaultShortName));
        }
    }
}
?>

