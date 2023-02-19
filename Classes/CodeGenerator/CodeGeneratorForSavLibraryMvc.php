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

/**
 * This class generates the code for a front end plugin.
 *
 * It is based on the same idea developed by Ingmar Schlecht for the extbase_kickstater.
 * Code templates are used to build the file contents. They are processed by a fluid parser.
 */
class CodeGeneratorForSavLibraryMvc extends PreprocessingForCodeGenerator
{
    /**
     * The code templates directory
     *
     * @var string
     */
    protected static $codeTemplatesDirectory = 'Resources/Private/CodeTemplates/ForSavLibraryMvc/';

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

        // Preprocessing for MVC
        $this->buildArrayForCodeGenerator(1);

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

        // Generates the Configuration files
        $this->buildConfigurationFlexform();
        $this->buildConfigurationTca();
        $this->buildConfigurationTypoScript();
        $this->buildConfigurationServices();
        $this->buildConfigurationExtbasePersistence();
        $this->buildConfigurationRoutes();

        // Generates Documentation files
        $this->buildDocumentation();

        // Generates the language files
        $this->buildLanguageFiles();

        // Generates the Domain models
        $this->buildDomainModels();

        // Generates the Domain repositories
        $this->buildDomainRepositories();

        // Generates the Controller (must be the last generated part for subforms)
        $this->buildController();

        // Generates the migration file if requested
        $this->buildMigration();
    }

    /**
     * Specific methods for this generator
     */

    /**
     * Builds the Configuration/TypoScript file(s).
     *
     * @return void
     */
    protected function buildConfigurationTypoScript()
    {
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Configuration/TypoScript/');

        // Generates constants.typoscript file if it does not exist
        if (! file_exists($this->extensionDirectory . 'Configuration/TypoScript/constants.typoscript')) {
            $fileContents = $this->generateFile('Configuration/TypoScript/constants.typoscriptt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/TypoScript/constants.typoscript', $fileContents);
        }

        // Generates setup.typoscript file if it does not exist
        if (! file_exists($this->extensionDirectory . 'Configuration/TypoScript/setup.typoscript')) {
            $fileContents = $this->generateFile('Configuration/TypoScript/setup.typoscriptt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/TypoScript/setup.typoscript', $fileContents);
        }
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

        // Removes existing directories
        $this->removeDirectory('Documentation/SavLibraryConfiguration');

        if ($this->sectionManager->getItem('documentation')
            ->getItem(1)
            ->getItem('AddFormAndTableConfiguration')) {

                // Creates the folders
                GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/SavLibraryConfiguration/Forms/');

                // Prepares the data
                $extension = $this->sectionManager->getItemsAsArray();
                $data = $extension;
                $data['extensionDirectory'] = $this->extensionDirectory;
                $data['viewsFields'] = $this->arrayForCodeGenerator['views'];

                // Generates the specific documentation for SAV Library Mvc
                $fileContents = $this->generateFile('Documentation/SavLibraryConfiguration/Index.rstt', null, $data);
                GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/SavLibraryConfiguration/Index.rst', $fileContents);
                $fileContents = $this->generateFile('Documentation/SavLibraryConfiguration/Forms/Index.rstt', null, $data);
                GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/SavLibraryConfiguration/Forms/Index.rst', $fileContents);
                if (!empty($extension['newTables'])) {
                    GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/SavLibraryConfiguration/NewTables');
                    $fileContents = $this->generateFile('Documentation/SavLibraryConfiguration/NewTables/Index.rstt', null, $data);
                    GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/SavLibraryConfiguration/NewTables/Index.rst', $fileContents);
                }
                if (!empty($extension['existingTables'])) {
                    GeneralUtility::mkdir_deep($this->extensionDirectory . 'Documentation/SavLibraryConfiguration/ExistingTables');
                    $fileContents = $this->generateFile('Documentation/SavLibraryConfiguration/ExistingTables/Index.rstt', null, $data);
                    GeneralUtility::writeFile($this->extensionDirectory . 'Documentation/SavLibraryConfiguration/ExistingTables/Index.rst', $fileContents);
                }
            }
    }

    /**
     * Builds the controller.
     *
     * @return void
     */
    protected function buildController()
    {
        // Removes existing directories
        $this->removeDirectory('Classes/Controller');

        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Controller/');
        $fileDirectory = $this->extensionDirectory . 'Classes/Controller/';
        foreach ($this->sectionManager->getItem('forms') as $formKey => $form) {
            // Every form gets a corresponding Action Controller
            $fileContents = $this->generateFile('Classes/Controller/Controller.phpt', $formKey);
            GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($form->getItem('title')) . 'Controller.php', $fileContents);
        }
    }

    /**
     * Builds the Domain models.
     *
     * @return void
     */
    protected function buildDomainModels()
    {
        // Removes existing directories
        $this->removeDirectory('Classes/Domain/Model');

        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Domain/Model/');
        $fileDirectory = $this->extensionDirectory . 'Classes/Domain/Model/';
        if ($this->sectionManager->getItem('newTables') !== null) {
            foreach ($this->sectionManager->getItem('newTables')->getItems() as $itemKey => $item) {
                // Every table has a domain model
                $fileContents = $this->generateFile('Classes/Domain/Model/ModelForNewTables.phpt', $itemKey);
                GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . '.php', $fileContents);
            }
        }
        if ($this->sectionManager->getItem('existingTables') !== null) {
            foreach ($this->sectionManager->getItem('existingTables')->getItems() as $itemKey => $item) {
                // Every table has a domain model
                $fileContents = $this->generateFile('Classes/Domain/Model/ModelForExistingTables.phpt', $itemKey);
                GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . '.php', $fileContents);
            }
        }
    }

    /**
     * Builds the Domain Repositories.
     *
     * @return void
     */
    protected function buildDomainRepositories()
    {
        // Removes existing directories
        $this->removeDirectory('Classes/Domain/Repository');

        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Domain/Repository/');
        $fileDirectory = $this->extensionDirectory . 'Classes/Domain/Repository/';
        if ($this->sectionManager->getItem('newTables') !== null) {
            foreach ($this->sectionManager->getItem('newTables')->getItems() as $itemKey => $item) {
                // Every table has a domain repository
                $fileContents = $this->generateFile('Classes/Domain/Repository/RepositoryForNewTables.phpt', $itemKey);
                GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . 'Repository.php', $fileContents);
            }
        }
        if ($this->sectionManager->getItem('existingTables') !== null) {
            foreach ($this->sectionManager->getItem('existingTables')->getItems() as $itemKey => $item) {
                // Every table has a domain repository
                $fileContents = $this->generateFile('Classes/Domain/Repository/RepositoryForExistingTables.phpt', $itemKey);
                GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . 'Repository.php', $fileContents);
            }
        }
    }

    /**
     * Builds the Configuration/Extbase/Persistence/Classes.php file.
     *
     * @return void
     */
    protected function buildConfigurationExtbasePersistence()
    {
        $fileDirectory = $this->extensionDirectory . 'Configuration/Extbase/Persistence/';
        GeneralUtility::mkdir_deep($fileDirectory);
        $fileContents = $this->generateFile('Configuration/Extbase/Persistence/Classes.phpt');
        GeneralUtility::writeFile($fileDirectory . 'Classes.php', $fileContents);
    }

    /**
     * Builds the Configuration/Routes/Default.yaml file.
     *
     * @return void
     */
    protected function buildConfigurationRoutes()
    {
        $fileDirectory = $this->extensionDirectory . 'Configuration/Routes/';
        GeneralUtility::mkdir_deep($fileDirectory);
        $fileContents = $this->generateFile('Configuration/Routes/Default.yamlt');
        GeneralUtility::writeFile($fileDirectory . 'Default.yaml', $fileContents);
    }


    /**
     * Builds the migration SQL file.
     *
     * @return void
     */
    protected function buildMigration()
    {
        if ($this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('BuildMigration')) {

            GeneralUtility::mkdir_deep($this->extensionDirectory . 'Migration/');
            $fileDirectory = $this->extensionDirectory . 'Migration/';

            $fileContents = $this->generateFile('Migration/MigrationFromSavLibraryPlus.sqlt');
            GeneralUtility::writeFile($fileDirectory . 'MigrationFromSavLibraryPlus.sql', $fileContents);
        }
    }
}
