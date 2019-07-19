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
class CodeGeneratorForSavLibraryBasic extends AbstractCodeGenerator
{

    /**
     * The code templates directory
     *
     * @var string
     */
    protected static $codeTemplatesDirectory = 'Resources/Private/CodeTemplates/ForSavLibraryBasic/';

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

        // Generates the Css file
        $this->buildCssFile();

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

        // Generates the Fluid directories
        $this->buildFluidDirectories();

        // Generates the Domain models
        $this->buildDomainModels();

        // Generates the Domain repositories
        $this->buildDomainRepositories();

        // Generates the Controller
        $this->buildController();
    }

    /**
     * Specific methods for this generator
     */
    
    /**
     * Builds the CSS file.
     *
     * @return void
     */
    protected function buildCssFile()
    {
        // Generates the Resources/Public/Css directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Resources/Public/Css/');

        // Generates the default styles
        $this->generateFile('Resources/Public/Css/StyleSheet.csst');
    }

    /**
     * Builds the Configuration/Flexforms file.
     *
     * Overloads the defaut method to generate the flexform only if it does not exists
     *
     * @return void
     */
    protected function buildConfigurationFlexform()
    {
        // Generates the Configuration/Flexforms directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Configuration/Flexforms/');

        // Generates ExtensionFlexform.xml file if it does not exist
        if (! file_exists($this->extensionDirectory . 'Configuration/Flexforms/ExtensionFlexform.xml')) {
            $fileContents = $this->generateFile('Configuration/Flexforms/ExtensionFlexform.xmlt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Configuration/Flexforms/ExtensionFlexform.xml', $fileContents);
        }
    }

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
     * Builds The fluid directories.
     *
     * @return void
     */
    protected function buildFluidDirectories()
    {
        // Generates the Resources/Private/Layouts directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Resources/Private/Layouts/');

        // Generates the Resources/Private/Templates directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Resources/Private/Templates/');

        // Generates the Resources/Private/Partials directory
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Resources/Private/Partials/');

        // Generates the Controller templates directory
        $forms = $this->sectionManager->getItem('forms')->getItemsAsArray();
        $form = current($forms);
        $controllerName = GeneralUtility::underscoredToUpperCamelCase($form['title']);
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Resources/Private/Templates/' . $controllerName . '/');

        // Generates the template file if it does not exists
        $views = $this->sectionManager->getItem('views')->getItemsAsArray();
        $view = current($views);
        $templateFileName = GeneralUtility::underscoredToUpperCamelCase($view['title']);
        if (! file_exists($this->extensionDirectory . 'Resources/Private/Templates/' . $controllerName . '/' . $templateFileName . '.html')) {
            $fileContents = $this->generateFile('Resources/Private/Templates/Template.htmlt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Resources/Private/Templates/' . $controllerName . '/' . $templateFileName . '.html', $fileContents);
        }
    }

    /**
     * Builds the controller.
     *
     * @return void
     */
    protected function buildController()
    {
        // Gets the controller name
        $forms = $this->sectionManager->getItem('forms')->getItemsAsArray();
        $form = current($forms);
        $controllerName = GeneralUtility::underscoredToUpperCamelCase($form['title']);

        if (! file_exists($this->extensionDirectory . 'Classes/Controller/' . $controllerName . 'Controller.php')) {
            GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Controller/');
            $fileContents = $this->generateFile('Classes/Controller/Controller.phpt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Classes/Controller/' . $controllerName . 'Controller.php', $fileContents);
        }

        // Builds the wizard plugin icon
        if ($this->sectionManager->getItem('general')
            ->getItem(1)
            ->getItem('addWizardPluginIcon')) {
            $fileContents = $this->generateFile('Classes/Controller/WizardIcon.phpt');
            GeneralUtility::writeFile($this->extensionDirectory . 'Classes/Controller/' . $controllerName . 'WizardIcon.php', $fileContents);
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
            if (! file_exists($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . 'Repository.php')) {
                $fileContents = $this->generateFile('Classes/Domain/Repository/Repository.phpt', $itemKey);
                GeneralUtility::writeFile($fileDirectory . GeneralUtility::underscoredToUpperCamelCase($item['tablename']) . 'Repository.php', $fileContents);
            }
        }
    }
}
?>
