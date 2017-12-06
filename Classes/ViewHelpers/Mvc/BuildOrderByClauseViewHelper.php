<?php
namespace YolfTypo3\SavLibraryKickstarter\ViewHelpers\Mvc;

/*
 * This script is part of the TYPO3 project - inspiring people to share! *
 * *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by *
 * the Free Software Foundation. *
 * *
 * This script is distributed in the hope that it will be useful, but *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN- *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General *
 * Public License for more details. *
 */

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
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class BuildOrderByClauseViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
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
     *
     * @param string $clause            
     *
     * @return string the processed order by clause
     */
    public function render($clause)
    {
        $out = $this->processOrderByClause($clause);
        return ($out ? '$query->setOrderings(array(' . $out . '));' : '');
    }

    /**
     * Processes the order by clause
     *
     * @param string $clause            
     * @return string the processed order by clause
     */
    public function processOrderByClause($clause)
    {
        preg_match_all(self::ORDER_BY_PATTERN, $clause, $matches);
        
        $clause = array();
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
?>

