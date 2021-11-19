<?php

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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Be\Buttons;

use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\ViewHelpers\Be\AbstractBackendViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * ViewHelper which returns CSH (context sensitive help) button with icon
 * Note: The CSH button will only work, if the current BE user has the "Context Sensitive Help mode"
 * set to something else than "Display no help information" in the Users settings
 * Note: This ViewHelper is experimental!
 *
 * Examples
 * ========
 *
 * Default::
 *
 * <sav:be.buttons.help/>
 *
 * Help button (link to the SAV Library Kickstarter documentation.
 *
 * Full configuration::
 *
 * <f:be.buttons.help section="myKey" />
 *
 * Generates a link to the section whose key is myKey of the documentation
 */
class HelpViewHelper extends AbstractBackendViewHelper
{

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;

    /**
     * The TYPO3 documentaion root URL
     *
     * @var string
     */
    protected static $documentationRootUrl = 'https://docs.typo3.org/p/yolftypo3/sav-library-kickstarter/master/en-us/';

    /**
     * Key to section array
     *
     * @var array
     */
    protected static $keyToSection = [
        'Checkbox' => 'Reference/Checkbox',
        'Checkboxes' => 'Reference/Checkboxes',
        'Currency' => '',
        'Date' => 'Reference/Date',
        'DateTime' => 'Reference/DateAndTime',
        'Files' => 'Reference/FilesAndImages',
        'Graph' => 'Reference/Graph',
        'Integer' => '',
        'Link' => 'Reference/Link',
        'Numeric' => 'Reference/Numeric',
        'RadioButtons' => 'Reference/RadioButtons',
        'RelationOneToManyAsSelectorbox' => 'Reference/Relation_1_n',
        'RelationManyToManyAsDoubleSelectorbox' => 'Reference/Relation_1_n',
        'RelationManyToManyAsSubform' => 'Reference/Relation_n_n',
        'RichTextEditor' => 'Reference/RichTextEditor',
        'Selectorbox' => 'Reference/Selectorbox',
        'ShowOnly' => 'Reference/ShowOnly',
        'String' => 'Reference/String',
        'Text' => 'Reference/Textarea',

        'documentation' => 'UsersManual/KickstarterMenu/DocumentationConfiguration',
        'emconf' => 'UsersManual/KickstarterMenu/ExtensionConfiguration',
        'existingTables' => 'UsersManual/KickstarterMenu/ExistingTables',
        'newTables' => 'UsersManual/KickstarterMenu/NewTables',
        'forms' => 'UsersManual/KickstarterMenu/Forms',
        'queries' => 'UsersManual/KickstarterMenu/Queries',
        'views' => 'UsersManual/KickstarterMenu/Views'
    ];

    /**
     * Initialize arguments.
     *
     * @throws \TYPO3Fluid\Fluid\Core\ViewHelper\Exception
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('key', 'string', 'key to the section of the documentation', true);
        $this->registerArgument('tag', 'string', 'tag in the section of the documentation');
    }

    /**
     * Render the help button
     *
     * @return string the help icon
     */
    public function render()
    {
        return static::renderStatic($this->arguments, $this->buildRenderChildrenClosure(), $this->renderingContext);
    }

    /**
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $key = $arguments['key'];
        $tag = ($arguments['tag'] ? '#' . $arguments['tag'] : '');
        $section = self::$keyToSection[$key];
        if (! empty($section)) {
            $documentationUrl = self::$documentationRootUrl . $section . '/Index.html' . $tag;
            $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
            $icon = $iconFactory->getIcon('actions-system-help-open', Icon::SIZE_SMALL)->render();
            $title = LocalizationUtility::translate('kickstarter.help', 'sav_library_kickstarter');
            $result = '<div class="docheader-csh" title="' . $title . '" ><a target="_blank" href="' . $documentationUrl . '">' . $icon . '</a></div>';
        } else {
            $result = '';
        }

        return $result;
    }
}
