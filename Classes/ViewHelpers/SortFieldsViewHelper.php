<?php

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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for sorting the fields in a view.
 *
 * @package SavLibraryKickstarter
 */
class SortFieldsViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
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
     * Renders the item
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return array the options array
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $viewKey = $arguments['viewKey'];
        $fields = $arguments['fields'];

        if ($fields === null) {
            $fields = $renderChildrenClosure();
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
