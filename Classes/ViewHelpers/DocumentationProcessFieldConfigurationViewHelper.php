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
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for sorting the fields in a view.
 *
 * @package SavLibraryKickstarter
 */
class DocumentationProcessFieldConfigurationViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
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
     * Renders the table name
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string the table name
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $configuration = $arguments['configuration'];

        if ($configuration === null) {
            $configuration = $renderChildrenClosure();
        }

        unset($configuration['tableName']);
        unset($configuration['fieldName']);
        unset($configuration['fieldType']);
        unset($configuration['fieldTitle']);
        unset($configuration['renderType']);
        unset($configuration['subformItem']);

        return $configuration;
    }
}
