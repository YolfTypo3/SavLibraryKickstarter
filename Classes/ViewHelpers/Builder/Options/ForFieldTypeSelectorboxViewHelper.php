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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Options;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for building the options for the field type selector.
 *
 *
 * @package SavLibraryKickstarter
 */
class ForFieldTypeSelectorboxViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Renders the viewheper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return array the options array
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $options = [
            'Unknown' => LocalizationUtility::translate('kickstarter.field.fieldType.Unknown', 'sav_library_kickstarter'),
            'Checkbox' => LocalizationUtility::translate('kickstarter.field.fieldType.Checkbox', 'sav_library_kickstarter'),
            'Checkboxes' => LocalizationUtility::translate('kickstarter.field.fieldType.Checkboxes', 'sav_library_kickstarter'),
            'Currency' => LocalizationUtility::translate('kickstarter.field.fieldType.Currency', 'sav_library_kickstarter'),
            'Date' => LocalizationUtility::translate('kickstarter.field.fieldType.Date', 'sav_library_kickstarter'),
            'DateTime' => LocalizationUtility::translate('kickstarter.field.fieldType.DateTime', 'sav_library_kickstarter'),
            'Files' => LocalizationUtility::translate('kickstarter.field.fieldType.Files', 'sav_library_kickstarter'),
            'Graph' => LocalizationUtility::translate('kickstarter.field.fieldType.Graph', 'sav_library_kickstarter'),
            'Integer' => LocalizationUtility::translate('kickstarter.field.fieldType.Integer', 'sav_library_kickstarter'),
            'Link' => LocalizationUtility::translate('kickstarter.field.fieldType.Link', 'sav_library_kickstarter'),
            'Numeric' => LocalizationUtility::translate('kickstarter.field.fieldType.Numeric', 'sav_library_kickstarter'),
            'RadioButtons' => LocalizationUtility::translate('kickstarter.field.fieldType.RadioButtons', 'sav_library_kickstarter'),
            'RelationOneToManyAsSelectorbox' => LocalizationUtility::translate('kickstarter.field.fieldType.RelationOneToManyAsSelectorbox', 'sav_library_kickstarter'),
            'RelationManyToManyAsDoubleSelectorbox' => LocalizationUtility::translate('kickstarter.field.fieldType.RelationManyToManyAsDoubleSelectorbox', 'sav_library_kickstarter'),
            'RelationManyToManyAsSubform' => LocalizationUtility::translate('kickstarter.field.fieldType.RelationManyToManyAsSubform', 'sav_library_kickstarter'),
            'RichTextEditor' => LocalizationUtility::translate('kickstarter.field.fieldType.RichTextEditor', 'sav_library_kickstarter'),
            'Selectorbox' => LocalizationUtility::translate('kickstarter.field.fieldType.Selectorbox', 'sav_library_kickstarter'),
            'ShowOnly' => LocalizationUtility::translate('kickstarter.field.fieldType.ShowOnly', 'sav_library_kickstarter'),
            'String' => LocalizationUtility::translate('kickstarter.field.fieldType.String', 'sav_library_kickstarter'),
            'Text' => LocalizationUtility::translate('kickstarter.field.fieldType.Text', 'sav_library_kickstarter')
        ];
        return $options;
    }
}
