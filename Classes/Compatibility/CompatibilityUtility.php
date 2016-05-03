<?php
namespace SAV\SavLibraryKickstarter\Compatibility;

/*
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid". *
 * *
 * It is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU Lesser General Public License, either version 3 *
 * of the License, or (at your option) any later version. *
 * *
 * The TYPO3 project - inspiring people to share! *
 */

/**
 * Utility class for the compatibility
 *
 * @api
 */
class CompatibilityUtility
{

    /**
     * Adds a directory version according to the TYPO3 version
     *
     * @param string|array $parameter
     *
     * @return string|array
     */
    public static function addVersion($parameter)
    {
        if (is_array($parameter)) {
            $output = array();
            foreach ($parameter as $value) {
                $output[] = $value . '/' . self::getDirectoryVersion();
            }
        } else {
            $output = $parameter . '/' . self::getDirectoryVersion();
        }
        return $output;
    }

    /**
     * Gets the directory according to the TYPO3 version
     *
     * @return string
     */
    protected static function getDirectoryVersion()
    {
        if (version_compare(TYPO3_version, '7.0', '>=')) {
            return 'TYPO7x';
        } elseif (version_compare(TYPO3_version, '6.0', '>=')) {
            return 'TYPO6x';
        }
    }

    /**
     * Sets class aliases according to the TYPO3 version
     *
     * @return void
     */
    public static function setClassAliases()
    {
        if (version_compare(TYPO3_version, '6.2', '>=')) {
            class_alias('SAV\\SavLibraryKickstarter\\Compatibility\\ExtensionManagerForTypo3VersionGreaterOrEqualTo6_2', 'SAV\\SavLibraryKickstarter\\Compatibility\\ExtensionManager');
        } elseif (version_compare(TYPO3_version, '6.0', '>=')) {
            class_alias('SAV\\SavLibraryKickstarter\\Compatibility\\ExtensionManagerForTypo3VersionGreaterOrEqualTo6_0', 'SAV\\SavLibraryKickstarter\\Compatibility\\ExtensionManager');
        }
    }
}
