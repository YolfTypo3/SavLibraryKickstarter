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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for sorting the fields in a view.
 *
 * @package SavLibraryKickstarter
 */
class DocumentationProcessFieldConfigurationViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('configuration', 'array', 'Field configuration', false, null);
    }

    /**
     * Renders the viewhelper
     *
     * @return array Sorted fields
     */
    public function render(): array
    {
        // Gets the arguments
        $configuration = $this->arguments['configuration'];

        if ($configuration === null) {
            $configuration = $this->renderChildren();
        }

        unset($configuration['tableName']);
        unset($configuration['fieldName']);
        unset($configuration['fieldType']);
        unset($configuration['renderType']);
        unset($configuration['subformItem']);
        return $configuration;
    }
}
