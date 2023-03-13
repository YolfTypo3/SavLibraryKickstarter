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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A view helper for building the options for the extension version.
 *
 *
 * @package SavLibraryKickstarter
 */
class ForExtensionVersionSelectorboxViewHelper extends AbstractViewHelper
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
    }

    /**
     * Renders the viewhelper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return array The options
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        // Gets the arguments
        $extensionKey = $arguments['extensionKey'];

        return self::renderOptions($extensionKey);
    }

    /**
     * Renders the options
     *
     * @param string $extensionKey
     * @return array the options array
     */
    public static function renderOptions($extensionKey): array
    {
        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        $libraryName = trim(GeneralUtility::getURL(ConfigurationManager::getLibraryTypeFileName($extensionKey)));

        $configurationDirectory = $extensionDirectory . ConfigurationManager::CONFIGURATION_DIRECTORY . $libraryName;

        $configurationFilename = pathinfo(ConfigurationManager::getConfigurationFileName($extensionKey));

        $options = [];
        if ($handle = opendir($configurationDirectory)) {

            while (false !== ($file = readdir($handle))) {
                $match = [];
                if ($file != '.' && $file != '..' && preg_match('/^' . $configurationFilename['filename'] . '(\w*)\.' . $configurationFilename['extension'] . '$/', $file, $match)) {
                    if ($match[1]) {
                        $value = substr(str_replace('_', '.', $match[1]), 1);
                        $options[$value] = $value;
                    }
                }
            }
        }

        uasort($options, 'self::versionCompareDescendingOrder');

        return $options;
    }

    protected static function versionCompareDescendingOrder($a, $b)
    {
        return version_compare($b, $a);
    }
}
