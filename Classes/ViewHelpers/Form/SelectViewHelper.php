<?php
namespace SAV\SavLibraryKickstarter\ViewHelpers\Form;

/*
 * This script belongs to the FLOW3 package "Fluid". *
 * *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser *
 * General Public License for more details. *
 * *
 * You should have received a copy of the GNU Lesser General Public *
 * License along with the script. *
 * If not, see http://www.gnu.org/licenses/lgpl.html *
 * *
 * The TYPO3 project - inspiring people to share! *
 */

/**
 * Just an awful patch to add classes to option.
 *
 * @version $Id: SelectViewHelper.php 1734 2009-11-25 21:53:57Z stucki $
 * @package Fluid
 * @subpackage ViewHelpers\Form
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *          @api
 *          @scope prototype
 */
class SelectViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper
{

    /**
     * Render one option tag
     *
     * @param string $value
     *            value attribute of the option tag (will be escaped)
     * @param string $label
     *            content of the option tag (will be escaped)
     * @param boolean $isSelected
     *            specifies wheter or not to add selected attribute
     * @return string the rendered option tag
     * @author Bastian Waidelich <bastian@typo3.org>
     */
    protected function renderOptionTag($value, $label, $isSelected)
    {
        $class = '';
        if (preg_match('/###class=([\w]+)###/', $label, $match)) {
            $label = str_replace($match[0], '', $label);
            $class = 'class="' . $match[1] . '" ';
        }
        $output = '<option ' . $class . 'value="' . htmlspecialchars($value) . '"';
        if ($isSelected) {
            $output .= ' selected="selected"';
        }
        $output .= '>' . htmlspecialchars($label) . '</option>';
        
        return $output;
    }
}

?>
