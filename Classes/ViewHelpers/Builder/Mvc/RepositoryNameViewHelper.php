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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Mvc;

use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * A view helper for building the repository name.
 *
 *
 * @package SavLibraryKickstarter
 */
class RepositoryNameViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;
    /**
     *
     * @var array
     */
    protected static $extensionKeyMap;

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('tableName', 'string', 'Table name', false, null);
        $this->registerArgument('extension', 'array', 'Extension', false, null);
        $this->registerArgument('removeFirstBackslash', 'boolean', 'Flag to remove the first backslash', false, false);
        $this->registerArgument('shortName', 'boolean', 'if true returns the short name', false, false);
    }

    /**
     * Renders the item
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
        $tableName = $arguments['tableName'];
        $extension = $arguments['extension'];
        $removeFirstBackslash = $arguments['removeFirstBackslash'];
        $shortName = $arguments['shortName'];

        if ($tableName === null) {
            $tableName = $renderChildrenClosure();
        }

        // Extracts the extension and the short model names
        $match = [];
        if (preg_match('/^tx_(?P<extensionName>\w+)_domain_model_(?P<shortModelName>\w+)$/', $tableName, $match)) {
            // Gets the extension key from the prefix
            $extensionKey = self::getExtensionKeyByPrefix('tx_' . $match['extensionName']);
            $shortModelName = GeneralUtility::underscoredToUpperCamelCase($match['shortModelName']);
        } else {
            // The model is in the extension
            $extensionKey = $extension['general'][1]['extensionKey'];
            $shortModelName = GeneralUtility::underscoredToUpperCamelCase($tableName);
        }

        // Returns the short name if required
        if ($shortName) {
            return $shortModelName . 'Repository';
        }

        // Returns the repository name
        $repositoryName = $extension['general'][1]['vendorName'] .
            '\\' . GeneralUtility::underscoredToUpperCamelCase($extensionKey) .
            '\\Domain\Repository\\' . $shortModelName . 'Repository';
        if (! $removeFirstBackslash) {
            $repositoryName = '\\' . $repositoryName;
        }
        return $repositoryName;
    }

    /**
     * Returns the real extension key like 'tt_news' from an extension prefix like 'tx_ttnews'.
     *
     * @param string $prefix
     *            The extension prefix (e.g. 'tx_ttnews')
     * @return mixed Real extension key (string)or FALSE (bool) if something went wrong
     */
    protected static function getExtensionKeyByPrefix($prefix)
    {
        $result = false;
        // Build map of short keys referencing to real keys:

        if (! isset(self::$extensionKeyMap)) {
            $packageManager = GeneralUtility::makeInstance(PackageManager::class);
            self::$extensionKeyMap = [];
            foreach ($packageManager->getAvailablePackages() as $package) {
                $shortKey = str_replace('_', '', $package->getPackageKey());
                self::$extensionKeyMap[$shortKey] = $package->getPackageKey();
            }
        }
        // Lookup by the given short key:
        $parts = explode('_', $prefix);
        if (isset(self::$extensionKeyMap[$parts[1]])) {
            $result = self::$extensionKeyMap[$parts[1]];
        }
        return $result;
    }
}
