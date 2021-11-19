<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace YolfTypo3\SavLibraryKickstarter\CodeGenerator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * This class generates the code for a frontend plugin.
 *
 * It is based on the same idea developed by Ingmar Schlecht for the extbase_kickstater.
 * Code templates are used to build the file contents. They are processed by a fluid parser.
 *
 * @package SavLibraryKickstarter
 */
class CodeGeneratorForSavLibraryPlus extends AbstractCodeGenerator
{

    /**
     * The code templates directory
     *
     * @var string
     */
    protected static $codeTemplatesDirectory = 'Resources/Private/CodeTemplates/ForSavLibraryPlus/';

    /**
     * The xml array
     *
     * @var array
     */
    protected $xmlArray = [];

    /**
     * The compatibility flag
     *
     * @var integer
     */
    protected $compatibility = ConfigurationManager::COMPATIBILITY_TYPO3_DEFAULT;

    /**
     * Builds the extension.
     *
     * @return void
     */
    public function buildExtension()
    {
        // Checks if the extension can be built
        if (! $this->CanBuildExtension()) {
            return;
        }

        // Generates the xml array
        $this->setXmlArray();

        // Generates the Icons
        $this->buildIcons();

        // Generates ext_emconf.php
        $this->buildExtEmConf();

        // Generates composer.json
        $this->buildComposer();

        // Generates ext_localconf.php
        $this->buildExtLocalConf();

        // Generates ext_tables Files
        $this->buildExtTablesFiles();

        // Generates ext_conf_template.txt
        $this->buildExtConfTemplate();

        // Generates the Configuration files
        $this->buildConfigurationFlexform();
        $this->buildConfigurationLibrary();
        $this->buildConfigurationTca();

        // Generates Documentation files
        $this->buildDocumentation();

        // Generates the language files
        $this->buildLanguageFiles();

        // Generates the Controller
        $this->buildController();
    }

    /**
     * Specific methods for this generator
     */

    /**
     * Builds ext_conf_template.txt.
     *
     * @return void
     */
    protected function buildExtConfTemplate()
    {
        // Generates ext_conf_template.txt
        $fileContents = $this->generateFile('extConfTemplate.txtt');
        GeneralUtility::writeFile($this->extensionDirectory . 'ext_conf_template.txt', $fileContents);
    }

    /**
     * Builds the Library Configuration file.
     *
     * @return void
     */
    protected function buildConfigurationLibrary()
    {
        // Generates the Configuration/Library directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Configuration/Library/');

        // Generates flexforms
        $fileContents = $this->generateFile('Configuration/Library/SavLibraryPlus.xmlt', null, $this->xmlArray);
        GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Library/SavLibraryPlus.xml', $fileContents);
    }

    /**
     * Builds the documentation.
     *
     * @return void
     */
    protected function buildDocumentation()
    {
        // Generates the parent documentation
        parent::buildDocumentation();

        // Creates the folders
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/Forms');


        // Prepares the data
        $extension = $this->sectionManager->getItemsAsArray();
        $data = $extension;
        $data['extensionDirectory'] = $this->extensionDirectory;
        $data['viewsFields'] = $this->xmlArray['views'];

        // Generates the specific documentation for SAV Library Plus
        $fileContents = $this->generateFile('Documentation/Forms/Index.rstt', null, $data);
        GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/Forms/Index.rst', $fileContents);
        if (!empty($extension['newTables'])) {
            GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/NewTables');
            $fileContents = $this->generateFile('Documentation/NewTables/Index.rstt', null, $data);
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/NewTables/Index.rst', $fileContents);
        }
        if (!empty($extension['existingTables'])) {
            GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/ExistingTables');
            $fileContents = $this->generateFile('Documentation/ExistingTables/Index.rstt', null, $data);
            GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/ExistingTables/Index.rst', $fileContents);
        }
    }

    /**
     * Builds the controller.
     *
     * @return void
     */
    protected function buildController()
    {
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Controller/');
        $fileContents = $this->generateFile('Classes/Controller/Controller.phpt');
        GeneralUtility::writeFile($this->extensionDirectory . 'Classes/Controller/' . GeneralUtility::underscoredToUpperCamelCase($this->extensionKey) . 'Controller.php', $fileContents);
    }

    /**
     * Builds the array to be used for generating the XML file in pi1 directory.
     * This method was taken from the "old" generator implemented in sav_library.
     * It will probably change in the next version.
     *
     * @return void
     */
    protected function setXmlArray()
    {
        $extension = $this->sectionManager->getItemsAsArray();

        // Checks if compatiblity if required
        $this->compatibility = $extension['general'][1]['compatibility'];

        // Converts special characters
        array_walk_recursive($extension, 'YolfTypo3\\SavLibraryKickstarter\\CodeGenerator\\CodeGeneratorForSavLibraryPlus::htmlspecialchars');

        // Generates the version
        $this->xmlArray['general'] = [];
        $this->xmlArray['general']['version'] = ConfigurationManager::getExtensionVersion('sav_library_plus');

        // Generates the extension key
        $this->xmlArray['general']['extensionKey'] = $this->extensionKey;

        // Generates forms
        if (is_array($extension['forms'])) {

            // Copies the forms array and unset the viewsWithCondition field
            $this->xmlArray['forms'] = $extension['forms'];

            // Processes the viewsWithCondition field
            foreach ($this->xmlArray['forms'] as $formKey => $form) {
                if (is_array($form['viewsWithCondition'])) {
                    foreach ($form['viewsWithCondition'] as $viewsWithConditionKey => $viewsWithCondition) {
                        // Processes each view
                        foreach ($viewsWithCondition as $viewWithConditionKey => $viewWithCondition) {
                            $this->xmlArray['forms'][$formKey]['viewsWithCondition'][$viewsWithConditionKey][$viewWithConditionKey] += [
                                'config' => $this->getConfig($viewWithCondition['condition'])
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
                $this->xmlArray['queries'][$queryKey] = $query;
                if ($query['whereTags']) {
                    foreach ($query['whereTags'] as $whereTagKey => $whereTag) {
                        $this->xmlArray['queries'][$queryKey]['whereTags'][$whereTagKey]['title'] = $this->cryptTag($whereTag['title']);
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
                        $this->xmlArray['templates'][$viewKey]['itemTemplate'] = $view['itemTemplate'];
                    }
                    if ($view['viewTemplate']) {
                        $this->xmlArray['templates'][$viewKey]['viewTemplate'] = $view['viewTemplate'];
                    }
                }

                // Checks if it's a print view
                if ($view['type'] == 'special' && $view['subtype'] == 'print') {
                    if ($view['itemsBeforePageBreak']) {
                        $this->xmlArray['templates'][$viewKey]['itemsBeforePageBreak'] = $view['itemsBeforePageBreak'];
                    }
                    if ($view['itemsBeforeFirstPageBreak']) {
                        $this->xmlArray['templates'][$viewKey]['itemsBeforeFirstPageBreak'] = $view['itemsBeforeFirstPageBreak'];
                    }
                }

                // Checks if it's a form view
                // If a submit icon is added, create a field _submitted_data_ to save the submitted data
                if ($view['type'] == 'special' && $view['subtype'] == 'form') {
                    foreach ($extension['forms'] as $keyForm => $form) {
                        if ($form['specialView'] == $viewKey) {
                            $this->xmlArray['forms'][$keyForm]['formView'] = $viewKey;
                            $this->xmlArray['forms'][$keyForm]['specialView'] = 0;
                            break;
                        }
                    }
                }

                // Processes folders
                $sortedFolders = [];
                if ($view['folders']) {
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
                $newTables = $extension['newTables'];
                if (is_array($newTables)) {
                    $title[$viewKey]['configuration']['field'] = $view['viewTitleBar'];
                    foreach ($newTables as $tableKey => $table) {
                        $tableRootName = 'tx_' . str_replace('_', '', $this->extensionKey);
                        $tableName = $tableRootName . ($table['tablename'] ? '_' . $table['tablename'] : '');

                        // Adds save and new in the general configuration
                        if ($table['save_and_new']) {
                            $this->xmlArray['general']['saveAndNew'][$tableName] = 1;
                        }
                        // Puts the fields in the right order for the view
                        $orderedFields = [];
                        $fields = $table['fields'];
                        if (is_array($fields)) {
                            foreach ($fields as $fieldKey => $field) {
                                if ($field['selected'][$viewKey]) {
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
                                if ($field['folders'][$viewKey]) {
                                    if ($view['folders']) {
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

                $existingTables = $extension['existingTables'];
                if (is_array($existingTables)) {
                    if (! $title[$viewKey]['configuration']['field']) {
                        $title[$viewKey]['configuration']['field'] = $view['viewTitleBar'];
                    }
                    foreach ($existingTables as $tableKey => $table) {
                        $tableName = $table['tablename'];

                        // Checks if the localization must be overrided
                        if ($table['overrideLocalization']) {
                            $this->xmlArray['general']['overridedTablesForLocalization'][$tableName] = true;
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
                        $this->xmlArray['views'][$viewKey][$cryptedFolderName]['configuration'] = $this->getConfig($opt_showFolders[$folderKey]['configuration']) + [
                            'label' => $folderName
                        ];

                        // Generates the title
                        if ($view['viewTitleBar'] && ! is_array($title[$viewKey])) {
                            $title[$viewKey]['configuration']['field'] = $view['viewTitleBar'];
                            $title[$viewKey]['configuration']['type'] = 'input';
                        }
                        $this->xmlArray['views'][$viewKey][$cryptedFolderName]['title'] = $title[$viewKey];

                        // Generates the addPrintIcon information
                        if ($view['addPrintIcon']) {
                            $this->xmlArray['views'][$viewKey][$cryptedFolderName]['addPrintIcon'] = $view['addPrintIcon'];
                            if ($view['viewForPrintIcon']) {
                                $this->xmlArray['views'][$viewKey][$cryptedFolderName]['viewForPrintIcon'] = $view['viewForPrintIcon'];
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
                                    if (is_array($relationTable[$viewKey]) && array_key_exists($tableName, $relationTable[$viewKey])) {
                                        $relationTableKey = $relationTable[$viewKey][$tableName];
                                        $subformConfiguration[$viewKey][$relationTableKey] = array_merge((array) $subformConfiguration[$viewKey][$relationTableKey], [
                                            $cryptedFullFieldName => [
                                                'configuration' => $this->getConfig($field['configuration'][$viewKey]) + $config + [
                                                    'subformItem' => 1
                                                ]
                                            ]
                                        ]);
                                    } else {
                                        $fieldConfiguration[$cryptedFullFieldName] = [
                                            'configuration' => $this->getConfig($field['configuration'][$viewKey]) + $config
                                        ];
                                    }
                                }
                            }
                        }

                        $this->xmlArray['views'][$viewKey][$cryptedFolderName]['fields'] = $fieldConfiguration;
                    }
                }
            }

            // Adds the subform configuration
            $views = $extension['views'];
            if (is_array($views)) {
                foreach ($views as $viewKey => $view) {
                    if (is_array($subformConfiguration[$viewKey])) {
                        $arrayToAdd = [];
                        foreach ($subformConfiguration[$viewKey] as $subformKey => $subform) {
                            $arrayToAdd['configuration'][$this->cryptTag('0')]['fields'] = $subform;
                            $this->addConfiguration($this->xmlArray['views'][$viewKey], $subformKey, $arrayToAdd);
                        }
                    }
                }
            }
        }
    }

    /**
     * Gets the configuration of a field.
     *
     * @param string $fieldConf
     *            The field.
     * @return array The configuration
     */
    protected function getConfig(string $fieldConf = null): array
    {
        $config = [];

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
                    $exp = strtolower(trim(substr($param, 0, $pos)));
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
