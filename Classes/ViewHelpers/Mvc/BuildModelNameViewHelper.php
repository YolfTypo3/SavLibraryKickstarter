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
     * @return string the model name
     */
    public function render($tableName = NULL, $extension = NULL)
    {
        if ($tableName === NULL) {
            $tableName = $this->renderChildren();
        }
        
        $shortModelName = preg_replace('/^tx_\w+_domain_model_(\w+)$/', '$1', $tableName);
        $shortModelName = GeneralUtility::underscoredToUpperCamelCase($shortModelName);
        $modelName = '\\' . $extension['general'][1]['vendorName'] . '\\' . GeneralUtility::underscoredToUpperCamelCase($extension['general'][1]['extensionKey']) . '\\Domain\Model\\' . $shortModelName;
        return $modelName;
    }
}
?>

