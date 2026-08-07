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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for building the locallang_db.xlf id.
 *
 *
 * @package SavLibraryKickstarter
 */
final class LocallangDbTransUnitIdViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
        $this->registerArgument('tableName', 'string', 'Short table name', true);
        $this->registerArgument('fieldName', 'string', 'field name', false, '');
        $this->registerArgument('isMvc', 'boolean', 'Mvc flag', false, false);
        $this->registerArgument('isExistingTable', 'boolean', 'If true the table is an existing table', false, false);
    }

    /**
     * Renders the view helper
     *
     * @return string
     */
    public function render(): string
    {
        // Gets the arguments
        $extensionKey = $this->arguments['extensionKey'];
        $tableName = $this->arguments['tableName'];
        $fieldName = $this->arguments['fieldName'];
        $isMvc = $this->arguments['isMvc'];
        $existingTable = $this->arguments['isExistingTable'];

        if (! $existingTable) {
            $domain = ($isMvc ? '_domain_model_' : ($tableName ? '_' : ''));
            $prefix = 'tx_'. str_replace('_', '', $extensionKey);
            $fieldName = ($fieldName ? '.' . $fieldName : '');
            $result = $prefix . $domain . $tableName . $fieldName;
        } else {
            $prefix = $tableName . '.' . 'tx_'. str_replace('_', '', $extensionKey);
            $fieldName = ($fieldName ? '_' . $fieldName : '');
            $result = $prefix . $fieldName;
        }

        return $result;
    }

}
