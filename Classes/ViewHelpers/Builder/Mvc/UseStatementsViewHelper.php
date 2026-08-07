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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for to build the use statements.
 *
 *
 * @package SavLibraryKickstarter
 */
final class UseStatementsViewHelper extends AbstractViewHelper
{
    /**
     * Use statements
     * @var array
     */
    protected static array $useStatements = [];
    
    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('action', 'string', 'The action', true, null);
        $this->registerArgument('use', 'string', 'Use statement to add', false, null);
    }

    /**
     * Renders the view helper
     *
     * @return string The use statements
     */
    public function render(): string
    {
        
        // Gets the arguments
        $action = $this->arguments['action'];
        $use = $this->arguments['use'];
        if ($use === null) {
            $use = $this->renderChildren();
        }
        if ($action == 'add') {
            foreach(explode(';', $use) as $statement) {
                if (!empty($statement) && !in_array(trim($statement) . ';', self::$useStatements)){
                    self::$useStatements[] = trim($statement) . ';';
                }
            }
            return '';
        } elseif ($action == 'render') {
            sort(self::$useStatements);
            $result = implode(chr(10), self::$useStatements);
            self::$useStatements = [];
            return $result;
        }
        return '';
    }

}
