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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper to manage the subforms.
 *
 * @package SavLibraryKickstarter
 */
final class SubformIndexManagerViewHelper extends AbstractViewHelper
{

    protected static int $count = 0;

    protected static bool $used = false;

    protected static array $subforms = [];

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('field', 'array', 'Field', false, null);
        $this->registerArgument('action', 'string', 'Action', false, null);
        $this->registerArgument('tableName', 'string', 'Table name', false, '');
    }

    /**
     * Renders the view helper
     *
     * @return mixed
     */
    public function render(): mixed
    {
        // Gets the arguments
        $field = $this->arguments['field'];
        $action = $this->arguments['action'];
        $tableName = $this->arguments['tableName'];

        if ($field === null) {
            $field = $this->renderChildren();
        }

        if ($action === null) {
            if ($field !== null) {
                // Extracts the short model name from the field conf_rel_table
                $shortModelName = preg_replace('/^tx_\w+_domain_model_(\w+)$/', '$1', $field['conf_rel_table']);
                $shortModelName = GeneralUtility::underscoredToUpperCamelCase($shortModelName);
                $fieldName = GeneralUtility::underscoredToUpperCamelCase($field['fieldname']);
                $tableName = GeneralUtility::underscoredToUpperCamelCase($tableName);
                self::$subforms[self::$count] = [
                    'foreignTableName' => $shortModelName,
                    'fieldName' => $field['fieldname'],
                    'tableName' => $tableName
                ];
            } 
           
            self::$used = true;
            return self::$count;
        } elseif ($action == 'increment' && self::$used) {
            self::$count ++;
            self::$used = false;
            return null;
        } elseif ($action == 'getSubforms') {
            return self::$subforms;
        }
        return null;
    }
}
