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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Mvc;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for obtaining the model from a table name.
 *
 * = Examples =
 *
 * <code title="GetModelFromTableName">
 * <sav:getModelFromTableName extension="sav_library_example" table="tx_savlibraryexample_test" />
 * <sav:getModelFromTableName extension="SavLibraryExample" table="tx_savlibraryexample_test" />
 * </code>
 *
 * Output:
 * Test
 *
 * @package SavLibraryMvc
 *
 */
class GetModelFromTableNameViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     */
    public function initializeArguments()
    {
        $this->registerArgument('extension', 'string', 'Extension name', true);
        $this->registerArgument('table', 'string', 'Table Name', false, null);
    }

    /**
     * Renders the model
     *
     * @return string the model in UpperCamelCase
     */
    public function render()
    {
        // Gets the arguments
        $extension = $this->arguments['extension'];
        $table = $this->arguments['table'];

        if ($table === null) {
            $table = $this->renderChildren();
        }
        $tableName = GeneralUtility::underscoredToUpperCamelCase($table);
        $extensionName = ucfirst(strtolower(GeneralUtility::underscoredToUpperCamelCase($extension)));
        return GeneralUtility::underscoredToUpperCamelCase(str_replace('Tx' . $extensionName . 'DomainModel', '', $tableName));
    }
}
