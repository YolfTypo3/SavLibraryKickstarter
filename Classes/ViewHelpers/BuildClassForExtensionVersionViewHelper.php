<?php
namespace SAV\SavLibraryKickstarter\ViewHelpers;

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

use SAV\SavLibraryKickstarter\ViewHelpers\BuildOptionsForExtensionVersionSelectorboxViewHelper;

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
 * @subpackage ViewHelpers
 */
class BuildClassForExtensionVersionViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $extensionKey            
     * @param string $extensionVersion            
     * @return string the class
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($extensionKey, $extensionVersion)
    {
        $options = BuildOptionsForExtensionVersionSelectorboxViewHelper::render($extensionKey);
        
        if (is_array($options) && current($options) == $extensionVersion) {
            return 'extensionVersion';
        } else {
            return 'extensionVersion NotLatest';
        }
    }
}
?>

