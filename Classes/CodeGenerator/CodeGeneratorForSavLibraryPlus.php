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
class CodeGeneratorForSavLibraryPlus extends PreprocessingForCodeGenerator
{

    /**
     * The code templates directory
     *
     * @var string
     */
    protected static $codeTemplatesDirectory = 'Resources/Private/CodeTemplates/ForSavLibraryPlus/';

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

        // Preprocessing
        $this->buildArrayForCodeGenerator();

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
        $fileContents = $this->generateFile('Configuration/Library/SavLibraryPlus.xmlt', null, $this->arrayForCodeGenerator);
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

        // Removes existing directories
        GeneralUtility::rmdir($this->extensionDirectory . 'Documentation/SavLibraryConfiguration', true);

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

            // Generates the specific documentation for SAV Library Plus
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
        GeneralUtility::mkdir_deep($this->extensionDirectory . 'Classes/Controller/');
        $fileContents = $this->generateFile('Classes/Controller/Controller.phpt');
        GeneralUtility::writeFile($this->extensionDirectory . 'Classes/Controller/' . GeneralUtility::underscoredToUpperCamelCase($this->extensionKey) . 'Controller.php', $fileContents);
    }
}
