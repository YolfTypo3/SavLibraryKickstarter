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

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForFileIconSelectorbox">
 * <sav:BuildOptionsForFileIconSelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 */
class BuildOptionsForFileIconSelectorboxViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Renders the viewhelper
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
            'default' => LocalizationUtility::translate('kickstarter.newTablesItem.defIcon.white', 'sav_library_kickstarter'),
            'default_black' => LocalizationUtility::translate('kickstarter.newTablesItem.defIcon.black', 'sav_library_kickstarter'),
            'default_gray4' => LocalizationUtility::translate('kickstarter.newTablesItem.defIcon.gray', 'sav_library_kickstarter'),
            'default_blue' => LocalizationUtility::translate('kickstarter.newTablesItem.defIcon.blue', 'sav_library_kickstarter'),
            'default_green' => LocalizationUtility::translate('kickstarter.newTablesItem.defIcon.green', 'sav_library_kickstarter'),
            'default_red' => LocalizationUtility::translate('kickstarter.newTablesItem.defIcon.red', 'sav_library_kickstarter'),
            'default_yellow' => LocalizationUtility::translate('kickstarter.newTablesItem.defIcon.yellow', 'sav_library_kickstarter'),
            'default_purple' => LocalizationUtility::translate('kickstarter.newTablesItem.defIcon.purple', 'sav_library_kickstarter')
        ];
        return $options;
    }
}
