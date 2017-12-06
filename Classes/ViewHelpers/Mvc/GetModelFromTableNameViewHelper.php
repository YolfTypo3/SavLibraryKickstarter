<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Mvc;

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
 * A view helper for obtaining the model from a table name.
 *
 * = Examples =
 *
 * <code title="GetModelFromTableName">
 * <sav:getModelFromTableName extension="sav_library_example" table="tx_savlibraryexample_test" />
 * <sav:getModelFromTableName extension="SavLibraryExample" table="tx_savlibraryexample_test" />
 * </code>
 *
 * Output:
 * Test
 *
 * @package SavLibraryMvc
 * @subpackage ViewHelpers
 * @version $Id:
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *          @scope prototype
 */
class GetModelFromTableNameViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $extension
     *            The extension name
     * @param string $table
     *            The table Name
     * @return string the model in UpperCamelCase
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     *         @api
     */
    public function render($extension, $table = NULL)
    {
        if ($table === NULL) {
            $table = $this->renderChildren();
        }
        $tableName = GeneralUtility::underscoredToUpperCamelCase($table);
        $extensionName = ucfirst(strtolower(GeneralUtility::underscoredToUpperCamelCase($extension)));
        return GeneralUtility::underscoredToUpperCamelCase(str_replace('Tx' . $extensionName . 'DomainModel', '', $tableName));
    }
}
?>

