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
 * A view helper which returns a file if its exists in the SAV Library Kickstarter
 * and the default one otherwise.
 *
 * = Examples =
 *
 * <code title="useDefault">
 * <sav:useDefault fileName="file to check" default="default file" />
 * </code>
 *
 * @package SavLibraryKickstarter
 */
class UseDefaultViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('path', 'string', 'Path', true);
        $this->registerArgument('fileName', 'string', 'File name to check', true);
        $this->registerArgument('default', 'string', 'Default file', true);
    }

    /**
     * Renders the viewhelper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string Either the fileName if the file exits in the SAV Library Kickstarter or the defaut
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $path = $arguments['path'];
        $fileName = $arguments['fileName'];
        $default = $arguments['default'];

        if (file_exists($path . $fileName)) {
            return $fileName;
        } else {
            return $default;
        }
    }
}
