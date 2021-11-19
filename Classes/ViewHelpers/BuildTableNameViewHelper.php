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
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildTableName">
 * <sav:BuildTableName />
 * </code>
 *
 * Output:
 * the table name
 *
 * @package SavLibraryKickstarter
 */
class BuildTableNameViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
        $this->registerArgument('shortName', 'string', 'Short name', false, '');
        $this->registerArgument('prefix', 'string', 'Prefix', false, '');
        $this->registerArgument('shortNameOnly', 'boolean', 'Short name only', false, false);
        $this->registerArgument('mvc', 'boolean', 'Mvc flag', false, false);
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
        $extensionKey = $arguments['extensionKey'];
        $shortName = $arguments['shortName'];
        $prefix = $arguments['prefix'];
        $shortNameOnly = $arguments['shortNameOnly'];
        $mvc = $arguments['mvc'];

        if ($prefix != '') {
            $prefix = $prefix . '_';
        }
        if ($shortNameOnly === true) {
            return $shortName;
        } else {
            $domain = ($mvc ? '_domain_model' : '');
            $defaultShortName = ($mvc ? '_default' : '');
            return strtolower($prefix . 'tx_' . str_replace('_', '', $extensionKey) . $domain . ($shortName ? '_' . $shortName : $defaultShortName));
        }
    }

}
