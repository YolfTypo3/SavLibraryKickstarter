<?php
namespace SAV\SavLibraryKickstarter\ViewHelpers;

/*
 * This script is part of the TYPO3 project - inspiring people to share! *
 * *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by *
 * the Free Software Foundation. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General *
 * Public License for more details. *
 */

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
/**
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForFieldTypeSelectorbox">
 * <sav:BuildOptionsForFieldTypeSelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 */
class BuildOptionsForFieldTypeSelectorboxViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @return string the options array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render()
    {
        $options = array(
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
            'RadioButtons' => LocalizationUtility::translate('kickstarter.field.fieldType.RadioButtons', 'sav_library_kickstarter'),
            'RelationOneToManyAsSelectorbox' => LocalizationUtility::translate('kickstarter.field.fieldType.RelationOneToManyAsSelectorbox', 'sav_library_kickstarter'),
            'RelationManyToManyAsDoubleSelectorbox' => LocalizationUtility::translate('kickstarter.field.fieldType.RelationManyToManyAsDoubleSelectorbox', 'sav_library_kickstarter'),
            'RelationManyToManyAsSubform' => LocalizationUtility::translate('kickstarter.field.fieldType.RelationManyToManyAsSubform', 'sav_library_kickstarter'),
            'RichTextEditor' => LocalizationUtility::translate('kickstarter.field.fieldType.RichTextEditor', 'sav_library_kickstarter'),
            'Selectorbox' => LocalizationUtility::translate('kickstarter.field.fieldType.Selectorbox', 'sav_library_kickstarter'),
            'ShowOnly' => LocalizationUtility::translate('kickstarter.field.fieldType.ShowOnly', 'sav_library_kickstarter'),
            'String' => LocalizationUtility::translate('kickstarter.field.fieldType.String', 'sav_library_kickstarter'),
            'Text' => LocalizationUtility::translate('kickstarter.field.fieldType.Text', 'sav_library_kickstarter')
        );
        return $options;
    }
}
?>

