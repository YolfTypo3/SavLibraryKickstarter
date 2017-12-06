<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Mvc;

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
 * A view helper to manage the subforms.
 *
 *
 * @package SavLibraryKickstarter
 */
class SubformIndexManagerViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    protected static $count = 0;

    protected static $used = FALSE;

    protected static $subforms = array();

    /**
     *
     * @param array $field
     * @param string $action
     * @param string $tableName
     * @return integer
     * @author Laurent Foulloy <yolf.typo3@orange.fr>
     */
    public function render($field = NULL, $action = NULL, $tableName = NULL)
    {
        if ($field === NULL) {
            $field = $this->renderChildren();
        }

        if ($action === NULL) {
            if ($field !== NULL) {

                // Extracts the short model name from the field conf_rel_table
                $shortModelName = preg_replace('/^tx_\w+_domain_model_(\w+)$/', '$1', $field['conf_rel_table']);
                $shortModelName = GeneralUtility::underscoredToUpperCamelCase($shortModelName);
                $fieldName = GeneralUtility::underscoredToUpperCamelCase($field['fieldname']);
                $tableName = GeneralUtility::underscoredToUpperCamelCase($tableName);
                self::$subforms[self::$count] = array (
                    'foreignTableName' => $shortModelName,
                    'fieldName' => $field['fieldname'],
                    'tableName' => $tableName
                );
            }
            self::$used = TRUE;
            return self::$count;
        } elseif ($action == 'increment' && self::$used) {
            self::$count ++;
            self::$used = FALSE;
        } elseif ($action == 'getSubforms') {
            return self::$subforms;
        }
    }
}
?>

