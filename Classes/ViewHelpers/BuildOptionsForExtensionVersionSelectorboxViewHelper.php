<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

/*
 * This script is part of the TYPO3 project - inspiring people to share! *
 * *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by *
 * the Free Software Foundation. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General *
 * Public License for more details. *
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;
use YolfTypo3\SavLibraryKickstarter\Configuration\ConfigurationManager;

/**
 * A view helper for building the options for the extension version.
 *
 * = Examples =
 *
 * <code title="BuildOptionsForExtensionVersionSelectorbox">
 * <sav:BuildOptionsForExtensionVersionSelectorbox />
 * </code>
 *
 * Output:
 * the options
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 */
class BuildOptionsForExtensionVersionSelectorboxViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $extensionKey            
     * @return string the options array
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public static function render($extensionKey)
    {
        $extensionDirectory = ConfigurationManager::getExtensionDir($extensionKey);
        $libraryName = trim(GeneralUtility::getURL(ConfigurationManager::getLibraryTypeFileName($extensionKey)));
        
        $configurationDirectory = $extensionDirectory . ConfigurationManager::CONFIGURATION_DIRECTORY . $libraryName;
        
        $configurationFilename = pathinfo(ConfigurationManager::CONFIGURATION_FILE_NAME);
        
        $options = array();
        if ($handle = opendir($configurationDirectory)) {
            
            while (false !== ($file = readdir($handle))) {
                
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
?>

