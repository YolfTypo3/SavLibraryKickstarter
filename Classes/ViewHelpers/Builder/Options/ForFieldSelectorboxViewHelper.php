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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Options;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for building the options for the field selector.
 *
 *
 * @package SavLibraryKickstarter
 */
final class ForFieldSelectorboxViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('fields', 'array', 'Fields', true);
        $this->registerArgument('options', 'array', 'Intitial option values', false, []);
        $this->registerArgument('keyAsValue', 'bool', 'Use the key of the field array as value', false, false);
    }

    /**
     * Renders the view helper
     *
     * @return array
     */
    public function render(): array
    {
        // Gets the arguments
        $fields = $this->arguments['fields'];
        $options = $this->arguments['options'];
        $keyAsValue = $this->arguments['keyAsValue'];

        if (is_array($fields)) {

            foreach ($fields as $fieldKey => $field) {
                $key = ($keyAsValue ? $fieldKey : $field['fieldname']);
                $options = array_merge($options, [
                    $key => $field['fieldname']
                ]);
            }
        }

        return $options;
    }
}
