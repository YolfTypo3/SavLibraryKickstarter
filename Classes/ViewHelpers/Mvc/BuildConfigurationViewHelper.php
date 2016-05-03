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
 * A view helper for to build the view configuration.
 *
 * = Examples =
 *
 * <code title="BuildConfiguration">
 * <sav:Mvc.BuildConfiguration field="Myfield" />
 * Myfield->sav:Mvc.BuildConfiguration()
 * </code>
 *
 * Output:
 * Test
 *
 * @package SavLibraryMvc
 * @version $Id:
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *          @scope prototype
 */
class BuildConfigurationViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $field
     *            The configuration of the field
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     *         @api
     */
    public function render($field = NULL)
    {
        if ($field === NULL) {
            $field = $this->renderChildren();
        }
        
        $configuration = array();
        
        // Replaces \; by a temporary tag
        $field = str_replace('\;', '#!!#', htmlspecialchars_decode($field));
        $items = explode(';', $field);
        
        foreach ($items as $item) {
            // Removes comments
            if (preg_match('/^\/\//', trim($item))) {
                continue;
            }
            
            if (trim($item)) {
                // Replaces the temporary tag by ;
                $item = str_replace('#!!#', ';', $item);
                
                $position = strpos($item, '=');
                if ($position === false) {
                    throw new RuntimeException('Missing equal sign in ' . $item);
                } else {
                    $attributeName = trim(substr($item, 0, $position));
                    
                    // Removes trailing spaces
                    $attributeValue = htmlspecialchars(ltrim(substr($item, $position + 1)));
                    $attributeValue = preg_replace('/\s+([\n\r])/', '$1', $attributeValue);
                    $configuration[$attributeName] = $attributeValue;
                }
            }
        }
        
        return $configuration;
    }
}
?>

