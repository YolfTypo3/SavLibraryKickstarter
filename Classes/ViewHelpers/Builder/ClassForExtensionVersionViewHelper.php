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
use YolfTypo3\SavLibraryKickstarter\ViewHelpers\Builder\Options\ForExtensionVersionSelectorboxViewHelper;

/**
 * A view helper for building the class for the extension version.
 *
 *
 * @package SavLibraryKickstarter
 */
final class ClassForExtensionVersionViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('extensionKey', 'string', 'Extension key', true);
        $this->registerArgument('extensionVersion', 'string', 'Extension version', true);
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
        $extensionVersion = $this->arguments['extensionVersion'];

        $options = ForExtensionVersionSelectorboxViewHelper::renderOptions($extensionKey);

        if (is_array($options) && current($options) == $extensionVersion) {
            return 'extensionVersion';
        } else {
            return 'extensionVersion NotLatest';
        }
    }
}
