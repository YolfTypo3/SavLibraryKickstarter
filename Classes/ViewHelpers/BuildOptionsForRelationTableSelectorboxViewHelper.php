<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

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
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForRelationTableSelectorbox">
 * <sav:BuildOptionsForRelationTableSelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryMvc
 */
class BuildOptionsForRelationTableSelectorboxViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('arguments', 'array', 'Arguments', true);
    }

    /**
     * Renders the options
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return array the options array
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $arguments = $arguments['arguments'];

        $options = [
            'pages' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.pages', 'sav_library_kickstarter'),
            'fe_users' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.fe_users', 'sav_library_kickstarter'),
            'fe_groups' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.fe_groups', 'sav_library_kickstarter'),
            'tt_content' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.tt_content', 'sav_library_kickstarter')
        ];

        $newTables = $arguments['newTables'];
        if (is_array($newTables)) {
            foreach ($newTables as $table) {
                switch ($arguments['general'][1]['libraryType']) {
                    case ConfigurationManager::TYPE_SAV_LIBRARY:
                    case ConfigurationManager::TYPE_SAV_LIBRARY_PLUS:
                        $tableName = 'tx_' . str_replace('_', '', $arguments['general'][1]['extensionKey']) . ($table['tablename'] ? '_' . $table['tablename'] : '');
                        break;
                    case ConfigurationManager::TYPE_SAV_LIBRARY_BASIC:
                    case ConfigurationManager::TYPE_SAV_LIBRARY_MVC:
                        $tableName = 'tx_' . str_replace('_', '', $arguments['general'][1]['extensionKey']) . '_domain_model_' . ($table['tablename'] ? $table['tablename'] : 'default');
                        break;
                }
                $options = array_merge($options, [
                    $tableName => $table['title'] . ', (' . $tableName . ')'
                ]);
            }
        }
        $options = array_merge($options, [
            '_CUSTOM' => LocalizationUtility::translate('kickstarter.field.conf_rel_table.custom', 'sav_library_kickstarter')
        ]);

        return $options;
    }
}
?>

