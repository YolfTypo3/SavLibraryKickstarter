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

namespace YolfTypo3\SavLibraryKickstarter\Upgrade;

use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Managers\SectionManager;

/**
 * Upgrades the extension from the kickstarter
 *
 * @package Kickstarter
 */
class UpgradeToSavLibraryMvc extends AbstractUpgradeManager
{
    /**
     *
     * @var boolean
     */
    protected $criticalError = false;

    /**
     *
     * @var array
     */
    protected $allowedAttributes = [

        'adddelete'=> [
            'replaceBy' => 'addDelete',
        ],
        'addtouploadfolder'=> [
            'replaceBy' => '',
        ],
        'addupdown'=> [
            'replaceBy' => 'addUpDown',
        ],
        'alias'=> [
            'replaceBy' => 'alias',
        ],
        'classlabel'=> [
            'replaceBy' => 'classLabel',
        ],
        'classvalue'=> [
            'replaceBy' => 'classValue',
        ],
        'cols'=> [
            'replaceBy' => 'cols',
        ],
        'cutif'=> [
            'replaceBy' => 'cutIf',
        ],
        'cutifnull' => [
            'replaceBy' => 'cutIfNull',
            'arguments' => ['0', '1'],
        ],
        'cutlabel' => [
            'replaceBy' => 'cutLabel',
            'arguments' => ['0', '1'],
        ],
        'displayasimage' => [
            'replaceBy' => 'displayAsImage',
        ],
        'donotdisplayifnotchecked' => [
            'replaceBy' => 'doNotDisplayIfNotChecked',
            'arguments' => ['0', '1'],
        ],
        'edit'=> [
            'replaceBy' => 'edit',
        ],
        'fieldmessage' => [
            'replaceBy' => 'fieldMessage',
        ],
        'format' => [
            'replaceBy' => 'format',
        ],
        'func' => [
            'replaceBy' => 'func',
            'arguments' => ['makeItemLink', 'makeDateFormat', 'makeEmailLink'],
        ],
        'fusion' => [
            'replaceBy' => 'fusion',
            'arguments' => ['begin', 'end']
        ],
        'labelselect' => [
            'replaceBy' => 'labelSelect',
        ],
        'maxsubformitems' => [
            'replaceBy' => 'maxSubformItems',
        ],
        'nodefault' => [
            'replaceBy' => [
                'Selectorbox' => 'required',
                'Date' => 'noDefault',
                'DateTime' => 'noDefault',
            ],
        ],
        'orderselect' => [
            'replaceBy' => 'orderSelect',
        ],
        'separator' => [
            'replaceBy' => 'separator',
        ],
        'size' => [
            'replaceBy' => 'size',
        ],
        'rawhtml' => [
            'replaceBy' => ''
        ],
        'rendertype' => [
            'renderType' => ''
        ],
        'required' => [
            'replaceBy' => 'required',
            'arguments' => ['0', '1'],
        ],
        'reqvalue' => [
            'replaceBy' => 'reqValue'
        ],
        'rows' => [
            'replaceBy' => 'rows'
        ],
        'rtestylesheet' => [
            'replaceBy' => ''
        ],
        'showif' => [
            'replaceBy' => 'showIf',
        ],
        'stylelabel' => [
            'replaceBy' => 'styleLabel',
        ],
        'stylevalue' => [
            'replaceBy' => 'styleValue',
        ],
        'tsobject' => [
            'replaceBy' => 'tsObject',
        ],
        'stdwrapvalue' => [
            'replaceBy' => 'stdWrapValue',
        ],
        'tsproperties' => [
            'replaceBy' => 'tsProperties',
        ],
        'updateshowonlyfield' => [
            'replaceBy' => 'updateShowOnlyField',
        ],
        'uploadfolder' => [
            'replaceBy' => 'uploadFolder',
        ],
        'value' => [
            'replaceBy' => 'value',
        ],
        'whereselect' => [
            'replaceBy' => 'whereSelect',
        ],
        'wrapitem' => [
            'replaceBy' => 'wrapItem',
        ],
        'wrapitemifnotcut' => [
            'replaceBy' => 'wrapItemIfNotCut',
        ],
    ];

    /**
     * Pre processing
     *
     * @param SectionManager $sectionManager
     *            The section manager
     * @return void
     */
    public function preProcessing(SectionManager $sectionManager)
    {
        $this->logger->log(LogLevel::NOTICE, sprintf('**********************************'));
        $this->logger->log(LogLevel::NOTICE, sprintf('* Upgrade %s to sav_library_mvc.', $this->extensionKey));
        $this->logger->log(LogLevel::NOTICE, sprintf('**********************************'));
    }

    /**
     * Post processing
     *
     * @param SectionManager $sectionManager
     *            The section manager
     * @return void
     */
    public function postProcessing(SectionManager $sectionManager)
    {
        // Builds the new directory if needed
        $this->configurationManager->buildConfigurationDirectory($this->extensionKey, ConfigurationManager::TYPE_SAV_LIBRARY_MVC);

        // Changes the library type in the library type file
        $libraryName = ConfigurationManager::getLibraryName(ConfigurationManager::TYPE_SAV_LIBRARY_MVC);
        GeneralUtility::writeFile(ConfigurationManager::getLibraryTypeFileName($this->extensionKey), $libraryName);

        // Generates the extension
        $sectionManager->getItem('general')
            ->getItem(1)
            ->addItem([
                'BuildMigration' => true
        ]);

        $this->configurationManager->getCodeGenerator()->buildExtension();

        $sectionManager->getItem('general')
            ->getItem(1)
            ->addItem([
                'BuildMigration' => false
        ]);

        // Removes existing directories
        GeneralUtility::rmdir(ConfigurationManager::getExtensionDir($this->extensionKey) . 'Configuration/Library', true);

        if ($this->criticalError) {
            $this->configurationManager->getController()->addFlashMessage('Conversion to SAV Library MVC contains critical errors. Check the log file', '', AbstractMessage::ERROR);
        }
    }

    /**
     * Upgrades the general section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeGeneralSection(SectionManager $section): SectionManager
    {
        // Changes the library type
        $section->getItem(1)->replace([
            'libraryType' => ConfigurationManager::TYPE_SAV_LIBRARY_MVC
        ]);

        // Adds the default plugin name
        $section->getItem(1)->addItem([
            'pluginName' => 'Default'
        ]);

        return $section;
    }

    /**
     * Upgrades the emconf section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeEmconfSection(SectionManager $section): SectionManager
    {
        // Changes the library type
        $dependencies = $section->getItem(1)->getItem('dependencies');
        $dependencies = str_replace('sav_library_plus', 'sav_library_mvc', $dependencies);
        $section->getItem(1)->replace([
            'dependencies' => $dependencies
        ]);

        return $section;
    }

    /**
     * Upgrades the newTables section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeNewTablesSection(SectionManager $section): SectionManager
    {
        foreach($section as $tableKey => $table) {
            // Keeps the previous table name
            $tableName = $table->getItem('tablename');
            if (!$table->itemExists('originalTableName')) {
                $table->addItem([
                    'originalTableName' => $tableName
                ]);
            }
            if (empty($tableName)) {
                $table->replace([
                    'tablename' => 'entry'
                ]);
            }
            foreach($table->getItem('fields') as $field) {
                if ($field->itemExists('conf_rel_table')) {
                    $confRelTable = $field->getItem('conf_rel_table');
                    $field->replace([
                        'conf_rel_table' => $this->replaceTableRoot($confRelTable)
                    ]);
                }
                $this->processFieldConfiguration($field, $tableKey);
            }
        }

        return $section;
    }

    /**
     * Upgrades the existingTables section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeExistingTablesSection(SectionManager $section): SectionManager
    {
        foreach($section as $tableKey => $table) {
            foreach($table->getItem('fields') as $field) {
                if ($field->itemExists('conf_rel_table')) {
                    $confRelTable = $field->getItem('conf_rel_table');
                    $field->replace([
                        'conf_rel_table' => $this->replaceTableRoot($confRelTable)
                    ]);
                }
                $this->processFieldConfiguration($field, $tableKey);
            }
        }

        return $section;
    }

    /**
     * Upgrades the queries section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeQueriesSection(SectionManager $section): SectionManager
    {

        foreach($section as $queryKey => $query) {
            // Changes the table names
            $mainTable = $query->getItem('mainTable');
            $tableRoot = 'tx_'. str_replace('_', '', $this->extensionKey);
            if ($mainTable == $tableRoot) {
                $mainTable =
                $query->replace([
                    'mainTable' => $mainTable . '_entry'
                ]);
            }
            $this->changeTableRootInSection($query);

            // Removes the use of ###CURENT_PID### in the where clause
            // Gets the new main table name and the where clauses
            $mainTable = $query->getItem('mainTable');
            $whereClause = $query->getItem('whereClause');

            $pattern = '/' . $mainTable . '\.pid\s*=\s*###CURRENT_PID###/';
            if (preg_match($pattern, $whereClause)) {
                $whereClause = preg_replace(
                    '/' . $mainTable . '\.pid\s*=\s*###CURRENT_PID###/',
                    '',
                    $whereClause
                );
                $query->replace([
                    'whereClause' => $whereClause
                ]);

                $this->logger->log(LogLevel::WARNING, sprintf('-> The where clause for query #%d was changed: the use of ###CURENT_PID### was removed.', $queryKey));
            }
        }

        return $section;
    }

    /**
     * Upgrades the forms section.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return SectionManager The modified section
     */
    public function upgradeFormsSection(SectionManager $section): SectionManager
    {
        $extensionDir = ConfigurationManager::getExtensionDir($this->extensionKey);
        $cssFile = $extensionDir . 'Resources/Public/Css/' . $this->extensionKey . '.css';

        if (file_exists($cssFile)) {
            $content = GeneralUtility::getUrl($cssFile);
            // Copies the orginal file
            GeneralUtility::writeFile($cssFile . '.save', $content);
            foreach($section as $formKey => $form) {
                $content = str_replace(
                    $this->extensionKey . '_' . strtolower($form->title),
                    $this->extensionKey . '.' . strtolower($form->title),
                    $content
                );
            }

        }
        GeneralUtility::writeFile($cssFile, $content);

        return $section;
    }


    /**
     * Changes the table root.
     *
     * @param SectionManager $section
     *            The actual section
     *
     * @return void
     */
    protected function changeTableRootInSection(SectionManager $items)
    {
        $tableRoot = 'tx_'. str_replace('_', '', $this->extensionKey);

        foreach($items as $itemKey => $item) {
            if ($item instanceof SectionManager) {
                $this->changeTableRootInSection($item);
            } else {
                if (! empty($item)) {
                    $newItem = $this->replaceTableRoot($item);
                    if ($newItem !== $item) {
                        switch($itemKey) {
                            case 'aliases':
                            case 'foreignTables':
                            case 'groupByClause':
                                $items->deleteItem($itemKey);
                                $this->logger->log(
                                    LogLevel::NOTICE,
                                    sprintf(
                                        '-> Queries: the field %s was removed.',
                                        $itemKey
                                    )
                                );
                                break;
                            default:
                                $items->replace([
                                    $itemKey => $newItem
                                ]);
                                $this->logger->log(
                                    LogLevel::NOTICE,
                                    sprintf(
                                        '-> Queries: the field %s was changed.',
                                        $itemKey)
                                    );
                        }
                    }
                }
            }
        }
    }

    protected function replaceTableRoot(string $item): ?string
    {
        $tableRoot = 'tx_'. str_replace('_', '', $this->extensionKey);
        $count = 0;
        $newItem = str_replace($tableRoot . '.', $tableRoot . '_entry.', $item);
        $result = preg_match(
            '/(' . $tableRoot . '[a-z]*)(?!_domain_model)([a-z_]*)/',
            $newItem,
            $match
        );
        if ($result == 1) {
            if (empty($match[2])) {
                $newItem = preg_replace(
                    '/(' . $tableRoot . '[a-z]*)(?!_domain_model)([a-z_]*)/',
                    '$1_domain_model_entry',
                    $newItem
                );
            } else {
                $newItem = preg_replace(
                    '/(' . $tableRoot . '[a-z]*)(?!_domain_model)([a-z_]*)/',
                    '$1_domain_model$2',
                    $newItem
                );
            }

            return $newItem;
        }

        return $item;
    }


    protected function processFieldConfiguration(SectionManager $field, $tableKey)
    {
        $configuration = $field->getItem('configuration');
        if ($configuration === null) {
            return;
        }
        foreach($configuration as $fieldConfigurationKey => $fieldConfiguration) {
            // Replaces \; by a temporary tag
            $fieldConfiguration = str_replace('\;', '###!!!!!!###', $fieldConfiguration);
            $items = explode(';', $fieldConfiguration);
            $processedItems = [];
            foreach ($items as $itemKey => $item) {
                // Skips comments
                if (preg_match('/^\/\//', trim($item))) {
                    continue;
                }

                if (! empty(trim($item))) {
                    // Replaces the temporary tag by ";"
                    $item = str_replace('###!!!!!!###', '', trim($item));

                    $position = strpos($item, '=');
                    if ($position === false) {
                        $this->logger->log(LogLevel::CRITICAL, sprintf('-> NewTables: missing equal sign in %s.', $item));
                    } else {
                        $attribute = strtolower(trim(substr($item, 0, $position)));
                        $value = ltrim(substr($item, $position + 1));
                        // Checks if attribute can be used in sav_library_mvc
                        $attributeCannotBeUsed  = (
                            ! array_key_exists($attribute, $this->allowedAttributes) ||
                            (
                                array_key_exists($attribute, $this->allowedAttributes) &&
                                is_array($this->allowedAttributes[$attribute]['arguments']) &&
                                ! in_array($value, $this->allowedAttributes[$attribute]['arguments'])
                            ) ||
                            (
                                is_array($this->allowedAttributes[$attribute]['replaceBy']) &&
                                ! array_key_exists($field->type, $this->allowedAttributes[$attribute]['replaceBy'])
                            )
                        );

                        if ($attributeCannotBeUsed) {
                            $processedItems[$itemKey] = $item;
                            $this->logger->log(LogLevel::CRITICAL, sprintf('-> !! NewTables #%d: attribute <%s> is not allowed in field <%s>.', $tableKey, $attribute, $field->fieldname));
                            $this->criticalError = true;
                        } else {
                            if ($this->allowedAttributes[$attribute]['replaceBy'] === '') {
                                $this->logger->log(LogLevel::NOTICE, sprintf('-> NewTables #%d: the attribute <%s> in field <%s> is deprecated and was removed.', $tableKey, $attribute, $field->fieldname));
                            } else {
                                $newValue = $this->replaceTableRoot($value);
                                if ($newValue !== $value) {
                                    $value = $newValue;
                                    $this->logger->log(LogLevel::NOTICE, sprintf('-> NewTables #%d: the attribute value was changed in attribute <%s>.', $tableKey, $attribute));
                                }
                                if (is_array($this->allowedAttributes[$attribute]['replaceBy'])) {
                                    $replaceBy = $this->allowedAttributes[$attribute]['replaceBy'][$field->type];
                                } else {
                                    $replaceBy = $this->allowedAttributes[$attribute]['replaceBy'];
                                }
                                $processedItems[$itemKey] = $replaceBy . ' = '. $value;
                            }
                        }
                    }
                }
            }

            if (! empty($processedItems)) {
                $configuration->replace([
                    $fieldConfigurationKey => implode(';' . chr(10), $processedItems) . ';'
                ]);
            }
        }
    }

}
