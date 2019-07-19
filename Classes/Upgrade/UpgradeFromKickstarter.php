<?php
namespace YolfTypo3\SavLibraryKickstarter\Upgrade;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Utility\ItemManager;

/**
 * Upgrades the extension from the kickstarter
 *
 * @package Kickstarter
 */
class UpgradeFromKickstarter extends AbstractUpgradeManager
{

    /**
     * Pre processing of the extension.
     *
     * @return void
     */
    public function preProcessing()
    {
        $extensionKey = $this->getExtensionKey();
        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);

        $wizardFormFileName = $extensionDirectory . 'doc/wizard_form.dat';
        $wizardFormFileContent = GeneralUtility::getURL($wizardFormFileName);
        $configuration = unserialize($wizardFormFileContent);

        // Converts each field in utf8 (required by json_encode)
        array_walk_recursive($configuration, '\YolfTypo3\SavLibraryKickstarter\Configuration\ConfigurationManager::utf8_encode');

        $newConfiguration = [];

        // Changes the name to 'general' and remove the array
        $newConfiguration['general'] = $configuration['savext'];

        // Add the plugin title to the general section
        $newConfiguration['general'][1]['pluginTitle'] = $configuration['pi'][1]['title'];

        // Adds the 'emconf' section'
        $newConfiguration['emconf'] = $configuration['emconf'];

        // Adds the 'pi' section'
        $newConfiguration['pi'] = $configuration['pi'];

        // Adds the 'languages' section'
        $newConfiguration['languages'] = $configuration['languages'];

        // Changes the name to 'newTables'
        $newConfiguration['newTables'] = $configuration['tables'];

        // Changes the name to 'existingTables'
        $newConfiguration['existingTables'] = $configuration['fields'];

        // Changes the name to 'views'
        $newConfiguration['views'] = $configuration['formviews'];

        // Changes the name to 'queries'
        $newConfiguration['queries'] = $configuration['formqueries'];

        // Adds the 'form' section'
        $newConfiguration['forms'] = $configuration['forms'];

        // Defines the library type
        $libraryType = 'SavLibrary';

        // Creates the configuration directory if needed
        $configurationDirectory = $extensionDirectory . ConfigurationManager::CONFIGURATION_DIRECTORY . $libraryType . '/';
        if (! is_dir($configurationDirectory)) {
            GeneralUtility::mkdir_deep($configurationDirectory);
        }

        // Saves the library type
        GeneralUtility::writeFile(ConfigurationManager::getLibraryTypeFileName($extensionKey), $libraryType);

        // Saves the file to the JSON format
        $jsonContent = json_encode($newConfiguration);
        GeneralUtility::writeFile(ConfigurationManager::getConfigurationFileName($extensionKey), $jsonContent);
    }

    /**
     * Upgrades the general section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeGeneralSection(ItemManager $configuration): array
    {
        // Removes unused fields
        $configuration->getItem(1)->deleteItem('savlibraryVersion');
        $configuration->getItem(1)->deleteItem('generateForm');
        $configuration->getItem(1)->deleteItem('newExtensionWrite');

        $newConfiguration = $configuration->getItemsAsArray();

        // Adds the extension key
        $newConfiguration[1]['extensionKey'] = $this->getExtensionKey();

        // Adds the library type
        $newConfiguration[1]['libraryType'] = ConfigurationManager::TYPE_SAV_LIBRARY;

        // Changes the library version name
        $newConfiguration[1]['libraryVersion'] = '3.1.3';

        // Sets the debug flag to 0
        $newConfiguration[1]['debug'] = 0;

        return $newConfiguration;
    }

    /**
     * Upgrades the emconf section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeEmconfSection(ItemManager $configuration): array
    {
        $newConfiguration = $configuration->getItemsAsArray();

        return $newConfiguration;
    }

    /**
     * Upgrades the languages section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeLanguagesSection(ItemManager $configuration): array
    {
        $newConfiguration = $configuration->getItemsAsArray();

        return $newConfiguration;
    }

    /**
     * Upgrades the pi section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradePiSection(ItemManager $configuration): array
    {
        $newConfiguration = $configuration->getItemsAsArray();

        return $newConfiguration;
    }

    /**
     * Upgrades the newTables section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeNewTablesSection(ItemManager $configuration): array
    {
        $newConfiguration = [];
        foreach ($configuration->getItemsAsArray() as $key => $item) {

            $itemConfiguration = $item;

            // Removes unused fields
            unset($itemConfiguration['conf_opt_formViews']);

            // Changes the name for the View Key
            $itemConfiguration['viewKey'] = $item['conf_viewWizKey'];
            unset($itemConfiguration['conf_viewWizKey']);

            // Sets the tablename
            $itemConfiguration['tablename'] = $item['tablename'];

            // Removes ".gif" in defIcon
            $itemConfiguration['defIcon'] = preg_replace('/^([^\.]+)\.gif/', '$1', $item['defIcon']);

            // Upgrades the fields
            foreach ($item['fields'] as $keyField => $field) {

                // Upgrades the field based on its type
                $field = $this->upgradeFieldFromType($field);

                // Changes the name for the order
                $field['order'] = $field['conf_showOrder'];
                unset($field['conf_showOrder']);

                // Changes the name for the view Key
                $field['viewKey'] = $field['conf_showFieldWizKey'];
                unset($field['conf_showFieldWizKey']);

                // Changes the name for the field configuration
                $field['selected'] = $field['conf_showFieldDisp'];
                unset($field['conf_showFieldDisp']);

                // Changes the name for the field configuration
                $field['configuration'] = $field['conf_showField'];
                unset($field['conf_showField']);

                // Changes the name for the folders configuration
                $field['folders'] = $field['conf_showFolders'];
                unset($field['conf_showFolders']);

                // Removes unused fields
                unset($field['conf_showFieldExpand']);
                unset($field['conf_moveAfter']);
                unset($field['_DELETE']);

                $itemConfiguration['fields'][$keyField] = $field;
            }

            // Removes the item
            $configuration->deleteItem($key);

            $newConfiguration[$key] = $itemConfiguration;
        }

        return $newConfiguration;
    }

    /**
     * Upgrades the existingTables section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeExistingTablesSection(ItemManager $configuration): array
    {
        $newConfiguration = [];
        $correctedFieldsConfiguration = [];
        foreach ($configuration->getItemsAsArray() as $key => $item) {

            $itemConfiguration = $item;

            // Removes unused fields
            unset($itemConfiguration['conf_opt_formViews']);

            // Changes the name for the View Key
            $itemConfiguration['viewKey'] = $item['conf_viewWizKey'];
            unset($itemConfiguration['conf_viewWizKey']);

            // Sets the tablename
            $itemConfiguration['tablename'] = $item['which_table'];
            unset($itemConfiguration['which_table']);

            // Upgrades the fields. Due to a bug in the modified kickstarter
            // some processing is required to correct the field keys.
            $newKeyField = 1;
            foreach ($item['fields'] as $keyField => $field) {

                // Upgrades the field based on its type
                $field = $this->upgradeFieldFromType($field);

                // Changes the name for the order
                $field['order'] = $field['conf_showOrder'];
                unset($field['conf_showOrder']);

                // Changes the name for the view Key
                $field['viewKey'] = $field['conf_showFieldWizKey'];
                unset($field['conf_showFieldWizKey']);

                // Changes the name for the field configuration
                $field['selected'] = $field['conf_showFieldDisp'];
                unset($field['conf_showFieldDisp']);

                // Changes the name for the field configuration
                $field['configuration'] = $field['conf_showField'];
                unset($field['conf_showField']);

                // Changes the name for the folders configuration
                $field['folders'] = $field['conf_showFolders'];
                unset($field['conf_showFolders']);

                // Removes unused fields
                unset($field['conf_showFieldExpand']);
                unset($field['conf_moveAfter']);
                unset($field['_DELETE']);

                unset($itemConfiguration['fields'][$keyField]);
                $correctedFieldsConfiguration['fields'][$newKeyField ++] = $field;
            }

            // Removes the item
            $configuration->deleteItem($key);

            $newConfiguration[$key] = array_merge($itemConfiguration, $correctedFieldsConfiguration);
        }

        return $newConfiguration;
    }

    /**
     * Upgrades the views section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeViewsSection(ItemManager $configuration): array
    {
        $newConfiguration = [];
        foreach ($configuration->getItemsAsArray() as $key => $item) {
            $itemConfiguration = [];

            // Title of the view
            $itemConfiguration['title'] = $item['title'];

            // Title of the view
            $itemConfiguration['viewTitleBar'] = $item['showTitleField'];

            // AddPrintIcon flag
            $itemConfiguration['addPrintIcon'] = $item['showAddPrintIcon'];

            // Relation view for print icon
            $itemConfiguration['viewForPrintIcon'] = $item['relview'];

            // Updates depending on the type
            switch ($item['type']) {
                case 'showAll':
                    // Type of the view
                    $itemConfiguration['type'] = 'list';

                    // Item Template
                    $itemConfiguration['itemTemplate'] = $item['showAllItemTemplate'];

                    // View Template
                    $itemConfiguration['viewTemplate'] = $item['showAllItemParentTemplate'];

                    break;
                case 'showSingle':
                    // Type of the view
                    $itemConfiguration['type'] = 'single';

                    // Folders of the view
                    if ($item['showFolders']) {
                        $folders = explode(';', $item['showFolders']);
                        foreach ($folders as $folderKey => $folder) {
                            $folderConfiguration = explode(':', $folder);
                            $label = trim($folderConfiguration[0]);
                            if ($label) {
                                $itemConfiguration['folders'][$folderKey + 1]['label'] = $label;
                                $itemConfiguration['folders'][$folderKey + 1]['configuration'] = $folderConfiguration[1];
                                $itemConfiguration['folders'][$folderKey + 1]['order'] = $folderKey + 1;
                            }
                        }
                    } else {
                        $itemConfiguration['folders'] = null;
                    }
                    break;
                case 'input':
                    // Type of the view
                    $itemConfiguration['type'] = 'edit';

                    // Folders of the view
                    if ($item['showFolders']) {
                        $folders = explode(';', $item['showFolders']);
                        foreach ($folders as $folderKey => $folder) {
                            $folderConfiguration = explode(':', $folder);
                            $label = trim($folderConfiguration[0]);
                            if ($label) {
                                $itemConfiguration['folders'][$folderKey + 1]['label'] = $label;
                                $itemConfiguration['folders'][$folderKey + 1]['configuration'] = $folderConfiguration[1];
                                $itemConfiguration['folders'][$folderKey + 1]['order'] = $folderKey + 1;
                            }
                        }
                    } else {
                        $itemConfiguration['folders'] = null;
                    }
                    break;
                case 'alt':
                    // Type of the view
                    $itemConfiguration['type'] = 'special';

                    // Subtype of the view
                    $itemConfiguration['subtype'] = $item['subtype'];

                    // Number of items before page break
                    $itemConfiguration['itemsBeforePageBreak'] = $item['pagebreak'];

                    // Number of items before page break in the first page
                    $itemConfiguration['itemsBeforeFirstPageBreak'] = $item['pagebreakfirstpage'];

                    // Item Template
                    $itemConfiguration['itemTemplate'] = $item['showAllItemTemplate'];

                    // View Template
                    $itemConfiguration['viewTemplate'] = $item['showAllItemParentTemplate'];
                    break;
                default:
                    // Type of the view
                    $itemConfiguration['type'] = 'none';
                    break;
            }

            // Removes the item
            $configuration->deleteItem($key);

            $newConfiguration[$key] = $itemConfiguration;
        }

        return $newConfiguration;
    }

    /**
     * Upgrades the queries section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeQueriesSection(ItemManager $configuration): array
    {
        $newConfiguration = [];
        foreach ($configuration->getItemsAsArray() as $key => $item) {

            $itemConfiguration = [];

            // Title of the query
            $itemConfiguration['title'] = $item['title'];

            // Main Table
            $itemConfiguration['mainTable'] = $item['tableLocal'];

            // Foreign Tables
            $itemConfiguration['foreignTables'] = $item['tableForeign'];

            // Aliases
            $itemConfiguration['aliases'] = $item['aliases'];

            // Where Clause
            $itemConfiguration['whereClause'] = $item['where'];

            // Order Clause
            $itemConfiguration['orderByClause'] = $item['order'];

            // Group Clause
            $itemConfiguration['groupByClause'] = $item['group'];

            // Where Tags
            if ($item['whereTags']) {
                eval('$whereTags = [' . $item['whereTags'] . '];');
                $index = 1;
                foreach ($whereTags as $whereTagKey => $whereTag) {
                    $itemConfiguration['whereTags'][$index ++] = [
                        'title' => $whereTagKey,
                        'whereClause' => $whereTag['where'],
                        'orderByClause' => $whereTag['order']
                    ];
                }
            } else {
                $itemConfiguration['whereTags'] = null;
            }

            // Removes the item
            $configuration->deleteItem($key);

            $newConfiguration[$key] = $itemConfiguration;
        }
        return $newConfiguration;
    }

    /**
     * Upgrades the forms section.
     *
     * @param \YolfTypo3\SavLibraryKickstarter\Utility\ItemManager $configuration
     *            The actual configuration
     *            
     * @return array The new configuration
     */
    public function upgradeFormsSection(ItemManager $configuration): array
    {
        $newConfiguration = [];
        foreach ($configuration->getItemsAsArray() as $key => $item) {
            $itemConfiguration = [];

            // Title of the query
            $itemConfiguration['title'] = $item['title'];

            // List View
            $itemConfiguration['listView'] = $item['showAllView'];

            // Single View
            $itemConfiguration['singleView'] = $item['showSingleView'];

            // Edit View
            $itemConfiguration['editView'] = $item['inputView'];

            // Special View
            $itemConfiguration['specialView'] = $item['altView'];

            // Query
            $itemConfiguration['query'] = $item['query'];

            // User Plugin flag
            $itemConfiguration['userPlugin'] = $item['userPlugin'];

            // Remove the item
            $configuration->deleteItem($key);

            $newConfiguration[$key] = $itemConfiguration;
        }
        return $newConfiguration;
    }

    /**
     * Upgrades the field based on its type.
     *
     * @param array $field
     *            The actual field
     *            
     * @return array The new field
     */
    protected function upgradeFieldFromType(array $field): array
    {
        switch ($field['type']) {
            case 'input':
                $field['type'] = 'String';
                break;
            case 'check':
                $field['type'] = 'Checkbox';
                break;
            case 'check_4':
            case 'check_10':
                $field['type'] = 'Checkboxes';
                for ($i = 0; $i < $field['conf_numberBoxes']; $i ++) {
                    $field['items'][$i] = [
                        'label' => $field['conf_boxLabel_' . $i]
                    ];
                }
                break;
            case 'date':
                $field['type'] = 'Date';
                break;
            case 'datetime':
                $field['type'] = 'DateTime';
                break;
            case 'files':
                $field['type'] = 'Files';
                break;
            case 'integer':
                $field['type'] = 'Integer';
                break;
            case 'graph':
                $field['type'] = 'Graph';
                break;
            case 'link':
                $field['type'] = 'Link';
                break;
            case 'radio':
                $field['type'] = 'RadioButtons';
                for ($i = 0; $i < $field['conf_select_items']; $i ++) {
                    $field['items'][$i] = [
                        'label' => $field['conf_select_item_' . $i],
                        'value' => $field['conf_select_itemvalue_' . $i]
                    ];
                }
                break;
            case 'rel':
                if ($field['conf_rel_type'] == 'group') {
                    $field['type'] = 'RelationManyToManyAsSubform';
                } elseif ($field['conf_relations'] > 1) {
                    $field['type'] = 'RelationManyToManyAsDoubleSelectorbox';
                } else {
                    $field['type'] = 'RelationOneToManyAsSelectorbox';
                }
                break;
            case 'select':
                $field['type'] = 'Selectorbox';
                for ($i = 0; $i < $field['conf_select_items']; $i ++) {
                    $field['items'][$i] = [
                        'label' => $field['conf_select_item_' . $i],
                        'value' => $field['conf_select_itemvalue_' . $i]
                    ];
                }
                break;
            case 'ShowOnly':
                $field['type'] = 'ShowOnly';
                break;
            case 'textarea':
                $field['type'] = 'Text';
                break;
            case 'textarea_rte':
                $field['type'] = 'RichTextEditor';
                break;
            default:
                $field['type'] = 'Unknown';
                break;
        }
        return $field;
    }
}
?>
