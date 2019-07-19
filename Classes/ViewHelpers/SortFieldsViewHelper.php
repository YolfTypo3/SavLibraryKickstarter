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
 * A view helper for sorting the fields in a view.
 *
 * @package SavLibraryKickstarter
 */
class SortFieldsViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('viewKey', 'integer', 'View key', true);
        $this->registerArgument('fields', 'array', 'Fields', false, null);
    }

    /**
     * Renders the viewhelper
     *
     * @return array Sorted fields
     */
    public function render(): array
    {
        // Gets the arguments
        $viewKey = $this->arguments['viewKey'];
        $fields = $this->arguments['fields'];

        if ($fields === null) {
            $fields = $this->renderChildren();
        }

        $sortedKeys = [];
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
        $sortedFields = [];
        foreach ($sortedKeys as $fieldKey) {
            $sortedFields[$fieldKey] = $fields[$fieldKey];
        }

        return $sortedFields;
    }
}
?>

