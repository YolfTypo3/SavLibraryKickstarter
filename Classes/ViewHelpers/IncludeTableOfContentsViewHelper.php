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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Gets the icon source by icon identifier
 */
class IncludeTableOfContentsViewHelper extends AbstractViewHelper
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
        $this->registerArgument('nbSpace', 'int', 'Number of space prepended to each line', true);
    }

    /**
     * Gets the icon source for $identifier key
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $extensionKey = $arguments['extensionKey'];
        $nbSpace = $arguments['nbSpace'];

        $extensionDirectory = Environment::getPublicPath() . '/typo3conf/ext/' . $extensionKey . '/';
        $fileName = $extensionDirectory . 'Documentation/TableOfContents.txt';

        if (file_exists($fileName)) {
            $lines = explode(chr(10), file_get_contents($fileName));
            $result =[];
            foreach ($lines as $line) {
                $result[] = str_repeat(' ', $nbSpace) . $line;
            }
            $content = implode(chr(10), $result);

            return $content;
        }

        return '';
    }
}
