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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Utility;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for checking if a given key is in a comma-separated list of value.
 *
 *
 * @package SavLibraryKickstarter
 */
final class InListViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('list', 'string', 'Comma-separated list of value', false, null);
        $this->registerArgument('key', 'string', 'The key to search', true);
    }

    /**
     * Renders the view helper
     *
     * @return bool
     */
    public function render(): bool
    {
        // Gets the arguments
        $list = $this->arguments['list'];
        $key = $this->arguments['key'];

        if ($list === null) {
            $list = $this->renderChildren();
        }

        $haystack = explode(',', $list ?? '');

        return in_array($key,  $haystack);
    }
}
