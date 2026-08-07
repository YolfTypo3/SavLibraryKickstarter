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
 * A view helper which returns a file if its exists in the SAV Library Kickstarter
 * and the default one otherwise.
 *
 * @package SavLibraryKickstarter
 */
final class UseDefaultViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('fileName', 'string', 'File name to check', true);
        $this->registerArgument('default', 'string', 'Default file', true);
    }

    /**
     * Renders the view helper
     *
     * @return string Either the fileName if the file exits in the SAV Library Kickstarter or the defaut
     */
    public function render(): string
    {
        // Gets the arguments
        $fileName = $this->arguments['fileName'];
        $default = $this->arguments['default'];

        // Gets the path for the code templates
        $codeTemplatesPath = $this->renderingContext->getVariableProvider()->get('codeTemplatesPath');

        if (file_exists($codeTemplatesPath . $fileName)) {
            return $fileName;
        } else {
            return $default;
        }
    }
}
