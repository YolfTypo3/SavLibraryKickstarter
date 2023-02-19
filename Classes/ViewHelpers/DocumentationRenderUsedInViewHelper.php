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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * A view helper for rendering the "used in" to build the documentation.
 *
 * = Examples =
 *
 * <code title="DocumentationRenderUsedIn">
 * <sav:DocumentationRenderUsedIn string="String" />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 */
class DocumentationRenderUsedInViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    protected static $subforms = [];

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('extension', 'array', 'Array to process', true);
        $this->registerArgument('name', 'string', 'newTables or existingTables', false, 'newTables');
        $this->registerArgument('tableKey', 'integer', 'Table key', true);
        $this->registerArgument('fieldKey', 'integer', 'Field key', true);
        $this->registerArgument('mvc', 'boolean', 'MVC flag', false, false);
    }
    /**
     * Renders the viewhelper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $extension = $arguments['extension'];
        $name = $arguments['name'];
        $tableKey = $arguments['tableKey'];
        $fieldKey = $arguments['fieldKey'];
        $mvc = $arguments['mvc'];

        // Builds the table full name
        $extensionKey = $extension['general'][1]['extensionKey'];
        if ($name == 'existingTables') {
            $tableName = $extension[$name][$tableKey]['tablename'];
        } else {
            $tableName = BuildTableNameViewHelper::renderStatic(
                [
                    'extensionKey' => $extensionKey,
                    'shortName' => $extension[$name][$tableKey]['tablename'],
                    'prefix' => '',
                    'shortNameOnly' => false,
                    'mvc' => $mvc,
                ], $renderChildrenClosure, $renderingContext
            );
        }
        $field = $extension[$name][$tableKey]['fields'][$fieldKey];

        $result = '';
        if (!empty($field['selected'])) {
            // Processes the selected fields
            foreach ($field['selected'] as $viewKey => $selected) {
                $fieldName = $field['fieldname'];
                $tableNameForReference = $tableName;
                if ($name == 'existingTables' && $field['type'] != 'ShowOnly') {
                    $fieldName = 'tx_' . str_replace('_', '', $extensionKey) . '_' . $fieldName;
                }
                if (!empty($selected) && !empty($extension['views'][$viewKey])) {
                    // Processes subform fiels. The reference ist set to the root field name
                    if ($field['type'] == 'RelationManyToManyAsSubform') {
                        if ($field['conf_rel_table'] == '_CUSTOM') {
                            $confRelTable = $field['conf_custom_table_name'];
                        } else {
                            $confRelTable = $field['conf_rel_table'];
                        }
                        self::$subforms[$viewKey][$confRelTable] = [
                            'fieldName' => $fieldName,
                            'tableName' => $tableName
                        ];
                        // Updates the stored field name to the root field name
                        foreach(self::$subforms[$viewKey] as $key => $value) {
                            $searchKey = self::searchForTableName(self::$subforms[$viewKey], $key);
                            if ($searchKey !== null) {
                                self::$subforms[$viewKey][$searchKey]['fieldName'] = $value['fieldName'];
                                self::$subforms[$viewKey][$searchKey]['tableName'] = $value['tableName'];
                            }
                        }
                    }
                    $type = $extension['views'][$viewKey]['type'];

                    // Build the view title
                    $viewTitle = $extension['views'][$viewKey]['title'];

                    $folderLabel = '';
                    // Checks if the field is in a folder and processes it if any
                    if (!empty($field['folders']) && !empty($field['folders'][$viewKey])) {
                        $folderKey = $field['folders'][$viewKey];
                        $view = $extension['views'][$viewKey];
                        if (!empty($view['folders']) && !empty($view['folders'][$folderKey]['label'])) {
                            $folderLabel = $view['folders'][$folderKey]['label'];
                        }
                    }
                    $folderLabel = GeneralUtility::md5int($folderLabel);

                    // Gets the root field name if it is a subform
                    if (!empty(self::$subforms[$viewKey][$tableName]) ) {
                        $fieldName = self::$subforms[$viewKey][$tableName]['fieldName'];
                        $tableNameForReference = self::$subforms[$viewKey][$tableName]['tableName'];
                    }

                    // Finds the form title.
                    $formTitle = 'ErrorInFormTitle';
                    foreach ($extension['forms'] as $form) {
                        if ($form[$type . 'View'] == $viewKey) {
                            $formTitle =  $form['title'];
                            break;
                        } else if(!empty($form['viewsWithCondition']) && !empty($form['viewsWithCondition'][$type . 'View'])){
                            foreach ($form['viewsWithCondition'][$type . 'View'] as $viewWithCondition) {
                                if ($viewWithCondition['key'] == $viewKey) {
                                    $formTitle =  $form['title'];
                                    break;
                                }
                            }
                        }
                    }
                    if ($formTitle =='ErrorInFormTitle') {
                        die();
                    }
                    // Builds the reference
                    $result = $result . '- :ref:`' .
                        ucfirst($type) . 'View ' . $viewTitle .
                        ' <' . $type . 'View.' . GeneralUtility::md5int($formTitle) . '.' .
                        GeneralUtility::md5int($viewTitle) . '.' .
                        $folderLabel . '.' .
                        $tableNameForReference . '.' .
                        $fieldName . '>` '. chr(10);
                }
            }
         }

         return $result;
    }

    /**
     * Searches in multi-dimensional array
     *
     * @param string $tableName
     * @param array $data
     * @return string|null the key
     */
    protected static function searchForTableName($data, $tableName) {
        foreach ($data as $subformKey => $subform) {
            if ($subform['tableName'] === $tableName) {
                return $subformKey;
            }
        }
        return null;
    }
}
