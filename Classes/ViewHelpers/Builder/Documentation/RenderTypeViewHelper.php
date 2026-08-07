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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Documentation;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for rendering the type to build the documentation.
 *
 * = Examples =
 *
 * <code title="documentation.renderType">
 * <sav:documentation.renderType string="String" />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 */
final class RenderTypeViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('type', 'string', 'Type to convert', false, null);
    }
    
    /**
     * Renders the view helper
     *
     * @return string
     */
    public function render(): string
    {

        // Gets the arguments
        $type = $this->arguments['type'];

        if ($type === null) {
            $type = $this->renderChildren();
        }

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
        return $options[$type];
    }
}
