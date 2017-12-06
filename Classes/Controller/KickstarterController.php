<?php
namespace YolfTypo3\SavLibraryKickstarter\Controller;

/**
 * Copyright notice
 *
 * (c) 2010 Laurent Foulloy <yolf.typo3@orange.fr>
 * All rights reserved
 *
 * This class is a backport of the corresponding class of FLOW3.
 * All credits go to the v5 team.
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Configuration\ConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Compatibility\CompatibilityUtility;

/**
 * Backend Module of the SAV Library Kickstarter extension
 *
 * @package SavLibraryKickstarter
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 */
class KickstarterController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     *
     * @var boolean
     */
    protected $extensionsNeedTobeUpgraded = FALSE;

    /**
     * Initializes the controller before invoking an action method.
     *
     * Override this method to solve tasks which all actions have in
     * common.
     *
     * @return void @api
     */
    protected function initializeAction()
    {
        // Defines class aliases
        CompatibilityUtility::setClassAliases();
    }

    /**
     * extensionList action for this controller.
     *
     * @param string $showExtensionVersionSelector
     * @return string The rendered view
     */
    public function extensionListAction($showExtensionVersionSelector = NULL)
    {
    	// Checks if the static template is included
    	$backendConfigurationManager = GeneralUtility::makeInstance(BackendConfigurationManager::class);
    	$configuration = $backendConfigurationManager->getConfiguration();
    	if(!isset($configuration['view'])) {
    		$message = LocalizationUtility::translate('error.staticTemplateNotIncluded', $this->request->getControllerExtensionKey());
    		$this->addFlashMessage($message);
    		return;
    	}

    	// Displays the extension list
        $this->view->assign('extensionList', $this->getConfigurationList());
        $this->view->assign('showExtensionVersionSelector', $showExtensionVersionSelector);
        $this->view->assign('extensionsNeedTobeUpgraded', $this->extensionsNeedTobeUpgraded);
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
    }

    /**
     * selectExtensionVersion action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function selectExtensionVersionAction($extKey)
    {
        $this->redirect('extensionList', NULL, NULL, array(
            'showExtensionVersionSelector' => $extKey
        ));
    }

    /**
     * changeExtensionVersion action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function changeExtensionVersionAction($extKey = NULL)
    {
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extensionKey'];
        $version = $arguments['extensionVersion'];

        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration($version);
        // Saves the working configuration
        $configurationManager->saveConfigurationVersion();
        $section = $configurationManager->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->getItem('section');
        if (! empty($section)) {
            $itemKey = $configurationManager->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->getItem('itemKey');
        } else {
            $section = 'emconf';
            $itemKey = 1;
        }

        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * createExtension action for this controller.
     *
     * @param
     *            none
     * @return string The rendered view
     */
    public function createExtensionAction()
    {
        $this->view->assign('extensionList', $this->getConfigurationList());
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('itemKey', 1);
    }

    /**
     * copyExtension action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function copyExtensionAction($extKey)
    {
        $this->view->assign('extensionList', $this->getConfigurationList());
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', 1);
    }

    /**
     * editExtension action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function editExtensionAction($extKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $section = $configurationManager->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->getItem('section');
        if (! empty($section)) {
            $itemKey = $configurationManager->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->getItem('itemKey');
        } else {
            $section = 'emconf';
            $itemKey = 1;
        }
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * installExtension action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function installExtensionAction($extKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getExtensionManager()->installExtension();
        $this->redirect('extensionList');
    }

    /**
     * installExtension action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function uninstallExtensionAction($extKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getExtensionManager()->uninstallExtension();
        $this->redirect('extensionList');
    }

    /**
     * downloadExtension action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function downloadExtensionAction($extKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getExtensionManager()->downloadExtension();
        $this->redirect('extensionList');
    }

    /**
     * generateExtension action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function generateExtensionAction($extKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getCodeGenerator()->buildExtension();
        $configurationManager->getExtensionManager()->checkDbUpdate();
        $configurationManager->saveConfiguration();
        $this->redirect('extensionList');
    }

    /**
     * upgradeExtension action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function upgradeExtensionAction($extKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        // Sets the compatibilty if not already done
        $compatibility = $configurationManager->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->getItem('compatibility');
        if (is_null($compatibility)) {
            $compatibility = ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE;
            $configurationManager->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->replace(array(
                'compatibility' => $compatibility
            ));
        }
        $configurationManager->checkForUpgrade();
        $configurationManager->getCodeGenerator()->buildExtension();
        $configurationManager->getExtensionManager()->checkDbUpdate();
        $configurationManager->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->replace(array(
            'extensionMustbeUpgraded' => FALSE
        ));
        $configurationManager->saveConfiguration();
        $this->redirect('extensionList');
    }

    /**
     * upgradeExtensions action for this controller.
     *
     * @param string $extKey
     * @return string The rendered view
     */
    public function upgradeExtensionsAction()
    {
        foreach (GeneralUtility::get_dirs(PATH_typo3conf . 'ext/') as $extensionKey) {
            $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extensionKey);
            $configurationManager->injectController($this);

            if ($configurationManager->isSavLibraryKickstarterExtension()) {
                // Checks if the extension must be upgraded
                $configurationManager->loadConfiguration();
                if ($configurationManager->getCurrentLibraryVersion() != $configurationManager->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->getItem('libraryVersion')) {
                    $configurationManager->checkForUpgrade();
                    $configurationManager->getCodeGenerator()->buildExtension();
                    $configurationManager->getExtensionManager()->checkDbUpdate();
                    $configurationManager->getSectionManager()
                        ->getItem('general')
                        ->getItem(1)
                        ->replace(array(
                        'extensionMustbeUpgraded' => FALSE
                    ));
                    $configurationManager->saveConfiguration();
                    $this->redirect('upgradeExtensions');
                }
            }
        }
        $this->redirect('extensionList');
    }

    /**
     * addItem action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @return string The rendered view
     */
    public function addItemAction($extKey, $section)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $itemKey = $configurationManager->getSectionManager()
            ->addItem($section)
            ->addItem(NULL)
            ->addItem(array(
            'title' => LocalizationUtility::translate('kickstarter.new', $this->request->getControllerExtensionKey())
        ))
            ->getItemIndex();
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * deleteItem action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to delete
     * @return string The rendered view
     */
    public function deleteItemAction($extKey, $section, $itemKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->deleteItem($itemKey);
        $configurationManager->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->deleteItem('section');
        $configurationManager->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->deleteItem('itemKey');
        $configurationManager->saveConfiguration();
        $this->redirect('editExtension', NULL, NULL, array(
            'extKey' => $extKey
        ));
    }

    /**
     * emconfEditSection action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @return string The rendered view
     */
    public function emconfEditSectionAction($extKey = NULL, $section = NULL, $itemKey = NULL)
    {
        // Loads the configuration
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);

        $configurationManager->loadConfiguration();
        // Assigns view variables
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configurationManager->getConfiguration());
    }

    /**
     * newTablesEditSection action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $fieldKey
     *            The key of the field to edit
     * @param integer $viewKey
     *            The key of the view
     * @param integer $folderKey
     *            The key of the folder
     * @param boolean $showFieldConfiguration
     *            Displays the field definition if TRUE
     * @return string The rendered view
     */
    public function newTablesEditSectionAction($extKey, $section, $itemKey, $fieldKey = NULL, $viewKey = NULL, $folderKey = NULL, $showFieldConfiguration = FALSE)
    {

        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        foreach ($sectionManager->getItem($section) as $tableKey => $table) {
            $fields = $table->getItem('fields');
            if (is_array($fields)) {
                foreach ($fields as $key => $field) {
                    $item = $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem('fields')
                        ->addItem($key)
                        ->addItem('order');
                    if ($sectionManager->getItem('views')->count() > 0) {
                        foreach ($sectionManager->getItem('views') as $viewKeyLocal => $view) {
                            if (! $item->itemExists(viewKeyLocal)) {
                                $item->addItem(array(
                                    viewKeyLocal => $key
                                ));
                            } elseif ($sectionManager->getItem($section)
                                ->getItem($tableKey)
                                ->getItem('fields')
                                ->getItem($key)
                                ->getItem('viewKey') == 0) {
                                $sectionManager->getItem($section)
                                    ->getItem($tableKey)
                                    ->getItem('fields')
                                    ->getItem($key)
                                    ->addItem(array(
                                    'viewKey' => 1
                                ));
                            }
                        }
                    } else {
                        if (! $item->itemExists(0)) {
                            $item->addItem(array(
                                0 => $key
                            ));
                        }
                        $sectionManager->getItem($section)
                            ->getItem($tableKey)
                            ->getItem('fields')
                            ->getItem($key)
                            ->addItem(array(
                            'viewKey' => 0
                        ));
                    }
                }
                if ($sectionManager->getItem('views')->count() == 0) {
                    $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem(array(
                        'viewKey' => 0
                    ));
                } elseif ($sectionManager->getItem($section)
                    ->getItem($tableKey)
                    ->getItem('viewKey') == 0) {
                    $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem(array(
                        'viewKey' => 1
                    ));
                }
            }
        }

        // Changes the view if any provided
        if ($viewKey !== NULL) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem(array(
                'viewKey' => $viewKey
            ));
        }

        // Changes the folder if any provided
        if (! empty($folderKey)) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('folderKeys')
                ->addItem(array(
                $viewKey => $folderKey
            ));
        }

        // Orders the section item according to the view
        if ($sectionManager->getItem($section)
            ->getItem($itemKey)
            ->addItem('fields')
            ->count() > 0) {
            $viewKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('viewKey');
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->reIndex(array(
                'order' => $viewKey
            ));
        }

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Sets the folder labels
        foreach ($sectionManager->getItem('views') as $viewKey => $view) {
            if ($view->itemExists('folders') && $view->getItem('folders') !== NULL) {
                $folderLabels[$viewKey][0] = '';
                foreach ($view->getItem('folders')->sortby('order') as $folderKey => $folder) {
                    $folderLabels[$viewKey][$folderKey] = $folder['label'];
                }
            }
        }
        $configuration = $configurationManager->getConfiguration();

        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('fieldKey', $fieldKey);
        $this->view->assign('extension', $configuration);
        $this->view->assign('showFieldConfiguration', $showFieldConfiguration);
        $this->view->assign('folderLabels', $folderLabels);
    }

    /**
     * existingTablesEditSection action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $fieldKey
     *            The key of the field to edit
     * @param integer $viewKey
     *            The key of the view
     * @param integer $folderKey
     *            The key of the folder
     * @param boolean $showFieldConfiguration
     *            Displays the field definition if TRUE
     * @return string The rendered view
     */
    public function existingTablesEditSectionAction($extKey, $section, $itemKey, $fieldKey = NULL, $viewKey = NULL, $folderKey = NULL, $showFieldConfiguration = FALSE)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        foreach ($sectionManager->getItem($section) as $tableKey => $table) {

            $fields = $table->getItem('fields');
            if (is_array($fields)) {
                foreach ($fields as $key => $field) {
                    $item = $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem('fields')
                        ->addItem($key)
                        ->addItem('order');
                    if ($sectionManager->getItem('views')->count() > 0) {
                        foreach ($sectionManager->getItem('views') as $viewKeyLocal => $view) {
                            if (! $item->itemExists($viewKeyLocal)) {
                                $item->addItem(array(
                                    $viewKeyLocal => $key
                                ));
                            } elseif ($sectionManager->getItem($section)
                                ->getItem($tableKey)
                                ->getItem('fields')
                                ->getItem($key)
                                ->getItem('viewKey') == 0) {
                                $sectionManager->getItem($section)
                                    ->getItem($tableKey)
                                    ->getItem('fields')
                                    ->getItem($key)
                                    ->addItem(array(
                                    'viewKey' => 1
                                ));
                            }
                        }
                    } else {
                        if (! $item->itemExists(0)) {
                            $item->addItem(array(
                                0 => $key
                            ));
                        }
                        $sectionManager->getItem($section)
                            ->getItem($tableKey)
                            ->getItem('fields')
                            ->getItem($key)
                            ->addItem(array(
                            'viewKey' => 0
                        ));
                    }
                }
                if ($sectionManager->getItem('views')->count() == 0) {
                    $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem(array(
                        'viewKey' => 0
                    ));
                } elseif ($sectionManager->getItem($section)
                    ->getItem($tableKey)
                    ->getItem('viewKey') == 0) {
                    $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem(array(
                        'viewKey' => 1
                    ));
                }
            }
        }

        $configurationManager->saveConfiguration();

        // Orders the section item according to the view
        if ($sectionManager->getItem($section)
            ->getItem($itemKey)
            ->addItem('fields')
            ->count() > 0) {
            $viewKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('viewKey');
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->reIndex(array(
                'order' => $viewKey
            ));
        }

        // Changes the view if any provided
        if ($viewKey !== NULL) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem(array(
                'viewKey' => $viewKey
            ));
        }

        // Changes the folder if any provided
        if (! empty($folderKey)) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('folderKeys')
                ->addItem(array(
                $viewKey => $folderKey
            ));
        }

        // Sets the folder labels
        foreach ($sectionManager->getItem('views') as $viewKey => $view) {
            if ($view->itemExists('folders') && $view->getItem('folders') !== NULL) {
                $folderLabels[$viewKey][0] = '';
                foreach ($view->getItem('folders')->sortby('order') as $folderKey => $folder) {
                    $folderLabels[$viewKey][$folderKey] = $folder['label'];
                }
            }
        }

        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('fieldKey', $fieldKey);
        $this->view->assign('extension', $configuration);
        $this->view->assign('showFieldConfiguration', $showFieldConfiguration);
        $this->view->assign('folderLabels', $folderLabels);
    }

    /**
     * existingTablesImportFields action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @return string The rendered view
     */
    public function existingTablesImportFieldsAction($extKey, $section, $itemKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        $tableName = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('tablename');

        $columns = $GLOBALS['TCA'][$tableName]['columns'];

        if (is_array($columns)) {
            foreach ($columns as $columnKey => $column) {
                $item = $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->addItem('fields')
                    ->addItem(NULL);
                $item->addItem('order');
                $item->addItem(array(
                    'fieldname' => $columnKey,
                    'title' => $GLOBALS['LANG']->sL($column['label']),
                    'type' => 'ShowOnly'
                ));
            }

            if ($sectionManager->getItem('views')->count() == 0) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->addItem(array(
                    'viewKey' => 0
                ));
            } elseif ($sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('viewKey') == 0) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->addItem(array(
                    'viewKey' => 1
                ));
            }
        }
        $configurationManager->saveConfiguration();
        // Sets the folder labels
        foreach ($sectionManager->getItem('views') as $viewKey => $view) {
            if ($view->itemExists('folders') && $view->getItem('folders') !== NULL) {
                $folderLabels[$viewKey][0] = '';
                foreach ($view->getItem('folders')->sortby('order') as $folderKey => $folder) {
                    $folderLabels[$viewKey][$folderKey] = $folder['label'];
                }
            }
        }

        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('fieldKey', $fieldKey);
        $this->view->assign('extension', $configuration);
        $this->view->assign('folderLabels', $folderLabels);
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * viewsEditSection action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @return string The rendered view
     */
    public function viewsEditSectionAction($extKey, $section, $itemKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        // Sorts the folders if any
        if ($configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->addItem('folders')
            ->count() > 0) {
            $configurationManager->getSectionManager()
                ->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->sortby('order');
        }
        $configuration = $configurationManager->getConfiguration();

        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', $itemKey);

        $viewType = $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->getItem('type');
        switch ($viewType) {
            case 'list':
                break;
            case 'single':
            case 'edit':
                $configuration[$section][$itemKey]['foldersAllowed'] = 1;
                break;
        }
        $this->view->assign('extension', $configuration);
    }

    /**
     * queriesEditSection action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @return string The rendered view
     */
    public function queriesEditSectionAction($extKey, $section, $itemKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configuration);
    }

    /**
     * formsEditSection action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @return string The rendered view
     */
    public function formsEditSectionAction($extKey, $section, $itemKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configuration);

        // Build the options
        $option = array();
        $options['list'][0] = ' ';
        $options['single'][0] = ' ';
        $options['edit'][0] = ' ';
        $options['special'][0] = ' ';
        $views = $configuration['views'];
        if (is_array($views)) {
            foreach ($views as $viewKey => $view) {
                $options[$view['type']][$viewKey] = $view['title'];
            }
        }
        $options['query'][0] = ' ';
        $queries = $configuration['queries'];
        if (is_array($queries)) {
            foreach ($queries as $queryKey => $query) {
                $options['query'][$queryKey] = $query['title'];
            }
        }
        $this->view->assign('options', $options);
    }

    /**
     * changeViewAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $viewKey
     *            The key of the view to edit
     * @return string The rendered view
     */
    public function changeViewAction($extKey, $section, $itemKey, $viewKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->replace(array(
            'viewKey' => $viewKey
        ));
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields')
            ->replaceAll((array(
            'viewKey' => $viewKey
        )));
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * changeFolderAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $viewKey
     *            The key of the view to edit
     * @param integer $folderKey
     *            The key of the folder to change
     * @return string The rendered view
     */
    public function changeFolderAction($extKey, $section, $itemKey, $viewKey, $folderKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->replace(array(
            'folderKeys' => array(
                $viewKey => $folderKey
            )
        ));
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * changeConfigurationViewAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $fieldKey
     *            The key of the field to edit
     * @param integer $viewKey
     *            The key of the view to edit
     * @return string The rendered view
     */
    public function changeConfigurationViewAction($extKey, $section, $itemKey, $fieldKey, $viewKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields')
            ->getItem($fieldKey)
            ->replace(array(
            'viewKey' => $viewKey
        ));
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey
        ));
    }

    /**
     * save action for this controller.
     *
     * @return string The rendered view
     */
    public function saveAction()
    {
        // Gets the submitted action key
        $arguments = $this->request->getArguments();
        $submitAction = key($arguments['submitAction']);

        // Builds the submitted action method and calls it if it exists
        $submitActionMethodName = $submitAction . 'SubmitAction';
        if (method_exists($this, $submitActionMethodName)) {
            $this->$submitActionMethodName();
        } else {
            throw new RuntimeException('The submit action method "' . $submitActionMethodName . '" is not known !');
        }
    }

    /**
     * Overwrite submitted action.
     *
     * @return void
     */
    protected function overwriteSubmitAction()
    {
        $this->saveSubmitAction(FALSE);
    }

    /**
     * Save submitted action.
     *
     * @param boolean $checkLibraryType
     * @return void
     */
    protected function saveSubmitAction($chekLibraryType = TRUE)
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];
        $fieldKey = $arguments['general']['fieldKey'];
        $showFieldConfiguration = $arguments['general']['showFieldConfiguration'];
        $libraryType = $arguments['general']['libraryType'];

        // Gets the configuration and the section managers
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Special processing for the title of existing tables
        if (is_array($arguments['existingTables'])) {
            $options = \YolfTypo3\SavLibraryKickstarter\ViewHelpers\BuildOptionsForExistingTablesSelectorboxViewHelper::render();
            $arguments['existingTables']['title'] = $options[$arguments['existingTables']['tablename']];
        }
        // Special processing for new version
        if (is_array($arguments['general']['version'])) {
            $version = explode('.', $sectionManager->getItem('emconf')
                ->getItem(1)
                ->getItem('version'));
            if ($arguments['general']['version']['x'] == 1) {
                $version[0] ++;
                $version[1] = 0;
                $version[2] = 0;
            }
            if ($arguments['general']['version']['y'] == 1) {
                $version[1] ++;
                $version[2] = 0;
            }
            if ($arguments['general']['version']['z'] == 1) {
                $version[2] ++;
            }
            $sectionManager->getItem('emconf')
                ->getItem(1)
                ->replace(array(
                'version' => implode('.', $version)
            ));
            unset($arguments['general']['version']);
        }

        // Gets the current library type
        $currentLibraryType = $sectionManager->getItem('general')
            ->addItem(1)
            ->getItem('libraryType');

        // Checks if the library type has been changed
        if ($section == 'emconf') {
            if ($checkLibraryType === TRUE) {
                if ($currentLibraryType != $libraryType) {
                    // Builds the new directory if needed
                    $configurationManager->buildConfigurationDirectory($extKey, $libraryType);

                    // Gets the library name
                    $libraryName = ConfigurationManager::getLibraryName($libraryType);

                    // Checks if a configuration already exists
                    if ($configurationManager->configurationFileExists($extKey, $libraryName)) {
                        // The type is unchanged, overload must be used
                        $message = LocalizationUtility::translate('kickstarter.overwriteRequired', $this->request->getControllerExtensionKey());
                        $this->addFlashMessage($message);
                        unset($arguments['general']['libraryType']);
                    } else {
                        // Changes the library type file
                        $libraryName = ConfigurationManager::getLibraryName($libraryType);
                        GeneralUtility::writeFile(ConfigurationManager::getLibraryTypeFileName($extKey), $libraryName);
                    }
                }
            } else {
                // Builds the new directory if needed
                $configurationManager->buildConfigurationDirectory($extKey, $libraryType);

                // Changes the library type file
                $libraryName = ConfigurationManager::getLibraryName($libraryType);
                GeneralUtility::writeFile(ConfigurationManager::getLibraryTypeFileName($extKey), $libraryName);
            }
        }

        $sectionManager->getItem('general')
            ->addItem(1)
            ->replace($arguments['general']);

        // Processes the subforms
        $subforms = $arguments['subforms'];
        if (is_array($subforms)) {
            foreach ($subforms as $relationTableKey => $subform) {
                $sectionManager->getItem(key($subform))
                    ->getItem($relationTableKey)
                    ->replace(current($subform));
            }
        }

        // Processes the section fields
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->replace($arguments[$section]);

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Redirects to the section action
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => ($fieldKey ? $fieldKey : NULL),
            'showFieldConfiguration' => $showFieldConfiguration
        ));
    }

    /**
     * load submitted action.
     *
     * @return void
     */
    protected function loadSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];
        $fieldKey = $arguments['general']['fieldKey'];
        $showFieldConfiguration = $arguments['general']['showFieldConfiguration'];

        // Gets the configuration manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);

        $libraryName = ConfigurationManager::getLibraryName($arguments['general']['libraryType']);

        // Checks if a configuration already exists
        if ($configurationManager->configurationFileExists($extKey, $libraryName)) {
            // Changes the library type file
            GeneralUtility::writeFile(ConfigurationManager::getLibraryTypeFileName($extKey), $libraryName);
        } else {
            // The type is unchanged : no configuration file
            $message = LocalizationUtility::translate('kickstarter.noConfigurationFile', $this->request->getControllerExtensionKey());
            $this->addFlashMessage($message);
        }

        // Redirects to the section action
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => ($fieldKey ? $fieldKey : NULL),
            'showFieldConfiguration' => $showFieldConfiguration
        ));
    }

    /**
     * createExtension submitted action.
     *
     * @return void
     */
    protected function createExtensionSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = strtolower($arguments['extKey']);
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Creates all sections
        $sectionManager->addItem('general')
            ->addItem(1)
            ->addItem(array(
            'extensionKey' => $extKey
        ));
        $sectionManager->addItem('general')
            ->addItem(1)
            ->addItem(array(
            'libraryVersion' => $configurationManager->getCurrentLibraryVersion()
        ));
        $sectionManager->addItem('general')
            ->addItem(1)
            ->addItem(array(
            'debug' => '0'
        ));
        $sectionManager->addItem('emconf')
            ->addItem(1)
            ->addItem(array(
            'version' => '0.0.0'
        ));
        $sectionManager->addItem('newTables');
        $sectionManager->addItem('views');
        $sectionManager->addItem('queries');
        $sectionManager->addItem('forms');

        // Creates the configuration directory
        $configurationManager->createConfigurationDir($extKey);

        // Replaces the section arguments and saves
        $sectionManager->getItem('general')
            ->getItem(1)
            ->replace($arguments['general']);
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->replace($arguments[$section]);
        $configurationManager->saveConfiguration();

        // Redirects to the section
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * genrateExtension submitted action.
     *
     * @return void
     */
    protected function generateExtensionSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];
        $fieldKey = ($arguments['general']['fieldKey'] ? $arguments['general']['fieldKey'] : NULL);
        $showFieldConfiguration = $arguments['general']['showFieldConfiguration'];

        // Gets the configuration and the section managers
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Saves the configuration
        $sectionManager->getItem('general')
            ->addItem(1)
            ->replace($arguments['general']);
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->replace($arguments[$section]);
        if ($configurationManager->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->getItem('libraryVersion') === NULL) {
            $configurationManager->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->replace(array(
                'libraryVersion' => $configurationManager->getCurrentLibraryVersion()
            ));
        }

        $configurationManager->saveConfiguration();

        // Buids the extension
        $configurationManager->getCodeGenerator()->buildExtension();
        $sectionManager->getItem('general')
            ->getItem(1)
            ->addItem(array(
            'isGeneratedExtension' => 1
        ));
        $configurationManager->getExtensionManager()->injectGeneralArguments($arguments['general']);
        $configurationManager->getExtensionManager()->checkDbUpdate();

        // Clears the cache
        ExtensionManagementUtility::removeCacheFiles();

        // Redirects to the section action
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => ($fieldKey ? $fieldKey : NULL),
            'showFieldConfiguration' => $showFieldConfiguration
        ));
    }

    /**
     * copyExtension submitted action.
     *
     * @return void
     */
    protected function copyExtensionSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Sets the new extension key
        $newExtKey = $arguments['newExtKey'];
        $configurationManager->setExtensionKey($newExtKey);

        // Replaces the table name by its new name in all fields
        foreach ($sectionManager->getItems() as $walkSectionKey => $walkSection) {
            $walkSection->walkItem('\\YolfTypo3\\SavLibraryKickstarter\\Controller\\KickstarterController::changeTableNames', array(
                'newExtensionKey' => $newExtKey,
                'oldExtensionKey' => $extKey
            ));
        }
        // Creates the configuration directory and generates the extension
        $configurationManager->createConfigurationDir($newExtKey);
        $configurationManager->saveConfiguration();
        $configurationManager->getCodeGenerator()->buildExtension();

        // Redirects to the new section action
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $newExtKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * showAllFieldsSubmit action for this controller.
     *
     * @return void
     */
    public function showAllFieldsSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->replace(array(
            'showAllFields' => 1
        ));
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * showFieldsNotInFoldersSubmit action for this controller.
     *
     * @return void
     */
    public function showFieldsNotInFoldersSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->replace(array(
            'showAllFields' => 0
        ));
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * Method called by walkItem to change the table name.
     *
     * @param mixed $item
     *            The item
     * @param integer $key
     *            The item key
     * @param
     *            mixed The arguments
     * @return string The rendered view
     */
    public static function changeTableNames($item, $key, $arguments)
    {
        // Replaces the old extension name by the new one if it is not preceeded by '_'
        $item = preg_replace('/(?<!_)' . $arguments['oldExtensionKey'] . '/m', $arguments['newExtensionKey'], $item);

        // Adds the domain to existing tables with "short table names".
        $item = preg_replace('/_' . str_replace('_', '', $arguments['oldExtensionKey']) . '_/m', '_' . str_replace('_', '', $arguments['newExtensionKey']) . '_', $item);

        return $item;
    }

    /**
     * SortFields submitted action.
     *
     * @return void
     */
    protected function sortFieldsSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Gets the view key from the selectorbox, sorts by this key and saves.
        $currentViewKey = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('viewKey');
        $selectedViewKey = $arguments[$section]['viewSelectorbox'];

        // Changes the order
        foreach ($configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields') as $fieldKey => $field) {
            $order = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->getItem('order')
                ->getItem($selectedViewKey);
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->getItem('order')
                ->replace(array(
                $currentViewKey => $order
            ));
        }

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Redirects to the section action
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * copyFields submitted action.
     *
     * @return void
     */
    protected function copyFieldsSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Gets the view key from the selectorbox, sorts by this key and saves.
        $currentViewKey = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('viewKey');
        $selectedViewKey = $arguments[$section]['viewSelectorbox'];

        // Copy the field configuration
        foreach ($configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields') as $fieldKey => $field) {
            $fieldConfiguration = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->getItem('configuration')
                ->getItem($selectedViewKey);
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->getItem('configuration')
                ->replace(array(
                $currentViewKey => $fieldConfiguration
            ));
        }

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Redirects to the section action
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * updateDb submitted action.
     *
     * @return void
     */
    protected function updateDbSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extKey = $arguments['extKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Updates the database
        $configurationManager->getExtensionManager()->injectGeneralArguments($arguments['general']);
        $configurationManager->getExtensionManager()->checkDbUpdate();

        // Redirects to the section action
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * editFieldConfiguration action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $viewKey
     *            The key of the view
     * @param integer $folderKey
     *            The key of the folder
     * @param integer $fieldKey
     *            The key of the field to edit
     * @return string The rendered view
     */
    public function editFieldConfigurationAction($extKey, $section, $itemKey, $viewKey, $folderKey = 0, $fieldKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->addItem('activeFields')
            ->replace(array(
            $viewKey => array(
                $folderKey => $fieldKey
            )
        ));
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey,
            'viewKey' => $viewKey,
            'folderKey' => $folderKey,
            'showFieldConfiguration' => TRUE
        ));
    }

    /**
     * moveUpField action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $fieldKey
     *            The key of the field to edit
     * @return string The rendered view
     */
    public function moveUpFieldAction($extKey, $section, $itemKey, $fieldKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Gets the item
        $item = $sectionManager->getItem($section)->getItem($itemKey);
        $viewKey = $item->getItemAndSetToZeroIfNull('viewKey');

        // Gets the folder key if it exits
        $folderKeys = $item->getItem('folderKeys');
        if (is_null($folderKeys) === FALSE) {
            $folderKey = $folderKeys->getItem($viewKey);
        } else {
            $folderKey = NULL;
        }

        // Gets the fields in the view
        $fields = $item->getItem('fields');
        $fieldsInView = array();
        $keyList = array();
        foreach ($fields as $key => $field) {
            if (is_null($folderKey) || $field->getItem('folders')->getItem($viewKey) == $folderKey) {
                $fieldsInView[$key] = $field;
                $fieldKeysInView[] = $key;
            }
        }

        // Gets the from position and the from item
        $fromPositionInView = array_search($fieldKey, $fieldKeysInView);

        // Processes the items depending on the from position in the view
        if ($fromPositionInView > 0) {
            // Gets the from item and order
            $fromItem = $fieldsInView[$fieldKey];
            $fromOrder = $fromItem->getItem('order')->getItem($viewKey);
            // Gets the to poisition, item and order
            $toPositionInView = $fromPositionInView - 1;
            $toItem = $fieldsInView[$fieldKeysInView[$toPositionInView]];
            $toOrder = $toItem->getItem('order')->getItem($viewKey);
            // Replaces the orders
            $fromItem->replace(array(
                'order' => array(
                    $viewKey => $toOrder
                )
            ));
            $toItem->replace(array(
                'order' => array(
                    $viewKey => $fromOrder
                )
            ));
        } else {
            // Gets the rotated toOrder array
            $count = count($fieldKeysInView);
            $rotatedToOrders = array();
            foreach ($fieldKeysInView as $positionInView => $fieldKeyInView) {
                $rotatedKey = $fieldKeysInView[($positionInView + $count - 1) % $count];
                $rotatedToOrders[$positionInView] = $item->getItem('fields')
                    ->getItem($rotatedKey)
                    ->addItem('order')
                    ->getItem($viewKey);
            }
            // Sets the new order key
            foreach ($fieldKeysInView as $positionInView => $fieldKeyInView) {
                $fromItem = $fieldsInView[$fieldKeyInView];
                $fromItem->replace(array(
                    'order' => array(
                        $viewKey => $rotatedToOrders[$positionInView]
                    )
                ));
            }
        }

        // Saves and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey
        ));
    }

    /**
     * moveDownField action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $fieldKey
     *            The key of the field to edit
     * @return string The rendered view
     */
    public function moveDownFieldAction($extKey, $section, $itemKey, $fieldKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Gets the item
        $item = $sectionManager->getItem($section)->getItem($itemKey);
        $viewKey = $item->getItemAndSetToZeroIfNull('viewKey');

        // Gets the folder key if it exits
        $folderKeys = $item->getItem('folderKeys');
        if (is_null($folderKeys) === FALSE) {
            $folderKey = $folderKeys->getItem($viewKey);
        } else {
            $folderKey = NULL;
        }

        // Gets the fields in the view
        $fields = $item->getItem('fields');
        $fieldsInView = array();
        $keyList = array();
        foreach ($fields as $key => $field) {
            if (is_null($folderKey) || $field->getItem('folders')->getItem($viewKey) == $folderKey) {
                $fieldsInView[$key] = $field;
                $fieldKeysInView[] = $key;
            }
        }

        // Gets the from position and the from item
        $fromPositionInView = array_search($fieldKey, $fieldKeysInView);

        // Processes the items depending on the from position in the view
        $count = count($fieldKeysInView);
        if ($fromPositionInView < $count - 1) {
            // Gets the from item and order
            $fromItem = $fieldsInView[$fieldKey];
            $fromOrder = $fromItem->getItem('order')->getItem($viewKey);
            // Gets the to poisition, item and order
            $toPositionInView = $fromPositionInView + 1;
            $toItem = $fieldsInView[$fieldKeysInView[$toPositionInView]];
            $toOrder = $toItem->getItem('order')->getItem($viewKey);
            // Replaces the orders
            $fromItem->replace(array(
                'order' => array(
                    $viewKey => $toOrder
                )
            ));
            $toItem->replace(array(
                'order' => array(
                    $viewKey => $fromOrder
                )
            ));
        } else {
            // Gets the rotated toOrder array
            $count = count($fieldKeysInView);
            $rotatedToOrders = array();
            foreach ($fieldKeysInView as $positionInView => $fieldKeyInView) {
                $rotatedKey = $fieldKeysInView[($positionInView + 1) % $count];
                $rotatedToOrders[$positionInView] = $item->getItem('fields')
                    ->getItem($rotatedKey)
                    ->addItem('order')
                    ->getItem($viewKey);
            }
            // Sets the new order key
            foreach ($fieldKeysInView as $positionInView => $fieldKeyInView) {
                $fromItem = $fieldsInView[$fieldKeyInView];
                $fromItem->replace(array(
                    'order' => array(
                        $viewKey => $rotatedToOrders[$positionInView]
                    )
                ));
            }
        }

        // Saves and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey
        ));
    }

    /**
     * addNewField action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $fieldKey
     *            The key of the field to edit
     * @return string The rendered view
     */
    public function addNewFieldAction($extKey, $section, $itemKey, $fieldKey = NULL)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // A new field can be added if at least one view is defined
        $views = $sectionManager->getItem('views');
        if ($views->count() == 0) {
        	$message = LocalizationUtility::translate('kickstarter.noViewBeforeAddingField', $this->request->getControllerExtensionKey());
            $this->addFlashMessage($message);
            $this->redirect($section . 'EditSection', NULL, NULL, array(
                'extKey' => $extKey,
                'section' => $section,
                'itemKey' => $itemKey,
                'fieldKey' => $fieldKey
            ));
        }

        // Adds the item at the end if no field key is provided
        if ($fieldKey === NULL) {
            // Adds the field and gets its key
            $fieldKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('fields')
                ->addItem($fieldKey)
                ->getItemIndex();
            // Sets the default values
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->addItem(array(
                'fieldname' => LocalizationUtility::translate('kickstarter.new', $this->request->getControllerExtensionKey()),
                'title' => LocalizationUtility::translate('kickstarter.new', $this->request->getControllerExtensionKey()),
                'type' => 'Unknown'
            ));

            // Sets the first view as the default view by default if not already set
            $tableViewKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('viewKey');
            if (empty($tableViewKey)) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->addItem(array(
                    'viewKey' => 1
                ));
            }

            // Sets the view key
            $viewKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItemAndSetToZeroIfNull('viewKey');
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->addItem(array(
                'viewKey' => $viewKey
            ));
            // Adds the order in each view if any
            $views = $sectionManager->getItem('views');
            $count = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->count();
            foreach ($views as $viewKey => $view) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->getItem('fields')
                    ->getItem($fieldKey)
                    ->addItem('order')
                    ->addItem(array(
                    $viewKey => $count
                ));
            }
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey,
            'showFieldConfiguration' => TRUE
        ));
    }

    /**
     * deleteFieldAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to delete
     * @param integer $fieldKey
     *            The key of the field to delete
     * @return string The rendered view
     */
    public function deleteFieldAction($extKey, $section, $itemKey, $fieldKey = NULL)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Deletes the field
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields')
            ->deleteItem($fieldKey);
        // Reorders the fields if any
        if ($sectionManager->getItem($section)
            ->getItem($itemKey)
            ->addItem('fields')
            ->count() > 0) {
            $views = $sectionManager->getItem('views');
            // Reorders each view if any
            if ($views->count() > 0) {
                foreach ($views as $viewKey => $view) {
                    $sectionManager->getItem($section)
                        ->getItem($itemKey)
                        ->getItem('fields')
                        ->reIndex(array(
                        'order' => $viewKey
                    ));
                }
            } else {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->getItem('fields')
                    ->reIndex(array(
                    'order' => 0
                ));
            }

            // Gets the view key
            $viewKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('viewKey');
            // Gets the folder keys if any
            $folderKeys = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folderKeys');
            if ($folderKeys !== NULL) {
                $folderKey = $folderKeys->getItem($viewKey);
            } else {
                $folderKey = 0;
            }
            // Deletes the active field if it is the delete field
            $activeFields = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('activeFields');
            if ($activeFields !== NULL && $activeFields->getItem($viewKey) !== NULL && $activeFields->getItem($viewKey)->getItem($folderKey) == $fieldKey) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->getItem('activeFields')
                    ->getItem($viewKey)
                    ->deleteItem($folderKey);
            }
        }

        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey
        ));
    }

    /**
     * addNewViewWithConditionAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param string $viewType
     *            The type of the view
     * @param integer $viewWithConditionKey
     *            The key of the view to add
     * @return string The rendered view
     */
    public function addNewViewWithConditionAction($extKey, $section, $itemKey, $viewType, $viewWithConditionKey = NULL)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Adds the folder at the end if no key is provided
        if ($viewWithConditionKey === NULL) {
            $viewWithCondition = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('viewsWithCondition');
            $viewWithCondition->addItem($viewType)
                ->addItem($viewWithConditionKey)
                ->addItem(array(
                'key' => $viewWithCondition->count(),
                'condition' => ''
            ));
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * deleteViewWithConditionAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param string $viewType
     *            The type of the view
     * @param integer $viewWithConditionKey
     *            The key of the view to add
     * @return string The rendered view
     */
    public function deleteViewWithConditionAction($extKey, $section, $itemKey, $viewType, $viewWithConditionKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Deletes the field
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('viewsWithCondition')
            ->addItem($viewType)
            ->deleteItem($viewWithConditionKey);

        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * addNewFolderAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $folderKey
     *            The key of the folder to add
     * @return string The rendered view
     */
    public function addNewFolderAction($extKey, $section, $itemKey, $folderKey = NULL)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Adds the folder at the end if no key is provided
        if ($folderKey === NULL) {
            $folders = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('folders');
            $folders->addItem($folderKey)->addItem(array(
                'label' => '',
                'configuration' => '',
                'order' => $folders->count()
            ));
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * moveUpFolder action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $folderKey
     *            The key of the folder to move up
     * @return string The rendered view
     */
    public function moveUpFolderAction($extKey, $section, $itemKey, $folderKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        $fromItem = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('folders')
            ->getItem($folderKey);
        $fromPosition = $fromItem->getItem('order');
        if ($fromPosition > 1) {
            $toPosition = $fromPosition - 1;
            $toItem = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->find('order', $toPosition);
            $fromItem->replace(array(
                'order' => $toPosition
            ));
            $toItem->replace(array(
                'order' => $fromPosition
            ));
        } else {
            $count = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->count();
            foreach ($sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders') as $key => $field) {
                $position = $field->getItem('order');
                $field->replace(array(
                    'order' => ((int) ($position + $count - 2) % $count) + 1
                ));
            }
        }
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * moveDownFolder action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $folderKey
     *            The key of the folder to move down
     * @return string The rendered view
     */
    public function moveDownFolderAction($extKey, $section, $itemKey, $folderKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        $fromItem = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('folders')
            ->getItem($folderKey);
        $fromPosition = $fromItem->getItem('order');
        $count = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('folders')
            ->count();
        if ($fromPosition < $count) {
            $toPosition = $fromPosition + 1;
            $toItem = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->find('order', $toPosition);
            $fromItem->replace(array(
                'order' => $toPosition
            ));
            $toItem->replace(array(
                'order' => $fromPosition
            ));
        } else {
            $count = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->count();
            foreach ($sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders') as $key => $field) {
                $position = $field->getItem('order');
                $field->replace(array(
                    'order' => ((int) $position % $count) + 1
                ));
            }
        }
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * deleteFolderAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $folderKey
     *            The key of the folder to delete
     * @return string The rendered view
     */
    public function deleteFolderAction($extKey, $section, $itemKey, $folderKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Deletes the folder
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('folders')
            ->deleteItem($folderKey);

        // Deletes the folder input for the view in all field of the newTables
        foreach ($sectionManager->getItem('newTables') as $tableKey => $table) {
            foreach ($table->getItem('fields') as $fieldKey => $field) {
                if ($field->getItem('folders') !== NULL && $field->getItem('folders')->getItem($itemKey) == $folderKey) {
                    $field->getItem('folders')->deleteItem($itemKey);
                }
            }

            // Delete the foldeKeys input
            if ($table->getItem('folderKeys') !== NULL && $table->getItem('folderKeys')->getItem($itemKey) == $folderKey) {
                $table->getItem('folderKeys')->deleteItem($itemKey);
            }
        }

        // Deletes the folder input for the view in all field of the existingTables
        foreach ($sectionManager->getItem('existingTables') as $tableKey => $table) {
            foreach ($table->getItem('fields') as $fieldKey => $field) {
                if ($field->getItem('folders') !== NULL && $field->getItem('folders')->getItem($itemKey) == $folderKey) {
                    $field->getItem('folders')->deleteItem($itemKey);
                }
            }
        }

        // Reorders the folders if any
        $counter = 1;
        if ($sectionManager->getItem($section)
            ->getItem($itemKey)
            ->addItem('folders')
            ->count() > 0) {
            $sortedFoldersByOrder = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->sortBy('order');
            foreach ($sortedFoldersByOrder as $folderKey => $folder) {
                $folder->replace(array(
                    'order' => $counter ++
                ));
            }
        }

        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * addNewWhereTagAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $whereTagKey
     *            The key of the whereTag to create
     * @return string The rendered view
     */
    public function addNewWhereTagAction($extKey, $section, $itemKey, $whereTagKey = NULL)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Adds the folder at the end if no key is provided
        if ($whereTagKey === NULL) {
            $whereTags = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('whereTags');
            $whereTags->addItem($whereTagKey)->addItem(array(
                'title' => '',
                'where' => '',
                'order' => ''
            ));
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * deleteWhereTagAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $whereTagKey
     *            The key of the folder to delete
     * @return string The rendered view
     */
    public function deleteWhereTagAction($extKey, $section, $itemKey, $whereTagKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Deletes the whereTag
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('whereTags')
            ->deleteItem($whereTagKey);
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey
        ));
    }

    /**
     * addNewBoxItemAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $fieldKey
     *            The key of the field to edit
     * @param integer $boxItemKey
     *            The key of the folder to edit
     * @return string The rendered view
     */
    public function addNewBoxItemAction($extKey, $section, $itemKey, $fieldKey, $boxItemKey = NULL)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Adds the boxItem at the end if no key is provided
        if ($boxItemKey === NULL) {
            $boxItem = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->addItem('items');
            $boxItem->addItem($boxItemKey)->addItem(array(
                'label' => '',
                'value' => ''
            ));
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey,
            'showFieldConfiguration' => TRUE
        ));
    }

    /**
     * deleteBoxItemAction action for this controller.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @param integer $fieldKey
     *            The key of the field to edit
     * @param integer $boxItemKey
     *            The key of the folder to delete
     * @return string The rendered view
     */
    public function deleteBoxItemAction($extKey, $section, $itemKey, $fieldKey, $boxItemKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Deletes the field
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields')
            ->getItem($fieldKey)
            ->getItem('items')
            ->deleteItem($boxItemKey);
        // Reindexess the box Items if any
        if ($sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields')
            ->getItem($fieldKey)
            ->addItem('items')
            ->count() > 0) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->getItem('items')
                ->reIndexKeys();
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', NULL, NULL, array(
            'extKey' => $extKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey,
            'showFieldConfiguration' => TRUE
        ));
    }

    /**
     * assignForEditItemAction Assignement for EditItem actions.
     *
     * @param string $extKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param integer $itemKey
     *            The key of the item to edit
     * @return string The rendered view
     */
    protected function assignForEditItemAction($extKey, $section, $itemKey)
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extKey);
        $configurationManager->injectController($this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        $viewKey = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('viewKey');
        if (! empty($itemKey)) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->sortby(array(
                'order' => $viewKey
            ));
        }
        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extKey', $extKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configuration);
        return $configuration;
    }

    /**
     * Gets the configuration list.
     *
     * @return array the configuration list
     */
    public function getConfigurationList()
    {
        $extensionList = array();
        $this->extensionsNeedTobeUpgraded = FALSE;
        foreach (GeneralUtility::get_dirs(PATH_typo3conf . 'ext/') as $extensionKey) {

            $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class, $extensionKey);
            $configurationManager->injectController($this);

            if (! $configurationManager->isSavLibraryKickstarterExtension()) {
                $configurationManager->checkForUpgrade();
            }
            if ($configurationManager->isSavLibraryKickstarterExtension()) {
                $extensionVersion = $configurationManager->getExtensionVersion($extensionKey);
                $fileName = $configurationManager->getConfigurationFileName($extensionKey, $extensionVersion);

                if (file_exists($fileName)) {
                    $configurationManager->loadConfiguration($extensionVersion);
                    // Saves the working configuration
                    $configurationManager->saveConfigurationVersion();
                } else {
                    $configurationManager->loadConfiguration();
                }
                $configurationManager->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->addItem(array(
                    'isLoadedExtension' => $configurationManager->isLoadedExtension()
                ));
                $configurationManager->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->addItem(array(
                    'currentLibraryVersion' => $configurationManager->getCurrentLibraryVersion()
                ));

                // Changes the extension version if needed
                if ($configurationManager->getSectionManager()
                    ->getItem('emconf')
                    ->getItem(1)
                    ->getItem('version') != $extensionVersion) {
                    $configurationManager->getSectionManager()
                        ->getItem('emconf')
                        ->getItem(1)
                        ->replace(array(
                        'version' => $extensionVersion
                    ));
                    $configurationManager->saveConfiguration();
                }

                // Checks if the extension must be upgraded
                if ($configurationManager->getCurrentLibraryVersion() != $configurationManager->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->getItem('libraryVersion')) {
                    $configurationManager->getSectionManager()
                        ->getItem('general')
                        ->getItem(1)
                        ->replace(array(
                        'extensionMustbeUpgraded' => TRUE
                    ));
                    $this->extensionsNeedTobeUpgraded = TRUE;
                }

                // Checks the compatibillity
                $compatibility = $configurationManager->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->getItem('compatibility');
                if (is_null($compatibility)) {
                    $configurationManager->getSectionManager()
                        ->getItem('general')
                        ->getItem(1)
                        ->replace(array(
                        'extensionMustbeUpgraded' => TRUE
                    ));
                    $this->extensionsNeedTobeUpgraded = TRUE;
                }
                if (version_compare(TYPO3_version, '6.0', '>=')) {
                    $wrongCompatibility = ! in_array($compatibility, array(
                        ConfigurationManager::COMPATIBILITY_TYPO3_6x_AND_ABOVE,
                        ConfigurationManager::COMPATIBILITY_TYPO3_6x,
                        ConfigurationManager::COMPATIBILITY_TYPO3_6x_7x,
                    ));
                }
                $configurationManager->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->replace(array(
                    'wrongCompatibility' => $wrongCompatibility
                ));

                $extensionList[] = $configurationManager->getConfiguration();
            }
        }

        return $extensionList;
    }
}
?>
