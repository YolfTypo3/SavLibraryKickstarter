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
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * A view helper for rendering the type to build the documentation.
 *
 * = Examples =
 *
 * <code title="DocumentationRenderType">
 * <sav:DocumentationRenderType string="String" />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 */
class DocumentationRenderTypeViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('string', 'string', 'String to convert', false, null);
    }
    /**
     * Renders the viewhelper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $value = $renderChildrenClosure();
        $options = [
            'Checkbox' => 'checkbox',
            'Checkboxes' => 'checkboxes',
            'Currency' => 'numeric',
            'Date' => 'date',
            'DateTime' => 'dateAndTime',
            'Files' => 'filesAndImages',
            'Graph' => 'graph',
            'Integer' => 'numeric',
            'Link' => 'link',
            'Numeric' => 'numeric',
            'RadioButtons' => 'radioButtons',
            'RelationOneToManyAsSelectorbox' => 'relation_1_n',
            'RelationManyToManyAsDoubleSelectorbox' => 'relation_n_n',
            'RelationManyToManyAsSubform' => 'relation_n_n',
            'RichTextEditor' => 'richTextEditor',
            'Text' => 'textarea',
            'Selectorbox' => 'selectorbox',
            'ShowOnly' => 'showOnly',
            'String' => 'string',

        ];
        return $options[$value];
    }
}
