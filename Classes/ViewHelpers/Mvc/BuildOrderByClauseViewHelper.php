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

namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Mvc;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * A view helper for building the order by clause for the where tags.
 *
 * = Examples =
 *
 * <code title="BuildOrderByClause">
 * <sav:BuildOrderByClause />
 * </code>
 *
 * Output:
 * the oprtions
 *
 * @package SavLibraryKickstarter
 */
class BuildOrderByClauseViewHelper extends AbstractViewHelper
{

    const ORDER_BY_PATTERN = '/
    (?:
      (?:\s*,\s*)?
      (?P<clause>
        (?P<property>(?:(?:\w+\.)+)?\w+)
        (?i:\s+
          (?P<modifier>asc|desc)
        )?
      )
    )
  /x';

    /**
     * Initializes arguments.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('clause', 'string', 'Clause', true);
    }

    /**
     * Renders the order by clause
     *
     * @return string the processed order by clause
     */
    public function render(): string
    {
        // Gets the arguments
        $clause = $this->arguments['clause'];

        $out = $this->processOrderByClause($clause);
        return ($out ? '$query->setOrderings([' . $out . ']);' : '');
    }

    /**
     * Processes the order by clause
     *
     * @param string $clause
     *
     * @return string the processed order by clause
     */
    protected function processOrderByClause(string $clause): string
    {
        $matches = [];
        preg_match_all(self::ORDER_BY_PATTERN, $clause, $matches);

        $clause = [];
        foreach ($matches['property'] as $matchKey => $match) {
            $modifier = strtolower($matches['modifier'][$matchKey]);
            switch ($modifier) {
                case 'asc':
                case '':
                    $clause[] = '\'' . $match . '\' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING';
                    break;
                case 'desc':
                    $clause[] = '\'' . $match . '\' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING';
                    break;
            }
        }

        return implode(',' . chr(10), $clause);
    }
}
