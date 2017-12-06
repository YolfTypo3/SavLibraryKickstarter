<?php
namespace YolfTypo3\SavLibraryKickstarter\CodeGenerator;

/**
 * Copyright notice
 *
 * (c) 2015 Laurent Foulloy (yolf.typo3@orange.fr)
 * All rights reserved
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
     * Builds all the file for the extension.
     *
     * @return void
     */
    public function buildExtension()
    {
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
     * Builds icons files.
     *
     * @return void
     */
    protected function buildIcons()
    {
        // Generates the Resources/Public/Icons directory
        GeneralUtility::mkdir_deep($this->extensionDirectory, 'Resources/Public/Icons');

        // Generates the icons
        $this->generateFile('icons.t');
    }

    /**
     * Builds ext_emconf.php.
     *
     * @return void
     */
    protected function buildExtEmConf()
    {
        $fileContents = $this->generateFile('extEmconf.phpt');
        GeneralUtility::writeFile($this->extensionDirectory . 'ext_emconf.php', $fileContents);
    }

    /**
     * Builds composer.json.
     *
     * @return void
     */
    protected function buildComposer()
    {
        $fileContents = $this->generateFile('composer.jsont');
        GeneralUtility::writeFile($this->extensionDirectory . 'composer.json', $fileContents);
    }

    /**
     * Builds ext_localconf.php.
     *
     * @return void
     */
    protected function buildExtLocalConf()
    {
        if (! $this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('keepExtLocalConf') || ($this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('keepExtLocalConf') && ! file_exists($this->extensionDirectory . 'ext_localconf.php'))) {
            $fileContents = $this->generateFile('extLocalconf.phpt');
            GeneralUtility::writeFile($this->extensionDirectory . 'ext_localconf.php', $fileContents);
        }
    }

    /**
     * Builds ext_tables files.
     *
     * @return void
     */
    protected function buildExtTablesFiles()
    {
        // Generates ext_tables.sql
        $fileContents = $this->generateFile('extTables.sqlt');
        GeneralUtility::writeFile($this->extensionDirectory . 'ext_tables.sql', $fileContents);

        // Generates ext_tables.php
        $fileContents = $this->generateFile('extTables.phpt');
        GeneralUtility::writeFile($this->extensionDirectory . 'ext_tables.php', $fileContents);
    }

    /**
     * Builds the Configuration/TCA file(s).
     *
     * @return void
     */
    protected function buildConfigurationTCA()
    {
        GeneralUtility::mkdir_deep($this->extensionDirectory, 'Configuration/TCA');
        // For tca, files are written during the generation
        $this->generateFile('Configuration/TCA/tca.phpt');
    }

    /**
     * Builds the Configuration/TypoScript file(s).
     *
     * @return void
     */
    protected function buildConfigurationTypoScript()
    {
        GeneralUtility::mkdir_deep($this->extensionDirectory, 'Configuration/TypoScript');

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
     * Builds the Configuration/Flexforms file.
     *
     * @return void
     */
    protected function buildConfigurationFlexform()
    {
        // Generates the Configuration/Flexforms directory
        GeneralUtility::mkdir_deep($this->extensionDirectory, 'Configuration/Flexforms');

        // Generates flexforms
        $fileContents = $this->generateFile('Configuration/Flexforms/ExtensionFlexform.xmlt');
        GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Flexforms/ExtensionFlexform.xml', $fileContents);
    }

    /**
     * Builds Language files.
     *
     * @return void
     */
    protected function buildLanguageFiles()
    {
        // Generates the Resources/Private/Language directory
        GeneralUtility::mkdir_deep($this->extensionDirectory, 'Resources/Private/Language');

        // Generate locallang.xlf file if it does not exist
        if (! file_exists($this->extensionDirectory . 'Resources/Private/Language/locallang.xlf')) {
            $fileContents = $this->generateFile('Resources/Private/Language/locallang.xlft');
            GeneralUtility::writeFile($this->extensionDirectory . 'Resources/Private/Language/locallang.xlf', $fileContents);
        }

        // Generates locallang_db.xlf file
        $fileContents = $this->generateFile('Resources/Private/Language/locallang_db.xlft');
        GeneralUtility::writeFile($this->extensionDirectory . 'Resources/Private/Language/locallang_db.xlf', $fileContents);
    }

    /**
     * Builds the controller.
     *
     * @return void
     */
    protected function buildController()
    {
        GeneralUtility::mkdir_deep($this->extensionDirectory, 'Classes/Controller');
        $fileDirectory = $this->extensionDirectory . 'Classes/Controller/';
        foreach ($this->sectionManager->getItem('forms')->getItems() as $itemKey => $item) {
            // Every form gets a corresponding Action Controller
            $fileContents = $this->generateFile('Classes/Controller/Controller.phpt', $itemKey);
            GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['title']) . 'Controller.php', $fileContents);
        }

        // Builds the wizard plugin icon
        if ($this->sectionManager->getItem('general')->getItem(1)->getItem('addWizardPluginIcon')) {
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
        GeneralUtility::mkdir_deep($this->extensionDirectory, 'Classes/Domain/Model');
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
        GeneralUtility::mkdir_deep($this->extensionDirectory, 'Classes/Domain/Repository');
        $fileDirectory = $this->extensionDirectory . 'Classes/Domain/Repository/';
        foreach ($this->sectionManager->getItem('newTables')->getItems() as $itemKey => $item) {
            // Every table has a domain repository
            $fileContents = $this->generateFile('Classes/Domain/Repository/Repository.phpt', $itemKey);
            GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . 'Repository.php', $fileContents);
        }
    }
}
?>
