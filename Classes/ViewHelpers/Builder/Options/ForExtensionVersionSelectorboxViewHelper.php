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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use YolfTypo3\SavLibraryKickstarter\Managers\ConfigurationManager;

/**
 * A view helper for building the options for the extension version.
 *
 *
 * @package SavLibraryKickstarter
 */
final class ForExtensionVersionSelectorboxViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
    }

    /**
     * Renders the view helper
     *
     * @return array
     */
    public function render(): array
    {
        // Gets the arguments
        $extensionKey = $this->arguments['extensionKey'];

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
        $configurationFilename = ConfigurationManager::getConfigurationFileName($extensionKey);
        $pathInfo = pathinfo($configurationFilename);
        $options = [];
        if ($handle = opendir($pathInfo['dirname'])) {

            while (false !== ($file = readdir($handle))) {
                $match = [];
                if ($file != '.' && $file != '..' && preg_match('/^' . $pathInfo['filename'] . '(\w*)\.' . $pathInfo['extension'] . '$/', $file, $match)) {
                    if ($match[1]) {
                        $value = substr(str_replace('_', '.', $match[1]), 1);
                        $options[$value] = $value;
                    }
                }
            }
        }

        uasort($options, self::class . '::versionCompareDescendingOrder');

        return $options;
    }

    protected static function versionCompareDescendingOrder($a, $b): int
    {
        return version_compare($b, $a);
    }
}
