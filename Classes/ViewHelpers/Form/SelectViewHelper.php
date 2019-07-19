<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Form;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with TYPO3 source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Just an awful patch to add classes to option.
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
     * @param bool $isSelected
     *            specifies wheter or not to add selected attribute
     * @return string the rendered option tag
     */
    protected function renderOptionTag($value, $label, $isSelected)
    {
        $class = '';
        $match = [];
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
