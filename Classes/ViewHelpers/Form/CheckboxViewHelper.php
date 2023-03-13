<?php

declare(strict_types=1);

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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Form;

/**
 * Sets the value of the hidden field to 0.
 */
class CheckboxViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\CheckboxViewHelper
{

    /**
     * Renders a hidden field with the same name as the element, to make sure the empty value is submitted
     * in case nothing is selected. This is needed for checkbox and multiple select fields
     *
     * @return string the hidden field.
     */
    protected function renderHiddenFieldForEmptyValue()
    {
        $hiddenField = parent::renderHiddenFieldForEmptyValue();

        return str_replace('value=""', 'value="0"', $hiddenField);
    }

}
