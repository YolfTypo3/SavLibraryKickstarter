<?php
namespace SAV\SavLibraryKickstarter\ViewHelpers\Mvc;

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
 * A view helper for building the options for the field selector.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForFieldSelectorbox">
 * <sav:BuildOptionsForFieldSelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 */
class AllowUidToBeEqualToZeroViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $tableName
     *            The name cof the tabale being processeed
     * @param array $extension
     *            The extension configuration
     *            
     * @return booelan Returns true if uid is allowed to be equal to zero
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($tableName, $extension)
    {       
        // Checks in the newTables section
        foreach ($extension['newTables'] as $table) {
            foreach ($table['fields'] as $field) {
                if ($field['conf_rel_table'] == $tableName && $field['conf_rel_dummyitem']) {
                    return true;
                }
            }
        }
        
        // Checks in the existingTables section
        foreach ($extension['existingTables'] as $table) {
            foreach ($table['fields'] as $field) {
                if ($field['conf_rel_table'] == $tableName && $field['conf_rel_dummyitem']) {
                    return true;
                }
            }
        }
        
        return false;
    }
}
?>

