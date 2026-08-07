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
 * A view helper to check if there are new fields created in an existing table.
 *
 * = Examples =
 *
 * <code title="CheckIfNewFieldsAreCreatedInExistingTable">
 * <sav:CheckIfNewFieldsAreCreatedInExistingTable existingTable="existingTable"/>
 * </code>
 *
 * Output:
 * true or false
 *
 * @package SavLibraryKickstarter
 */
final class CheckIfNewFieldsAreCreatedInExistingTableViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('existingTable', 'array', 'Existing table array', true);
    }

    /**
     * Renders the view helper
     *
     * @return bool
     */
    public function render(): bool
    {
        // Gets the arguments
        $existingTable = $this->arguments['existingTable'];

        foreach ($existingTable['fields'] as $field) {
            if ($field['type'] != 'ShowOnly') {
                return true;
            }
        }
        return false;
    }
}
