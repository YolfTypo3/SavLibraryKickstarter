<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Mvc;

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
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildModelName">
 * <sav:BuildModelName />
 * </code>
 *
 * Output:
 * the model name
 *
 * @package SavLibraryKickstarter
 */
class BuildModelNameViewHelper extends AbstractViewHelper
{

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
    }

    /**
     * Renders the model name
     *
     * @return string the model name
     */
    public function render(): string
    {
        // Gets the arguments
        $tableName = $this->arguments['tableName'];
        $extension = $this->arguments['extension'];
        $removeFirstBackslash = $this->arguments['removeFirstBackslash'];

        if ($tableName === null) {
            $tableName = $this->renderChildren();
        }

        // Extracts the extension and the short model names
        $match = [];
        preg_match('/^tx_(?P<extensionName>\w+)_domain_model_(?P<shortModelName>\w+)$/', $tableName, $match);

        // Gets the extension key from the prefix
        $extensionKey = self::getExtensionKeyByPrefix('tx_' . $match['extensionName']);

        // Returns the model name
        $shortModelName = GeneralUtility::underscoredToUpperCamelCase($match['shortModelName']);
        $modelName = $extension['general'][1]['vendorName'] . '\\' . GeneralUtility::underscoredToUpperCamelCase($extensionKey) . '\\Domain\Model\\' . $shortModelName;
        if (! $removeFirstBackslash) {
            $modelName = '\\' . $modelName;
        }
        return $modelName;
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
?>

