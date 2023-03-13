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

namespace YolfTypo3\SavLibraryKickstarter\CodeGenerator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Utility\ItemManager;

class PreprocessingForCodeGenerator extends AbstractCodeGenerator
{

    /**
     * The array for code generator
     *
     * @var array
     */
    protected $arrayForCodeGenerator = [];

    /**
     * Builds the array to be used for generating the code generator.
     *
     * @param int $mvc
     * @return void
     */
    protected function buildArrayForCodeGenerator(int $mvc=0)
    {
        $extension = $this->sectionManager->getItemsAsArray();

        // Checks if compatiblity if required
        $this->compatibility = $extension['general'][1]['compatibility'];

        // Converts special characters
        array_walk_recursive($extension, 'self::htmlspecialchars');

        // Generates the version
        $this->arrayForCodeGenerator['general'] = [];
        $this->arrayForCodeGenerator['general']['version'] = ConfigurationManager::getExtensionVersion('sav_library_plus');

        // Generates the extension key
        $this->arrayForCodeGenerator['general']['extensionKey'] = $this->extensionKey;

        // Generates forms
        if (is_array($extension['forms'])) {

            // Copies the forms array and unset the viewsWithCondition field
            $this->arrayForCodeGenerator['forms'] = $extension['forms'];

            // Processes the viewsWithCondition field
            foreach ($this->arrayForCodeGenerator['forms'] as $formKey => $form) {
                if (is_array($form['viewsWithCondition'])) {
                    foreach ($form['viewsWithCondition'] as $viewsWithConditionKey => $viewsWithCondition) {
                        // Processes each view
                        foreach ($viewsWithCondition as $viewWithConditionKey => $viewWithCondition) {
                            $this->arrayForCodeGenerator['forms'][$formKey]['viewsWithCondition'][$viewsWithConditionKey][$viewWithConditionKey] += [
                                'config' => $this->getConfig($viewWithCondition['condition'], $mvc)
                            ];
                        }
                    }
                }
            }
        }

        // Generates queries
        $queries = $extension['queries'];
        if (is_array($queries)) {
            foreach ($queries as $queryKey => $query) {
                $this->arrayForCodeGenerator['queries'][$queryKey] = $query;
                if ($query['whereTags']) {
                    foreach ($query['whereTags'] as $whereTagKey => $whereTag) {
                        $this->arrayForCodeGenerator['queries'][$queryKey]['whereTags'][$whereTagKey]['title'] = $this->cryptTag($whereTag['title']);
                    }
                }
            }
        }

        // Generates views
        $views = $extension['views'];
        $title = [];
        $subformConfiguration = [];
        if (is_array($views)) {
            $relationTable = [];
            foreach ($views as $viewKey => $view) {

                // Generates the templates
                if ($view['type'] == 'list' || $view['type'] == 'special') {
                    if ($view['itemTemplate']) {
                        $this->arrayForCodeGenerator['templates'][$viewKey]['itemTemplate'] = $view['itemTemplate'];
                    }
                    if ($view['viewTemplate']) {
                        $this->arrayForCodeGenerator['templates'][$viewKey]['viewTemplate'] = $view['viewTemplate'];
                    }
                }

                // Checks if it's a print view
                if ($view['type'] == 'special' && $view['subtype'] == 'print') {
                    if ($view['itemsBeforePageBreak']) {
                        $this->arrayForCodeGenerator['templates'][$viewKey]['itemsBeforePageBreak'] = $view['itemsBeforePageBreak'];
                    }
                    if ($view['itemsBeforeFirstPageBreak']) {
                        $this->arrayForCodeGenerator['templates'][$viewKey]['itemsBeforeFirstPageBreak'] = $view['itemsBeforeFirstPageBreak'];
                    }
                }

                // Checks if it's a form view
                // If a submit icon is added, create a field _submitted_data_ to save the submitted data
                if ($view['type'] == 'special' && $view['subtype'] == 'form') {
                    foreach ($extension['forms'] as $keyForm => $form) {
                        if ($form['specialView'] == $viewKey) {
                            $this->arrayForCodeGenerator['forms'][$keyForm]['formView'] = $viewKey;
                            $this->arrayForCodeGenerator['forms'][$keyForm]['specialView'] = 0;
                            break;
                        }
                    }
                }

                // Processes folders
                $sortedFolders = [];
                if (! empty($view['folders'] ?? null)) {
                    $opt_showFolders = [
                        0 => [
                            'label' => '0'
                        ]
                    ];
                    $folderConfiguration = [];
                    foreach ($view['folders'] as $folderKey => $folder) {
                        $folderConfiguration['label'] = $folder['label'];
                        $folderConfiguration['configuration'] = $folder['configuration'];
                        $opt_showFolders[$folderKey] = $folderConfiguration;
                        $sortedFolders[$folder['order']] = $folderKey;
                    }
                    ksort($sortedFolders);
                }

                // Gets the list of the fields organized by folders
                $showFolders = [];
                $showFields = [];
                $newTables = $extension['newTables'] ?? null;
                if (is_array($newTables)) {
                    $title[$viewKey]['configuration']['field'] = $view['viewTitleBar'];
                    foreach ($newTables as $tableKey => $table) {
                        $tableRootName = 'tx_' . str_replace('_', '', $this->extensionKey);
                        $tableName = $tableRootName . ($mvc ? '_domain_model' : '') . ($table['tablename'] ? '_' . $table['tablename'] : '');

                        // Adds save and new in the general configuration
                        if ($table['save_and_new']) {
                            $this->arrayForCodeGenerator['general']['saveAndNew'][$tableName] = 1;
                        }
                        // Puts the fields in the right order for the view
                        $orderedFields = [];
                        $fields = $table['fields'];
                        if (is_array($fields)) {
                            foreach ($fields as $fieldKey => $field) {
                                if (isset($field['selected'][$viewKey])) {
                                    $orderedFields[$field['order'][$viewKey]] = $fieldKey;
                                }
                            }
                        }

                        if (! empty($orderedFields)) {
                            ksort($orderedFields);
                            unset($table['fields']);
                            foreach ($orderedFields as $fieldKey => $field) {
                                $table['fields'][$field] = $fields[$field];
                            }
                            foreach ($table['fields'] as $fieldKey => $field) {
                                if (isset($field['folders'][$viewKey])) {
                                    if (isset($view['folders'])) {
                                        $showFolders[$field['folders'][$viewKey]][] = [
                                            'table' => $tableKey,
                                            'field' => $fieldKey,
                                            'wizArray' => 'newTables',
                                            'tableName' => $tableName
                                        ];
                                    } else {
                                        $showFields[] = [
                                            'table' => $tableKey,
                                            'field' => $fieldKey,
                                            'wizArray' => 'newTables',
                                            'tableName' => $tableName
                                        ];
                                        $extension['newTables'][$tableKey]['fields'][$fieldKey]['folders'][$viewKey] = 0;
                                    }
                                } else {
                                    $showFields[] = [
                                        'table' => $tableKey,
                                        'field' => $fieldKey,
                                        'wizArray' => 'newTables',
                                        'tableName' => $tableName
                                    ];
                                }
                            }
                        }
                    }
                }

                $existingTables = $extension['existingTables'] ?? null;
                if (is_array($existingTables)) {
                    if (! $title[$viewKey]['configuration']['field']) {
                        $title[$viewKey]['configuration']['field'] = $view['viewTitleBar'];
                    }
                    foreach ($existingTables as $tableKey => $table) {
                        $tableName = $table['tablename'];

                        // Checks if the localization must be overrided
                        if ($table['overrideLocalization']) {
                            $this->arrayForCodeGenerator['general']['overridedTablesForLocalization'][$tableName] = true;
                        }

                        // Puts the fields in the right order for the view
                        unset($orderedFields);
                        $fields = $table['fields'];
                        if (is_array($fields)) {
                            foreach ($fields as $fieldKey => $field) {

                                if ($field['type'] != 'ShowOnly') {
                                    // Generates the additional TCA information
                                    $prefix = 'tx_' . str_replace('_', '', $this->extensionKey) . '_';
                                    $column = $field;
                                    $column['fieldname'] = $prefix . $field['fieldname'];
                                    $columns[$prefix . $field['fieldname']] = $column;
                                }
                                if ($field['selected'][$viewKey]) {
                                    $orderedFields[$field['order'][$viewKey]] = $fieldKey;
                                }
                            }
                        }

                        if (is_array($orderedFields)) {
                            ksort($orderedFields);
                            unset($table['fields']);
                            foreach ($orderedFields as $fieldKey => $field) {
                                $table['fields'][$field] = $fields[$field];
                            }
                            foreach ($table['fields'] as $fieldKey => $field) {
                                if ($field['folders'][$viewKey]) {
                                    if ($view['folders']) {
                                        $showFolders[$field['folders'][$viewKey]][] = [
                                            'table' => $tableKey,
                                            'field' => $fieldKey,
                                            'wizArray' => 'existingTables',
                                            'tableName' => $tableName
                                        ];
                                    } else {
                                        $showFields[] = [
                                            'table' => $tableKey,
                                            'field' => $fieldKey,
                                            'wizArray' => 'existingTables',
                                            'tableName' => $tableName
                                        ];
                                        $extension['existingTables'][$tableKey]['fields'][$fieldKey]['folders'][$viewKey] = 0;
                                    }
                                } else {
                                    $showFields[] = [
                                        'table' => $tableKey,
                                        'field' => $fieldKey,
                                        'wizArray' => 'existingTables',
                                        'tableName' => $tableName
                                    ];
                                }
                            }
                        }
                    }
                }

                // Generates the views
                if (! empty($showFolders)) {
                    ksort($showFolders);
                } else {
                    if (isset($showFields)) {
                        $showFolders[0] = $showFields;
                        $opt_showFolders[0] = [
                            'label' => '0'
                        ];
                        $sortedFolders[0] = 0;
                    }
                }

                if (! empty($showFolders)) {
                    foreach ($sortedFolders as $folderKey) {
                        $fieldConfiguration = [];

                        // Gets the folder fields
                        $folderFields = $showFolders[$folderKey];
                        $folderName = $opt_showFolders[$folderKey]['label'];
                        $cryptedFolderName = $this->cryptTag($folderName);

                        // Gets the folder config parameter
                        $this->arrayForCodeGenerator['views'][$viewKey][$cryptedFolderName]['configuration'] = $this->getConfig($opt_showFolders[$folderKey]['configuration'] ?? null, $mvc) + [
                            'label' => $folderName
                        ];

                        // Generates the title
                        if ($view['viewTitleBar'] && ! is_array($title[$viewKey])) {
                            $title[$viewKey]['configuration']['field'] = $view['viewTitleBar'];
                            $title[$viewKey]['configuration']['type'] = 'input';
                        }
                        $this->arrayForCodeGenerator['views'][$viewKey][$cryptedFolderName]['title'] = $title[$viewKey];

                        // Generates the addPrintIcon information
                        if (isset($view['addPrintIcon'])) {
                            $this->arrayForCodeGenerator['views'][$viewKey][$cryptedFolderName]['addPrintIcon'] = $view['addPrintIcon'];
                            if (isset($view['viewForPrintIcon'])) {
                                $this->arrayForCodeGenerator['views'][$viewKey][$cryptedFolderName]['viewForPrintIcon'] = $view['viewForPrintIcon'];
                            }
                        }

                        // Processes the folders
                        if (is_array($folderFields)) {
                            foreach ($folderFields as $folderField) {
                                $config = [];

                                // Gets the field
                                $wizArrayKey = $folderField['wizArray'];
                                $tableKey = $folderField['table'];
                                $fieldKey = $folderField['field'];
                                $field = $extension[$wizArrayKey][$tableKey]['fields'][$fieldKey];

                                $fieldName = (($wizArrayKey == 'existingTables' && $field['type'] != 'ShowOnly') ? 'tx_' . str_replace('_', '', $this->extensionKey) . '_' . $field['fieldname'] : $field['fieldname']);
                                $tableName = $folderField['tableName'];
                                $fullFieldName = $tableName . '.' . $fieldName;
                                $cryptedFullFieldName = $this->cryptTag($fullFieldName);

                                // Generates the field
                                if ($field['selected'][$viewKey]) {

                                    // Sets the user configuration parameters
                                    $config['tableName'] = $tableName;
                                    $config['fieldName'] = $fieldName;
                                    $config['fieldType'] = $field['type'];
                                    $config['fieldTitle'] = $field['title'];

                                    // Checks if the type is showOnly
                                    if ($field['type'] == 'ShowOnly') {
                                        $config['renderType'] = ($field['conf_render_type'] ? $field['conf_render_type'] : 'String');
                                    }

                                    // Checks if it is a subform
                                    if ($field['type'] == 'RelationManyToManyAsSubform') {
                                        if ($field['conf_rel_table'] == '_CUSTOM') {
                                            $relationTableName = $field['conf_custom_table_name'];
                                        } else {
                                            $relationTableName = $field['conf_rel_table'];
                                        }
                                        $relationTable[$viewKey][$relationTableName] = $cryptedFullFieldName;
                                    }

                                    // Checks if its a subform field
                                    if (is_array($relationTable[$viewKey] ?? null) && array_key_exists($tableName, $relationTable[$viewKey])) {
                                        $relationTableKey = $relationTable[$viewKey][$tableName];
                                        $subformConfiguration[$viewKey][$relationTableKey] = array_merge($subformConfiguration[$viewKey][$relationTableKey] ?? [], [
                                            $cryptedFullFieldName => [
                                                'configuration' => $this->getConfig($field['configuration'][$viewKey] ?? null, $mvc) + $config + [
                                                    'subformItem' => 1
                                                ]
                                            ]
                                        ]);
                                    } else {
                                        $fieldConfiguration[$cryptedFullFieldName] = [
                                            'configuration' => $this->getConfig($field['configuration'][$viewKey] ?? null, $mvc) + $config
                                        ];
                                    }
                                }
                            }
                        }

                        $this->arrayForCodeGenerator['views'][$viewKey][$cryptedFolderName]['fields'] = $fieldConfiguration;
                    }
                }
            }

            // Adds the subform configuration
            $views = $extension['views'];
            if (is_array($views)) {
                foreach ($views as $viewKey => $view) {
                    if (is_array($subformConfiguration[$viewKey] ?? null)) {
                        $arrayToAdd = [];
                        foreach ($subformConfiguration[$viewKey] as $subformKey => $subform) {
                            $arrayToAdd['configuration'][$this->cryptTag('0')]['fields'] = $subform;
                            $this->addConfiguration($this->arrayForCodeGenerator['views'][$viewKey], $subformKey, $arrayToAdd);
                        }
                    }
                }
            }
        }
    }

    /**
     * Gets the configuration of a field.
     *
     * @param string|null $fieldConf
     *            The field.
     * @param int mvc Mvc flag for SAV Library MVC
     * @return array The configuration
     */
    protected function getConfig(?string $fieldConf = null, int $mvc = 0): array
    {
        $config = [];
        if (empty($fieldConf)) {
            return $config;
        }

        // Replaces \; by a temporary tag
        $fieldConf = str_replace('\;', '###!!!!!!###', htmlspecialchars_decode($fieldConf));
        $params = explode(';', $fieldConf);

        foreach ($params as $param) {
            // Removes comments
            if (preg_match('/^\/\//', trim($param))) {
                continue;
            }

            if (trim($param)) {
                // Replaces the temporary tag by ";"
                $param = str_replace('###!!!!!!###', ';', $param);

                $pos = strpos($param, '=');
                if ($pos === false) {
                    throw new \RuntimeException('Missing equal sign in ' . $param);
                } else {
                    if ($mvc) {
                        $exp = trim(substr($param, 0, $pos));
                    } else {
                        $exp = strtolower(trim(substr($param, 0, $pos)));
                    }
                    // Removes trailing spaces
                    $configuration = htmlspecialchars(ltrim(substr($param, $pos + 1)));
                    $configuration = preg_replace('/\s+([\n\r])/', '$1', $configuration);
                    $config[$exp] = $configuration;
                }
            }
        }

        return $config;
    }


    /**
     * Crypts a tag with a md5 algorithm.
     *
     * @param string $tag
     *            The tag to crypt.
     * @return string The crypted tag
     */
    protected function cryptTag(string $tag): string
    {
        return 'a' . GeneralUtility::md5int($tag);
    }

    /**
     * Method called by array_walk_recursive to convert special characters and
     * remove trailing spaces
     *
     * @param mixed $item
     *            The item
     * @return string The rendered view
     */
    public static function htmlspecialchars(&$item)
    {
        if (is_string($item)) {
            $item = htmlspecialchars($item);
            $item = preg_replace('/\s+([\n\r])/', '$1', $item);
        }
        return $item;
    }

    /**
     * Searches recursively a configuration in an aray, given a key
     *
     * @param array $arrayToSearchIn
     * @param string $key
     * @return array|false
     */
    public function searchConfiguration(array $arrayToSearchIn, string $key): array
    {
        foreach ($arrayToSearchIn as $itemKey => $item) {
            if ($itemKey == $key) {
                return $item;
            } elseif (is_array($item)) {
                $configuration = $this->searchConfiguration($item, $key);
                if ($configuration != false) {
                    return $configuration;
                }
            }
        }
        return false;
    }

    /**
     * Adds a configuration to the right place after a recursive search, given � key
     *
     * @param array $arrayToSearchIn
     * @param string $key
     * @param array $arrayToAdd
     * @return bool
     */
    public function addConfiguration(array &$arrayToSearchIn, string $key, array $arrayToAdd): bool
    {
        foreach ($arrayToSearchIn as $itemKey => $item) {
            if ($itemKey == $key) {
                $arrayToSearchIn[$itemKey]['configuration'] = array_replace($arrayToSearchIn[$itemKey]['configuration'], $arrayToSearchIn[$itemKey]['configuration'] + $arrayToAdd['configuration']);
                return true;
            } elseif (is_array($item)) {
                $configuration = $this->addConfiguration($arrayToSearchIn[$itemKey], $key, $arrayToAdd);
                if ($configuration != false) {
                    return true;
                }
            }
        }
        return false;
    }
}