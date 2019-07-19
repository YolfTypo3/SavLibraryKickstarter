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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A view helper for saving a content into a file.
 *
 * = Examples =
 *
 * <code title="SaveContentToFile">
 * <sav:saveContentToFile content="Text to save" fileName="fileName" extensionKey="extensionKey"/>
 * </code>
 *
 * Output:
 * None
 *
 * @package SavLibraryKickstarter
 */
class SaveContentToFileViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('content', 'string', 'Content to save', true);
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
        $this->registerArgument('fileName', 'string', 'File name', true);
        $this->registerArgument('directory', 'string', 'Directory to create if not empty', false, '');
    }

    /**
     * Saves the content into the file
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return void
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $content = $arguments['content'];
        $extensionKey = $arguments['extensionKey'];
        $fileName = $arguments['fileName'];
        $directory = rtrim($arguments['directory'], '/') . '/';

        // Creates a new directory if needed
        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        if (! empty($directory)) {
            GeneralUtility::mkdir_deep($extensionDirectory . $directory);
        }

        GeneralUtility::writeFile($extensionDirectory . '/' . $fileName, $content);
    }
}
?>

