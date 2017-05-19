<?php
namespace SAV\SavLibraryKickstarter\ViewHelpers\Mvc;

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
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildTableName">
 * <sav:BuildTableName />
 * </code>
 *
 * Output:
 * the oprtions
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class BuildModelNameViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     *
     * @param string $tableName
     * @param array $extension
     * @param boolean $removeFirstBackslash
     * @return string the model name
     */
    public function render($tableName = NULL, $extension = NULL, $removeFirstBackslash= FALSE)
    {
        if ($tableName === NULL) {
            $tableName = $this->renderChildren();
        }

        // Extracts the extension and the short model names
        preg_match('/^tx_(?P<extensionName>\w+)_domain_model_(?P<shortModelName>\w+)$/', $tableName, $match);

        // Finds the extension key
        $extensionKey = ExtensionManagementUtility::getExtensionKeyByPrefix($tableName);

        // Returns the model name
        $shortModelName = GeneralUtility::underscoredToUpperCamelCase($match['shortModelName']);
        $modelName = $extension['general'][1]['vendorName'] . '\\' . GeneralUtility::underscoredToUpperCamelCase($extensionKey) . '\\Domain\Model\\' . $shortModelName;
        if (!$removeFirstBackslash) {
            $modelName = '\\' . $modelName;
        }
        return $modelName;
    }
}
?>

