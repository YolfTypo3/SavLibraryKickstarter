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
 * A view helper to check if there are new fields created in an existing table.
 *
 * = Examples =
 *
 * <code title="CheckIfNewFieldsAreCreatedInExistingTable">
 * <sav:CheckIfNewFieldsAreCreatedInExistingTable existingTable="existingTable"/>
 * </code>
 *
 * Output:
 * true or false
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class CheckIfNewFieldsAreCreatedInExistingTableViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param array $existingTable
     *            Existing table containing the field
     * @return boolean
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($existingTable)
    {
        foreach ($existingTable['fields'] as $field) {
            if ($field['type'] != 'ShowOnly') {
                return TRUE;
            }
        }
        return FALSE;
    }
}
?>

