<?php

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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Indentation ViewHelper
 */
class IndentViewHelper extends AbstractViewHelper
{

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('count', 'integer', 'Number of white space', true);
    }

    /**
     * Renders the indented content
     *
     * @return string Indented content
     */
    public function render(): string
    {
        // Gets the arguments
        $count = $this->arguments['count'];

        $childrenContent = $this->renderChildren();
        if (!is_string($childrenContent)) {
            return gettype($childrenContent);
        }
        $content = explode(chr(10), $childrenContent);
        $glue = chr(10) . str_repeat(' ', $count);
        $result = implode($glue, $content);

        return $result;
    }
}
