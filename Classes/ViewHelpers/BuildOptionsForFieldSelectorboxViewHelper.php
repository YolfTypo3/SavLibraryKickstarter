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
class BuildOptionsForFieldSelectorboxViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param array $fields
     *            The fields
     * @param array $options
     *            The initial option values
     *            
     * @return string the options array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($fields, $options = array())
    {
        if (is_array($fields)) {
            foreach ($fields as $field) {
                $options = array_merge($options, array(
                    $field['fieldname'] => $field['fieldname']
                ));
            }
        }
        
        return $options;
    }
}
?>

