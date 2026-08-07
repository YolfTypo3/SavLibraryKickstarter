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
use YolfTypo3\SavLibraryKickstarter\Parser\WhereClauseParser;

/**
 * A view helper for building the where clause for the where tags.
 *
 *
 * @package SavLibraryKickstarter
 */
final class WhereClauseViewHelper extends AbstractViewHelper
{
    
    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        $this->registerArgument('clause', 'string', 'Clause', true);
    }

    /**
     * Renders the view helper
     *
     * @return string
     */
    public function render(): string
    {
        // Gets the arguments
        $clause = $this->arguments['clause'];

        // Replaces the contents between parentheses by markers
        $whereClauseParser = GeneralUtility::makeInstance(WhereClauseParser::class);

        $out = $whereClauseParser->processWhereClause($clause);

        return ($out ? $out : 'null');
    }
}
