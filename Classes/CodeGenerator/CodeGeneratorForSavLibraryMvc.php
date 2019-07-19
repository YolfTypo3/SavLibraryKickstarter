<?php
namespace YolfTypo3\SavLibraryKickstarter\CodeGenerator;

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

/**
 * This class generates the code for a front end plugin.
 *
 * It is based on the same idea developed by Ingmar Schlecht for the extbase_kickstater.
 * Code templates are used to build the file contents. They are processed by a fluid parser.
 */
class CodeGeneratorForSavLibraryMvc extends AbstractCodeGenerator
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

        // Generates constants.txt file if it does not exist
        if (! file_exists($this->extensionDirectory . 'Configuration/TypoScript/constants.txt')) {
            $fileContents = $this->generateFile('Configuration/TypoScript/constants.txtt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/TypoScript/constants.txt', $fileContents);
        }

        // Generates setup.txt file if it does not exist
        if (! file_exists($this->extensionDirectory . 'Configuration/TypoScript/setup.txt')) {
            $fileContents = $this->generateFile('Configuration/TypoScript/setup.txtt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/TypoScript/setup.txt', $fileContents);
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
        $fileDirectory = $this->extensionDirectory . 'Classes/Controller/';
        foreach ($this->sectionManager->getItem('forms')->getItems() as $itemKey => $item) {
            // Every form gets a corresponding Action Controller
            $fileContents = $this->generateFile('Classes/Controller/Controller.phpt', $itemKey);
            GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['title']) . 'Controller.php', $fileContents);
        }

        // Builds the wizard plugin icon
        if ($this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('addWizardPluginIcon')) {
            $fileContents = $this->generateFile('Classes/Controller/WizardIcon.phpt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Classes/Controller/WizardIcon.php', $fileContents);
        }
    }

    /**
     * Builds the Domain models.
     *
     * @return void
     */
    protected function buildDomainModels()
    {
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Domain/Model/');
        $fileDirectory = $this->extensionDirectory . 'Classes/Domain/Model/';
        foreach ($this->sectionManager->getItem('newTables')->getItems() as $itemKey => $item) {
            // Every table has a domain model
            $fileContents = $this->generateFile('Classes/Domain/Model/Model.phpt', $itemKey);
            GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . '.php', $fileContents);
        }
    }

    /**
     * Builds the Domain Repositories.
     *
     * @return void
     */
    protected function buildDomainRepositories()
    {
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Domain/Repository/');
        $fileDirectory = $this->extensionDirectory . 'Classes/Domain/Repository/';
        foreach ($this->sectionManager->getItem('newTables')->getItems() as $itemKey => $item) {
            // Every table has a domain repository
            $fileContents = $this->generateFile('Classes/Domain/Repository/Repository.phpt', $itemKey);
            GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . 'Repository.php', $fileContents);
        }
    }
}
?>
