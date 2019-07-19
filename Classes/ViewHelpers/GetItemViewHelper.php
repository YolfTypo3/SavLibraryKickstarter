<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

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
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Returns an item in an array
 *
 * @package SavLibraryKickstarter
 *         
 */
class GetItemViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('value', 'array', 'Value of the parameter to change', false, null);
        $this->registerArgument('key', 'string', 'Key of the parameter to change', false, null);
    }

    /**
     * Gets the item.
     *
     * @return mixed The item
     */
    public function render()
    {
        // Gets the arguments
        $value = $this->arguments['value'];
        $key = $this->arguments['key'];

        if ($value === null) {
            $value = $this->renderChildren();
        }

        if ($value === null) {
            return null;
        } elseif ($key === null) {
            return current($value);
        } else {
            return $value[$key];
        }
    }
}
?>
