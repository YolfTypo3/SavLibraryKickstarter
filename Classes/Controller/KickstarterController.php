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

namespace YolfTypo3\SavLibraryKickstarter\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\CommandUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Request;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Configuration\BackendConfigurationManager;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * Backend Module of the SAV Library Kickstarter extension
 *
 * @package SavLibraryKickstarter
 */
class KickstarterController extends ActionController
{

    /**
     * Backend Template Container
     *
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     *
     * @var boolean
     */
    protected $extensionsNeedTobeUpgraded = false;

    /**
     * Gets the request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * extensionList action for this controller.
     *
     * @param string|null $showExtensionVersionSelector
     * @return void|ResponseInterface
     */
    public function extensionListAction(?string $showExtensionVersionSelector = null)
    {
        // Checks if the static template is included
        $backendConfigurationManager = GeneralUtility::makeInstance(BackendConfigurationManager::class);
        $configuration = $backendConfigurationManager->getConfiguration();
        if (! isset($configuration['view'])) {
            $message = LocalizationUtility::translate('error.staticTemplateNotIncluded', $this->request->getControllerExtensionKey());
            $this->addFlashMessage($message, '', AbstractMessage::ERROR);
            return;
        }

        // Displays the extension list
        $this->view->assign('extensionList', $this->getConfigurationList());
        $this->view->assign('showExtensionVersionSelector', $showExtensionVersionSelector);
        $this->view->assign('extensionsNeedTobeUpgraded', $this->extensionsNeedTobeUpgraded);
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * generateLocalDocumentationWithDockerCompose action for this controller.
     *
     * @return void
     */
    public function generateLocalDocumentationWithDockerComposeAction(string $extensionKey)
    {
        $out = null;
        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        $yamlFile = $extensionDirectory . 'docker-compose.yml';
        CommandUtility::exec('docker-compose --file="' . $yamlFile . '" run --rm t3docmake', $out);

        $this->forward('extensionList');
    }

    /**
     * showLocalDocumentation action for this controller.
     *
     * @return void
     */
    public function showLocalDocumentationAction(string $extensionKey)
    {
        $out = null;
        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        $yamlFile = $extensionDirectory . 'docker-compose.yml';
        CommandUtility::exec('docker-compose --file="' . $yamlFile . '" run --rm t3docmake', $out);

        $this->forward('extensionList');
    }

    /**
     * selectExtensionVersion action for this controller.
     *
     * @param string $extensionKey
     * @return void
     */
    public function selectExtensionVersionAction(string $extensionKey)
    {
        $this->forward('extensionList', null, null, [
            'showExtensionVersionSelector' => $extensionKey
        ]);
    }

    /**
     * changeExtensionVersion action for this controller.
     *
     * @param string|null $extensionKey
     * @return void
     */
    public function changeExtensionVersionAction(?string $extensionKey = null)
    {
        $arguments = $this->request->getArguments();
        $extensionKey = $arguments['extensionKey'];
        $version = $arguments['extensionVersion'];

        $configurationManager = new ConfigurationManager($extensionKey, $this);
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

        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * createExtension action for this controller.
     *
     * @return void|ResponseInterface
     */
    public function createExtensionAction()
    {
        $this->view->assign('extensionList', $this->getConfigurationList());
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('itemKey', 1);

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * copyExtension action for this controller.
     *
     * @param string $extensionKey
     * @return void|ResponseInterface
     */
    public function copyExtensionAction(string $extensionKey)
    {
        $this->view->assign('extensionList', $this->getConfigurationList());
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', 1);

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * editExtension action for this controller.
     *
     * @param string $extensionKey
     * @return void
     */
    public function editExtensionAction(string $extensionKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * installExtension action for this controller.
     *
     * @param string $extensionKey
     * @return void
     */
    public function installExtensionAction(string $extensionKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getExtensionManager()->installExtension();
        $this->forward('extensionList');
    }

    /**
     * installExtension action for this controller.
     *
     * @param string $extensionKey
     * @return void
     */
    public function uninstallExtensionAction(string $extensionKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getExtensionManager()->uninstallExtension();
        $this->redirect('extensionList');
    }

    /**
     * downloadExtension action for this controller.
     *
     * @param string $extensionKey
     * @return void
     */
    public function downloadExtensionAction(string $extensionKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getExtensionManager()->downloadExtension();
        $this->redirect('extensionList');
    }

    /**
     * generateExtension action for this controller.
     *
     * @param string $extensionKey
     * @return void
     */
    public function generateExtensionAction(string $extensionKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getCodeGenerator()->buildExtension();
        $configurationManager->saveConfiguration();
        $this->redirect('extensionList');
    }

    /**
     * upgradeExtension action for this controller.
     *
     * @param string $extensionKey
     * @return void
     */
    public function upgradeExtensionAction($extensionKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->upgradeExtension();
        $configurationManager->getCodeGenerator()->buildExtension();
        $this->redirect('extensionList');
    }

    /**
     * upgradeExtensions action for this controller.
     *
     * @return void
     */
    public function upgradeExtensionsAction()
    {
        $counter = 0;
        foreach (GeneralUtility::get_dirs(Environment::getPublicPath() . '/typo3conf/ext/') as $extensionKey) {
            $configurationManager = new ConfigurationManager($extensionKey, $this);

            if ($configurationManager->isSavLibraryKickstarterExtension()) {
                // Checks if the extension must be upgradedd
                $configurationManager->loadConfiguration();
                if ($configurationManager->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->getItem('extensionMustbeUpgraded')) {

                    $configurationManager->upgradeExtension();
                    $configurationManager->getCodeGenerator()->buildExtension();

                    $counter = $counter + 1;
                }
            }

            // Upgrades extensions 10 by 10
            if ($counter == 10) {
                break;
            }
        }
        $this->redirect('extensionList');
    }

    /**
     * addItem action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @return void
     */
    public function addItemAction(string $extensionKey, string $section)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $itemKey = $configurationManager->getSectionManager()
            ->addItem($section)
            ->addEmptyItemAndGetKey();
        $configurationManager->getSectionManager()
            ->addItem($section)
            ->addItem($itemKey)
            ->addItem([
                'title' => LocalizationUtility::translate('kickstarter.new', $this->request->getControllerExtensionKey())
            ]);
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * deleteItem action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to delete
     * @return void
     */
    public function deleteItemAction(string $extensionKey, string $section, int $itemKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
        $this->redirect('editExtension', null, null, [
            'extensionKey' => $extensionKey
        ]);
    }

    /**
     * emconfEditSection action for this controller.
     *
     * @param string|null $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @return void|ResponseInterface
     */
    public function emconfEditSectionAction(?string $extensionKey = null, ?string $section = null, int $itemKey = null)
    {
        // Loads the configuration
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();

        // Assigns view variables
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configurationManager->getConfiguration());

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * documentationEditSection action for this controller.
     *
     * @param string|null $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @return void|ResponseInterface
     */
    public function documentationEditSectionAction(?string $extensionKey = null, string $section = null, int $itemKey = null)
    {
        // Loads the configuration
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();

        // Assigns view variables
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configurationManager->getConfiguration());

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * newTablesEditSection action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int|null $fieldKey
     *            The key of the field to edit
     * @param int|null $viewKey
     *            The key of the view
     * @param int|null $folderKey
     *            The key of the folder
     * @param bool $showFieldConfiguration
     *            Displays the field definition if true
     * @return void|ResponseInterface
     */
    public function newTablesEditSectionAction(string $extensionKey, string $section, int $itemKey, ?int $fieldKey = null, ?int $viewKey = null, ?int $folderKey = null, bool $showFieldConfiguration = false)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
                    $views = $sectionManager->getItem('views');
                    if ($views->count() > 0) {
                        $firstViewKey = array_key_first((array) $views);
                        foreach ($views as $viewKeyLocal => $view) {
                            if (! $item->itemExists(viewKeyLocal)) {
                                $item->addItem([
                                    viewKeyLocal => $key
                                ]);
                            } elseif ($sectionManager->getItem($section)
                                ->getItem($tableKey)
                                ->getItem('fields')
                                ->getItem($key)
                                ->getItem('viewKey') == 0) {
                                $sectionManager->getItem($section)
                                    ->getItem($tableKey)
                                    ->getItem('fields')
                                    ->getItem($key)
                                    ->addItem([
                                        'viewKey' => $firstViewKey
                                ]);
                            }
                        }
                    } else {
                        if (! $item->itemExists(0)) {
                            $item->addItem([
                                0 => $key
                            ]);
                        }
                        $sectionManager->getItem($section)
                            ->getItem($tableKey)
                            ->getItem('fields')
                            ->getItem($key)
                            ->addItem([
                            'viewKey' => 0
                        ]);
                    }
                }
                if ($views->count() == 0) {
                    $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem([
                            'viewKey' => 0
                    ]);
                } elseif ($sectionManager->getItem($section)
                    ->getItem($tableKey)
                    ->getItem('viewKey') == 0) {
                    $firstViewKey = array_key_first((array) $views);
                    $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem([
                            'viewKey' => $firstViewKey
                    ]);
                }
            }
        }

        // Changes the view if any provided
        if ($viewKey !== null) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem([
                'viewKey' => $viewKey
            ]);
        }

        // Changes the folder if any provided
        if (! empty($folderKey)) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('folderKeys')
                ->addItem([
                $viewKey => $folderKey
            ]);
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
                ->reIndex([
                'order' => $viewKey
            ]);
        }

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Sets the folder labels
        $folderLabels = [];
        foreach ($sectionManager->getItem('views') as $viewKey => $view) {
            if ($view->itemExists('folders') && $view->getItem('folders') !== null) {
                $folderLabels[$viewKey][0] = '';
                foreach ($view->getItem('folders')->sortby('order') as $folderKey => $folder) {
                    $folderLabels[$viewKey][$folderKey] = $folder['label'];
                }
            }
        }
        $configuration = $configurationManager->getConfiguration();

        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('fieldKey', $fieldKey);
        $this->view->assign('extension', $configuration);
        $this->view->assign('showFieldConfiguration', $showFieldConfiguration);
        $this->view->assign('folderLabels', $folderLabels);

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * existingTablesEditSection action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int|null $itemKey
     *            The key of the item to edit
     * @param int|null $fieldKey
     *            The key of the field to edit
     * @param int|null $viewKey
     *            The key of the view
     * @param int|null $folderKey
     *            The key of the folder
     * @param bool $showFieldConfiguration
     *            Displays the field definition if true
     * @return void|ResponseInterface
     */
    public function existingTablesEditSectionAction(string $extensionKey, string $section, ?int $itemKey, ?int $fieldKey = null, ?int $viewKey = null, ?int $folderKey = null, bool $showFieldConfiguration = false)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
                                $item->addItem([
                                    $viewKeyLocal => $key
                                ]);
                            } elseif ($sectionManager->getItem($section)
                                ->getItem($tableKey)
                                ->getItem('fields')
                                ->getItem($key)
                                ->getItem('viewKey') == 0) {
                                $sectionManager->getItem($section)
                                    ->getItem($tableKey)
                                    ->getItem('fields')
                                    ->getItem($key)
                                    ->addItem([
                                    'viewKey' => 1
                                ]);
                            }
                        }
                    } else {
                        if (! $item->itemExists(0)) {
                            $item->addItem([
                                0 => $key
                            ]);
                        }
                        $sectionManager->getItem($section)
                            ->getItem($tableKey)
                            ->getItem('fields')
                            ->getItem($key)
                            ->addItem([
                            'viewKey' => 0
                        ]);
                    }
                }
                if ($sectionManager->getItem('views')->count() == 0) {
                    $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem([
                        'viewKey' => 0
                    ]);
                } elseif ($sectionManager->getItem($section)
                    ->getItem($tableKey)
                    ->getItem('viewKey') == 0) {
                    $sectionManager->getItem($section)
                        ->getItem($tableKey)
                        ->addItem([
                        'viewKey' => 1
                    ]);
                }
            }
        }

        // Changes the view if any provided
        if ($viewKey !== null) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem([
                'viewKey' => $viewKey
            ]);
        }

        // Changes the folder if any provided
        if (! empty($folderKey)) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('folderKeys')
                ->addItem([
                $viewKey => $folderKey
            ]);
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
                ->reIndex([
                'order' => $viewKey
            ]);
        }

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Sets the folder labels
        $folderLabels = [];
        foreach ($sectionManager->getItem('views') as $viewKey => $view) {
            if ($view->itemExists('folders') && $view->getItem('folders') !== null) {
                $folderLabels[$viewKey][0] = '';
                foreach ($view->getItem('folders')->sortby('order') as $folderKey => $folder) {
                    $folderLabels[$viewKey][$folderKey] = $folder['label'];
                }
            }
        }

        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('fieldKey', $fieldKey);
        $this->view->assign('extension', $configuration);
        $this->view->assign('showFieldConfiguration', $showFieldConfiguration);
        $this->view->assign('folderLabels', $folderLabels);

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * existingTablesImportFields action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @return void
     */
    public function existingTablesImportFieldsAction(string $extensionKey, string $section, int $itemKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
                    ->addItem(null);
                $item->addItem('order');
                $item->addItem([
                    'fieldname' => $columnKey,
                    'title' => $GLOBALS['LANG']->sL($column['label']),
                    'type' => 'ShowOnly'
                ]);
            }

            if ($sectionManager->getItem('views')->count() == 0) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->addItem([
                    'viewKey' => 0
                ]);
            } elseif ($sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('viewKey') == 0) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->addItem([
                    'viewKey' => 1
                ]);
            }
        }
        $configurationManager->saveConfiguration();
        // Sets the folder labels
        foreach ($sectionManager->getItem('views') as $viewKey => $view) {
            if ($view->itemExists('folders') && $view->getItem('folders') !== null) {
                $folderLabels[$viewKey][0] = '';
                foreach ($view->getItem('folders')->sortby('order') as $folderKey => $folder) {
                    $folderLabels[$viewKey][$folderKey] = $folder['label'];
                }
            }
        }

        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('fieldKey', $fieldKey);
        $this->view->assign('extension', $configuration);
        $this->view->assign('folderLabels', $folderLabels);
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * viewsEditSection action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @return void|ResponseInterface
     */
    public function viewsEditSectionAction(string $extensionKey, string $section, int $itemKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        // Sorts the folders if any
        if ($configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->getItem('folders') !== null) {
            $configurationManager->getSectionManager()
                ->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->sortby('order');
        }
        $configuration = $configurationManager->getConfiguration();

        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extensionKey', $extensionKey);
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

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * queriesEditSection action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @return void|ResponseInterface
     */
    public function queriesEditSectionAction(string $extensionKey, string $section, int $itemKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configuration);

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * formsEditSection action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @return void|ResponseInterface
     */
    public function formsEditSectionAction(string $extensionKey, string $section, int $itemKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionNotLoaded', ! $configurationManager->isLoadedExtension());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configuration);

        // Build the options
        $options = [];
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

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * changeViewAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $viewKey
     *            The key of the view to edit
     * @return void
     */
    public function changeViewAction(string $extensionKey, string $section, int $itemKey, int $viewKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->replace([
            'viewKey' => $viewKey
        ]);
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->addItem('fields')
            ->replaceAll([
            'viewKey' => $viewKey
        ]);
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * changeFolderAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $viewKey
     *            The key of the view to edit
     * @param int $folderKey
     *            The key of the folder to change
     * @return void
     */
    public function changeFolderAction(string $extensionKey, string $section, int $itemKey, int $viewKey, int $folderKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->replace([
            'folderKeys' => [
                $viewKey => $folderKey
            ]
        ]);
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * changeConfigurationViewAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $fieldKey
     *            The key of the field to edit
     * @param int $viewKey
     *            The key of the view to edit
     * @return void
     */
    public function changeConfigurationViewAction(string $extensionKey, string $section, int $itemKey, int $fieldKey, int $viewKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields')
            ->getItem($fieldKey)
            ->replace([
            'viewKey' => $viewKey
        ]);
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey
        ]);
    }

    /**
     * save action for this controller.
     *
     * @return void
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
            throw new \RuntimeException('The submit action method "' . $submitActionMethodName . '" is not known !');
        }
    }

    /**
     * Overwrite submitted action.
     *
     * @return void
     */
    protected function overwriteSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        $sectionManager->getItem('general')
            ->getItem(1)
            ->addItem('upgrades')
            ->addItem([
                'YolfTypo3\\SavLibraryKickstarter\\Upgrade\\UpgradeToSavLibraryMvc' => false
            ]);

        // Upgrades et regenerates the extension
        $configurationManager->upgradeExtension();

        // Redirects to the section action
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * Save submitted action.
     *
     * @param bool $checkLibraryType
     * @return void
     */
    protected function saveSubmitAction(bool $checkLibraryType = true)
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];
        $fieldKey = $arguments['general']['fieldKey'];
        $showFieldConfiguration = $arguments['general']['showFieldConfiguration'];
        $libraryType = $arguments['general']['libraryType'];

        // Gets the configuration and the section managers
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
                ->replace([
                'version' => implode('.', $version)
            ]);
            unset($arguments['general']['version']);
        }


        if (! file_exists(ConfigurationManager::getLibraryTypeFileName($extensionKey))) {
            // Just a security since the library type file should have been created before
            $libraryType = $sectionManager->getItem('general')
                ->getItem(1)
                ->getItem('libraryType');

            // Builds the new directory if needed
            $configurationManager->buildConfigurationDirectory($extensionKey, $libraryType);

            // Changes the library type file
            $libraryName = ConfigurationManager::getLibraryName($libraryType);
            GeneralUtility::writeFile(ConfigurationManager::getLibraryTypeFileName($extensionKey), $libraryName);
        }

        $sectionManager->getItem('general')
            ->getItem(1)
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
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => ($fieldKey ? $fieldKey : null),
            'showFieldConfiguration' => $showFieldConfiguration
        ]);
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
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];
        $fieldKey = $arguments['general']['fieldKey'];
        $showFieldConfiguration = $arguments['general']['showFieldConfiguration'];

        // Gets the configuration manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);

        $libraryName = ConfigurationManager::getLibraryName($arguments['general']['libraryType']);

        // Checks if a configuration already exists
        if ($configurationManager->configurationFileExists($extensionKey, $libraryName)) {
            // Gets the current library name
            $currentLibraryName = trim(GeneralUtility::getURL(ConfigurationManager::getLibraryTypeFileName($extensionKey)));
            if ($currentLibraryName == $libraryName) {
                // The type is unchanged
                $message = LocalizationUtility::translate(
                    'kickstarter.unchangedLibraryType',
                    $this->request->getControllerExtensionKey(),
                    [$libraryName]
                    );
            } else {
                // Changes the library type file
                GeneralUtility::writeFile(ConfigurationManager::getLibraryTypeFileName($extensionKey), $libraryName);
                // The type is unchanged
                $message = LocalizationUtility::translate(
                    'kickstarter.changedLibraryType',
                    $this->request->getControllerExtensionKey(),
                    [$libraryName]
                    );
            }
        } else {
            // The type is unchanged : no configuration file
            $message = LocalizationUtility::translate(
                'kickstarter.noConfigurationFile',
                $this->request->getControllerExtensionKey(),
                [$libraryName]
            );
        }
        $this->addFlashMessage($message);

        // Redirects to the section action
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => ($fieldKey ? $fieldKey : null),
            'showFieldConfiguration' => $showFieldConfiguration
        ]);
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
        $extensionKey = strtolower($arguments['extensionKey']);
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $sectionManager = $configurationManager->getSectionManager(true);

        // Creates all sections
        $sectionManager->addItem('general')
            ->addItem(1)
            ->addItem([
            'extensionKey' => $extensionKey
        ]);

        $sectionManager->addItem('general')
            ->addItem(1)
            ->addItem([
            'libraryVersion' => $configurationManager->getCurrentLibraryVersion()
        ]);
        $sectionManager->addItem('general')
            ->addItem(1)
            ->addItem([
            'debug' => '0'
        ]);
        $sectionManager->addItem('emconf')
            ->addItem(1)
            ->addItem([
            'version' => '0.0.0'
        ]);
        $sectionManager->addItem('documentation')->addItem(1);
        $sectionManager->addItem('newTables');
        $sectionManager->addItem('views');
        $sectionManager->addItem('queries');
        $sectionManager->addItem('forms');

        // Creates the configuration directory
        $configurationManager->createConfigurationDir($extensionKey);

        // Replaces the section arguments and saves
        $sectionManager->getItem('general')
            ->getItem(1)
            ->replace($arguments['general']);
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->replace($arguments[$section]);
        $configurationManager->saveConfiguration();

        // Redirects to the section
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
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
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];
        $fieldKey = $arguments['general']['fieldKey'] ?? null;
        $showFieldConfiguration = $arguments['general']['showFieldConfiguration'] ?? false;

        // Gets the configuration and the section managers
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Saves the configuration
        unset($arguments['general']['version']);
        $sectionManager->getItem('general')
            ->addItem(1)
            ->replace($arguments['general']);
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->replace($arguments[$section]);
        if ($configurationManager->getSectionManager()
            ->getItem('general')
            ->getItem(1)
            ->getItem('libraryVersion') === null) {
            $configurationManager->getSectionManager()
                ->getItem('general')
                ->getItem(1)
                ->replace([
                'libraryVersion' => $configurationManager->getCurrentLibraryVersion()
            ]);
        }

        $configurationManager->saveConfiguration();

        // Buids the extension
        $configurationManager->getCodeGenerator()->buildExtension();
        $sectionManager->getItem('general')
            ->getItem(1)
            ->addItem([
            'isGeneratedExtension' => 1
        ]);

        // Clears the cache
        $cacheManager = GeneralUtility::makeInstance(CacheManager::class);
        $cacheManager->flushCachesInGroup('system');

        // Redirects to the section action
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => ($fieldKey ? $fieldKey : null),
            'showFieldConfiguration' => $showFieldConfiguration
        ]);
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
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Sets the new extension key
        $newExtensionKey = $arguments['newExtensionKey'];
        $configurationManager->setExtensionKey($newExtensionKey);

        // Replaces the table name by its new name in all fields
        foreach ($sectionManager->getItems() as $walkSection) {
            $walkSection->walkItem('\\YolfTypo3\\SavLibraryKickstarter\\Controller\\KickstarterController::changeTableNames', [
                'newExtensionKey' => $newExtensionKey,
                'oldExtensionKey' => $extensionKey
            ]);
        }

        // Creates the configuration directory and generates the extension
        $configurationManager->createConfigurationDir($newExtensionKey);
        $configurationManager->saveConfiguration();
        $configurationManager->getCodeGenerator()->buildExtension();

        // Redirects to the new section action
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $newExtensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
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
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->replace([
            'showAllFields' => 1
        ]);
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
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
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->replace([
            'showAllFields' => 0
        ]);
        $configurationManager->saveConfiguration();
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * Method called by walkItem to change the table name.
     *
     * @param mixed $item
     *            The item
     * @param mixed $key
     *            The item key
     * @param array $arguments
     *            The arguments
     * @return mixed
     */
    public static function changeTableNames($item, $key, array $arguments)
    {
        if (is_string($item)) {
            // Replaces the old extension name by the new one if it is not preceeded by '_'
            $item = preg_replace('/(?<!_)' . $arguments['oldExtensionKey'] . '/m', $arguments['newExtensionKey'], $item);

            // Adds the domain to existing tables with "short table names".
            $item = preg_replace('/_' . str_replace('_', '', $arguments['oldExtensionKey']) . '_/m', '_' . str_replace('_', '', $arguments['newExtensionKey']) . '_', $item);
        }
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
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
                ->replace([
                $currentViewKey => $order
            ]);
        }

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Redirects to the section action
        $this->redirect($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * copyFieldConfiguration submitted action.
     *
     * @return void
     */
    protected function copyFieldConfigurationSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];
        $fieldKey = $arguments['general']['fieldKey'];

        // Gets the configuration and the section managers
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Gets the view key from the selectorbox, sorts by this key and saves.
        $currentViewKey = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('viewKey');
        $selectedViewKey = $arguments[$section]['viewSelectorbox'];

        // Copies the field configuration
        if (! empty($fieldKey) && ! empty($selectedViewKey)) {
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
                ->replace([
                $currentViewKey => $fieldConfiguration
            ]);
        }

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Redirects to the section action
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * copyFieldsConfiguration submitted action.
     *
     * @return void
     */
    protected function copyFieldsConfigurationSubmitAction()
    {
        // Gets arguments
        $arguments = $this->request->getArguments();
        $extensionKey = $arguments['extensionKey'];
        $section = $arguments['general']['section'];
        $itemKey = $arguments['general']['itemKey'];

        // Gets the configuration and the section managers
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Gets the view key from the selectorbox, sorts by this key and saves.
        $currentViewKey = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('viewKey');
        $selectedViewKey = $arguments[$section]['viewSelectorbox'];

        // Copies the fields configuration
        if (! empty($selectedViewKey)) {
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
                    ->replace([
                    $currentViewKey => $fieldConfiguration
                ]);
            }
        }

        // Saves the configuration
        $configurationManager->saveConfiguration();

        // Redirects to the section action
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * editFieldConfiguration action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $viewKey
     *            The key of the view
     * @param int $folderKey
     *            The key of the folder
     * @param int $fieldKey
     *            The key of the field to edit
     * @return void
     */
    public function editFieldConfigurationAction(string $extensionKey, string $section, int $itemKey, int $viewKey, int $folderKey = 0, int $fieldKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $configurationManager->getSectionManager()
            ->getItem($section)
            ->getItem($itemKey)
            ->addItem('activeFields')
            ->replace([
            $viewKey => [
                $folderKey => $fieldKey
            ]
        ]);
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey,
            'viewKey' => $viewKey,
            'folderKey' => $folderKey,
            'showFieldConfiguration' => true
        ]);
    }

    /**
     * moveUpField action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $fieldKey
     *            The key of the field to edit
     * @param int $upDownValue
     *            The value to move up or downn
     * @return void
     */
    public function moveUpFieldAction(string $extensionKey, string $section, int $itemKey, int $fieldKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Gets the item
        $item = $sectionManager->getItem($section)->getItem($itemKey);
        $viewKey = $item->getItemAndSetToZeroIfNull('viewKey');

        // Gets the folder key if it exits
        $folderKeys = $item->getItem('folderKeys');
        if (is_null($folderKeys) === false) {
            $folderKey = $folderKeys->getItem($viewKey);
        } else {
            $folderKey = null;
        }

        // Gets the fields in the view
        $fields = $item->getItem('fields');
        $fieldsInView = [];
        $fieldKeysInView = [];
        foreach ($fields as $key => $field) {
            if (is_null($folderKey) || $field->getItem('folders')->getItem($viewKey) == $folderKey) {
                $fieldsInView[$key] = $field;
                $fieldKeysInView[] = $key;
            }
        }

        // Gets the from position and the from item
        $fromPositionInView = array_search($fieldKey, $fieldKeysInView);
        if (! empty($item['moveAfter']) && $item['moveAfter'] != - 1) {
            $upDownValue = $fromPositionInView - $item['moveAfter'] - 1;
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->deleteItem('moveAfter');
        } else {
            $upDownValue = 1;
        }

        // Gets the new order for the items to be moved
        $count = count($fieldKeysInView);
        $itemsToOrder = [];
        foreach ($fieldKeysInView as $positionInView => $fieldKeyInView) {
            $newKey = null;

            if ($fromPositionInView >= $upDownValue) {
                if (($positionInView >= $fromPositionInView - $upDownValue) && ($positionInView < $fromPositionInView)) {
                    $newKey = $fieldKeysInView[$positionInView + 1];
                } elseif ($positionInView == $fromPositionInView) {
                    $newKey = $fieldKeysInView[$fromPositionInView - $upDownValue];
                }
            } else {
                if (($positionInView > $fromPositionInView) && ($positionInView <= $count - $upDownValue + $fromPositionInView)) {
                    $newKey = $fieldKeysInView[$positionInView - 1];
                } elseif ($positionInView == $fromPositionInView) {
                    $newKey = $fieldKeysInView[$count - $upDownValue + $fromPositionInView];
                }
            }

            if ($newKey !== null) {
                $itemsToOrder[$positionInView] = $item->getItem('fields')
                    ->getItem($newKey)
                    ->getItem('order')
                    ->getItem($viewKey);
            }
        }

        // Sets the new order key
        foreach ($itemsToOrder as $positionInView => $fieldKeyInView) {
            $fromItem = $fieldsInView[$fieldKeysInView[$positionInView]];
            $fromItem->replace([
                'order' => [
                    $viewKey => $fieldKeyInView
                ]
            ]);
        }

        // Saves and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey
        ]);
    }

    /**
     * moveDownField action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $fieldKey
     *            The key of the field to edit
     * @return void
     */
    public function moveDownFieldAction(string $extensionKey, string $section, int $itemKey, int $fieldKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Gets the item
        $item = $sectionManager->getItem($section)->getItem($itemKey);
        $viewKey = $item->getItemAndSetToZeroIfNull('viewKey');

        // Gets the folder key if it exits
        $folderKeys = $item->getItem('folderKeys');
        if (is_null($folderKeys) === false) {
            $folderKey = $folderKeys->getItem($viewKey);
        } else {
            $folderKey = null;
        }

        // Gets the fields in the view
        $fields = $item->getItem('fields');
        $fieldsInView = [];
        $fieldKeysInView = [];
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
        if (! empty($item['moveAfter']) && $item['moveAfter'] != - 1) {
            $upDownValue = ($count + 1 + $item['moveAfter'] - $fromPositionInView) % ($count + 1);
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->deleteItem('moveAfter');
        } else {
            $upDownValue = 1;
        }

        // Gets the new order for the items to be moved
        $count = count($fieldKeysInView);

        $itemsToOrder = [];
        foreach ($fieldKeysInView as $positionInView => $fieldKeyInView) {
            $newKey = null;

            if ($fromPositionInView < $count - $upDownValue) {
                if (($positionInView <= $fromPositionInView + $upDownValue) && ($positionInView > $fromPositionInView)) {
                    $newKey = $fieldKeysInView[$positionInView - 1];
                } elseif ($positionInView == $fromPositionInView) {
                    $newKey = $fieldKeysInView[$fromPositionInView + $upDownValue];
                }
            } else {
                if (($positionInView < $fromPositionInView) && ($positionInView >= ($fromPositionInView + $upDownValue) % $count)) {
                    $newKey = $fieldKeysInView[$positionInView + 1];
                } elseif ($positionInView == $fromPositionInView) {
                    $newKey = $fieldKeysInView[($fromPositionInView + $upDownValue) % $count];
                }
            }

            if ($newKey !== null) {
                $itemsToOrder[$positionInView] = $item->getItem('fields')
                    ->getItem($newKey)
                    ->getItem('order')
                    ->getItem($viewKey);
            }
        }

        // Sets the new order key
        foreach ($itemsToOrder as $positionInView => $fieldKeyInView) {
            $fromItem = $fieldsInView[$fieldKeysInView[$positionInView]];
            $fromItem->replace([
                'order' => [
                    $viewKey => $fieldKeyInView
                ]
            ]);
        }

        // Saves and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey
        ]);
    }

    /**
     * addNewField action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $fieldKey
     *            The key of the field to edit
     * @return void
     */
    public function addNewFieldAction(string $extensionKey, string $section, int $itemKey, int $fieldKey = null)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // A new field can be added if at least one view is defined
        $views = $sectionManager->getItem('views');
        if ($views->count() == 0) {
            $firstViewKey = array_key_first((array) $views);
            $message = LocalizationUtility::translate('kickstarter.noViewBeforeAddingField', $this->request->getControllerExtensionKey());
            $this->addFlashMessage($message);
            $this->forward($section . 'EditSection', null, null, [
                'extensionKey' => $extensionKey,
                'section' => $section,
                'itemKey' => $itemKey,
                'fieldKey' => $fieldKey
            ]);
        } else {
            $firstViewKey = array_key_first((array)$views);
        }

        // Adds the item at the end if no field key is provided
        if ($fieldKey === null) {
            // Adds the field and gets its key
            $fieldKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('fields')
                ->addEmptyItemAndGetKey();
            // Sets the default values
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->addItem([
                'fieldname' => LocalizationUtility::translate('kickstarter.new', $this->request->getControllerExtensionKey()),
                'title' => LocalizationUtility::translate('kickstarter.new', $this->request->getControllerExtensionKey()),
                'type' => 'Unknown'
            ]);

            // Sets the first view as the default view by default if not already set
            $tableViewKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('viewKey');
            if (empty($tableViewKey)) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->addItem([
                        'viewKey' => $firstViewKey
                ]);
            }

            // Sets the view key
            $viewKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItemAndSetToZeroIfNull('viewKey');
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->addItem([
                'viewKey' => $viewKey
            ]);
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
                    ->addItem([
                    $viewKey => $count
                ]);
            }
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey,
            'showFieldConfiguration' => true
        ]);
    }

    /**
     * deleteFieldAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to delete
     * @param int|null $fieldKey
     *            The key of the field to delete
     * @return void
     */
    public function deleteFieldAction(string $extensionKey, string $section, int $itemKey, ?int $fieldKey = null)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
                        ->reIndex([
                        'order' => $viewKey
                    ]);
                }
            } else {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->getItem('fields')
                    ->reIndex([
                    'order' => 0
                ]);
            }

            // Gets the view key
            $viewKey = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('viewKey');
            // Gets the folder keys if any
            $folderKeys = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folderKeys');
            if ($folderKeys !== null) {
                $folderKey = $folderKeys->getItem($viewKey);
            } else {
                $folderKey = 0;
            }
            // Deletes the active field if it is the delete field
            $activeFields = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('activeFields');
            if ($activeFields !== null && $activeFields->getItem($viewKey) !== null && $activeFields->getItem($viewKey)->getItem($folderKey) == $fieldKey) {
                $sectionManager->getItem($section)
                    ->getItem($itemKey)
                    ->getItem('activeFields')
                    ->getItem($viewKey)
                    ->deleteItem($folderKey);
            }
        }

        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey
        ]);
    }

    /**
     * addNewViewWithConditionAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param string $viewType
     *            The type of the view
     * @param int|null $viewWithConditionKey
     *            The key of the view to add
     * @return void
     */
    public function addNewViewWithConditionAction(string $extensionKey, string $section, int $itemKey, string $viewType, ?int $viewWithConditionKey = null)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Adds the folder at the end if no key is provided
        if ($viewWithConditionKey === null) {
            $viewWithCondition = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('viewsWithCondition');
            $viewWithCondition->addItem($viewType)
                ->addItem($viewWithConditionKey)
                ->addItem([
                'key' => $viewWithCondition->count(),
                'condition' => ''
            ]);
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * deleteViewWithConditionAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param string $viewType
     *            The type of the view
     * @param int $viewWithConditionKey
     *            The key of the view to add
     * @return void
     */
    public function deleteViewWithConditionAction(string $extensionKey, string $section, int $itemKey, string $viewType, int $viewWithConditionKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * addNewFolderAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int|null $folderKey
     *            The key of the folder to add
     * @return void
     */
    public function addNewFolderAction(string $extensionKey, string $section, int $itemKey, ?int $folderKey = null)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Adds the folder at the end if no key is provided
        if ($folderKey === null) {
            $folders = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('folders');

            $folders->addItem($folderKey)->addItem([
                'label' => '',
                'configuration' => '',
                'order' => $folders->count()
            ]);
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * moveUpFolder action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $folderKey
     *            The key of the folder to move up
     * @return void
     */
    public function moveUpFolderAction(string $extensionKey, string $section, int $itemKey, int $folderKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
            $fromItem->replace([
                'order' => $toPosition
            ]);
            $toItem->replace([
                'order' => $fromPosition
            ]);
        } else {
            $count = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->count();
            foreach ($sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders') as $key => $field) {
                $position = $field->getItem('order');
                $field->replace([
                    'order' => ((int) ($position + $count - 2) % $count) + 1
                ]);
            }
        }
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * moveDownFolder action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $folderKey
     *            The key of the folder to move down
     * @return void
     */
    public function moveDownFolderAction(string $extensionKey, string $section, int $itemKey, int $folderKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
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
            $fromItem->replace([
                'order' => $toPosition
            ]);
            $toItem->replace([
                'order' => $fromPosition
            ]);
        } else {
            $count = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders')
                ->count();
            foreach ($sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('folders') as $key => $field) {
                $position = $field->getItem('order');
                $field->replace([
                    'order' => ((int) $position % $count) + 1
                ]);
            }
        }
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * deleteFolderAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $folderKey
     *            The key of the folder to delete
     * @return void
     */
    public function deleteFolderAction(string $extensionKey, string $section, int $itemKey, int $folderKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();

        // Deletes the folder
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('folders')
            ->deleteItem($folderKey);

        // Deletes the folder input for the view in all field of the newTables
        if (is_array($sectionManager->getItem('existingTables'))) {
            foreach ($sectionManager->getItem('newTables') as $tableKey => $table) {
                foreach ($table->getItem('fields') as $fieldKey => $field) {
                    if ($field->getItem('folders') !== null && $field->getItem('folders')->getItem($itemKey) == $folderKey) {
                        $field->getItem('folders')->deleteItem($itemKey);
                    }
                }

                // Delete the foldeKeys input
                if ($table->getItem('folderKeys') !== null && $table->getItem('folderKeys')->getItem($itemKey) == $folderKey) {
                    $table->getItem('folderKeys')->deleteItem($itemKey);
                }
            }
        }

        // Deletes the folder input for the view in all field of the existingTables
        if (is_array($sectionManager->getItem('existingTables'))) {
            foreach ($sectionManager->getItem('existingTables') as $tableKey => $table) {
                foreach ($table->getItem('fields') as $fieldKey => $field) {
                    if ($field->getItem('folders') !== null && $field->getItem('folders')->getItem($itemKey) == $folderKey) {
                        $field->getItem('folders')->deleteItem($itemKey);
                    }
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
                $folder->replace([
                    'order' => $counter ++
                ]);
            }
        }

        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * addNewWhereTagAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int|null $whereTagKey
     *            The key of the whereTag to create
     * @return void
     */
    public function addNewWhereTagAction(string $extensionKey, string $section, int $itemKey, ?int $whereTagKey = null)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Adds the folder at the end if no key is provided
        if ($whereTagKey === null) {
            $whereTags = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->addItem('whereTags');
            $whereTags->addItem($whereTagKey)->addItem([
                'title' => '',
                'where' => '',
                'order' => ''
            ]);
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * deleteWhereTagAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $whereTagKey
     *            The key of the folder to delete
     * @return void
     */
    public function deleteWhereTagAction(string $extensionKey, string $section, int $itemKey, int $whereTagKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Deletes the whereTag
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('whereTags')
            ->deleteItem($whereTagKey);
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey
        ]);
    }

    /**
     * addNewBoxItemAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $fieldKey
     *            The key of the field to edit
     * @param int|null $boxItemKey
     *            The key of the folder to edit
     * @return void
     */
    public function addNewBoxItemAction(string $extensionKey, string $section, int $itemKey, int $fieldKey, ?int $boxItemKey = null)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Adds the boxItem at the end if no key is provided
        if ($boxItemKey === null) {
            $boxItems = $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->getItem($fieldKey)
                ->addItem('items');
            $boxItemKey = $boxItems
                ->addEmptyItemAndGetKey();

            $boxItems->getItem($boxItemKey)->addItem([
                'label' => '',
                'value' => ''
            ]);
        }
        // Saves the configuration and redirects to the section
        $configurationManager->saveConfiguration();
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey,
            'showFieldConfiguration' => true
        ]);
    }

    /**
     * deleteBoxItemAction action for this controller.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @param int $fieldKey
     *            The key of the field to edit
     * @param int $boxItemKey
     *            The key of the folder to delete
     * @return void
     */
    public function deleteBoxItemAction(string $extensionKey, string $section, int $itemKey, int $fieldKey, int $boxItemKey)
    {
        // Loads the configuration and gets the section manager
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        // Deletes the field
        $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('fields')
            ->getItem($fieldKey)
            ->getItem('items')
            ->deleteItem($boxItemKey);
        // Reindexes the box Items if any
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
        $this->forward($section . 'EditSection', null, null, [
            'extensionKey' => $extensionKey,
            'section' => $section,
            'itemKey' => $itemKey,
            'fieldKey' => $fieldKey,
            'showFieldConfiguration' => true
        ]);
    }

    /**
     * assignForEditItemAction Assignement for EditItem actions.
     *
     * @param string $extensionKey
     *            The extension key
     * @param string $section
     *            The section name
     * @param int $itemKey
     *            The key of the item to edit
     * @return void|ResponseInterface
     */
    protected function assignForEditItemAction(string $extensionKey, string $section, int $itemKey)
    {
        $configurationManager = new ConfigurationManager($extensionKey, $this);
        $configurationManager->loadConfiguration();
        $sectionManager = $configurationManager->getSectionManager();
        $viewKey = $sectionManager->getItem($section)
            ->getItem($itemKey)
            ->getItem('viewKey');
        if (! empty($itemKey)) {
            $sectionManager->getItem($section)
                ->getItem($itemKey)
                ->getItem('fields')
                ->sortby([
                'order' => $viewKey
            ]);
        }
        $configuration = $configurationManager->getConfiguration();
        $this->view->assign('savLibraryKickstarterVersion', ConfigurationManager::getSavLibraryKickstarterVersion());
        $this->view->assign('extensionKey', $extensionKey);
        $this->view->assign('itemKey', $itemKey);
        $this->view->assign('extension', $configuration);

        // For TYPO3 V11: action must return an instance of Psr\Http\Message\ResponseInterface
        if (method_exists($this, 'htmlResponse')) {
            return $this->htmlResponse($this->view->render());
        }
    }

    /**
     * Gets the configuration list.
     *
     * @return array the configuration list
     */
    public function getConfigurationList()
    {
        $extensionList = [];
        $this->extensionsNeedTobeUpgraded = false;

        $extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $generateLocalDocumentationWithDockerCompose = $extensionConfiguration->get($this->request->getControllerExtensionKey(), 'generateLocalDocumentationWithDockerCompose');

        foreach (GeneralUtility::get_dirs(Environment::getPublicPath() . '/typo3conf/ext/') as $extensionKey) {

            $configurationManager = new ConfigurationManager($extensionKey, $this);

            if ($configurationManager->isSavLibraryKickstarterExtension()) {
                $configurationManager->checkForUpgrade();
                $extensionVersion = $configurationManager->getExtensionVersion($extensionKey);
                $fileName = ConfigurationManager::getConfigurationFileName($extensionKey, $extensionVersion);

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
                    ->addItem([
                    'isLoadedExtension' => $configurationManager->isLoadedExtension(),
                    'currentLibraryVersion' => $configurationManager->getCurrentLibraryVersion()
                ]);

                // Processes the global flag for upgrades
                $this->extensionsNeedTobeUpgraded |= $configurationManager->getSectionManager()
                    ->getItem('general')
                    ->getItem(1)
                    ->getItem('extensionMustbeUpgraded');

                // Checks if the local documentation exists
                if ($generateLocalDocumentationWithDockerCompose) {
                    $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
                    $fileName = $extensionDirectory . 'docker-compose.yml';
                    if (file_exists($fileName)) {
                        $configurationManager->getSectionManager()
                            ->getItem('general')
                            ->getItem(1)
                            ->addItem([
                            'generateLocalDocumentationWithDockerCompose' => 1
                        ]);

                        $localDocumentationFile = '/' . ConfigurationManager::LOCAL_DOCUMENTATION_DIRECTORY . $extensionKey . '/' . ConfigurationManager::LOCAL_DOCUMENTATION_INDEX_FILE;
                        if (! file_exists(Environment::getPublicPath() . $localDocumentationFile)) {
                            $localDocumentationFile = '';
                        }
                        $errorDocumentationFile = '/' . ConfigurationManager::LOCAL_DOCUMENTATION_DIRECTORY . $extensionKey . '/' . ConfigurationManager::LOCAL_DOCUMENTATION_ERROR_FILE;
                        if (file_exists(Environment::getPublicPath() . $errorDocumentationFile)) {
                            $fileContent = file_get_contents(Environment::getPublicPath() . $errorDocumentationFile);
                            if (empty($fileContent)) {
                                $errorDocumentationFile = '';
                            }
                        } else {
                            $errorDocumentationFile = '';
                        }

                        $configurationManager->getSectionManager()
                            ->getItem('general')
                            ->getItem(1)
                            ->addItem([
                            'localDocumentationFile' => $localDocumentationFile,
                            'errorDocumentationFile' => $errorDocumentationFile
                        ]);
                    }
                }

                $extensionList[] = $configurationManager->getConfiguration();
            }
        }

        return $extensionList;
    }
}
