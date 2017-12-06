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
 * A view helper for sorting the fields in a view.
 *
 * This view helper has exactly the same syntax as the fluid alias viewhelper.
 * The main difference is that obect accessor may contain other object accesor
 * Therefore {a.b.{c.d}.e} is allowed
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class SortFieldsViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param integer $viewKey            
     * @param array $fields            
     * @return string Rendered string
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($viewKey, $fields = NULL)
    {
        if ($fields === NULL) {
            $fields = $this->renderChildren();
        }
        
        $sortedKeys = array();
        // Gets the keys
        foreach ($fields as $keyField => $field) {
            if ($field['selected'][$viewKey]) {
                $fieldValue = $field['order'][$viewKey];
                $sortedKeys[$fieldValue] = $keyField;
            }
        }
        // Sorts the array
        ksort($sortedKeys);
        // Builds the sorted item array
        foreach ($sortedKeys as $fieldKey) {
            $sortedFields[$fieldKey] = $fields[$fieldKey];
        }
        
        return $sortedFields;
    }
}
?>

