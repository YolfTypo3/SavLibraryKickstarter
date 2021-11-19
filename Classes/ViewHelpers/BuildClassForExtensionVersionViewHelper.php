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
 * A view helper for building the class for the extension version.
 *
 * = Examples =
 *
 * <code title="BuildClassForExtensionVersionSelectorbox">
 * <sav:BuildClassForExtensionVersionSelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 */
class BuildClassForExtensionVersionViewHelper extends AbstractViewHelper
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
        $this->registerArgument('extensionVersion', 'string', 'Extension version', true);
    }

    /**
     * Renders the class
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string the class
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $extensionKey = $arguments['extensionKey'];
        $extensionVersion = $arguments['extensionVersion'];

        $options = BuildOptionsForExtensionVersionSelectorboxViewHelper::renderOptions($extensionKey);

        if (is_array($options) && current($options) == $extensionVersion) {
            return 'extensionVersion';
        } else {
            return 'extensionVersion NotLatest';
        }
    }
}
