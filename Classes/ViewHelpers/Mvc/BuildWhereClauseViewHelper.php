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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * A view helper for building the options for the field type selector.
 *
 * = Examples =
 *
 * <code title="BuildTableName">
 * <sav:BuildTableName />
 * </code>
 *
 * Output:
 * the oprtions
 *
 * @package SavLibraryKickstarter
 * @subpackage ViewHelpers
 * @author Laurent Foulloy <yolf.typo3@orange.fr>
 * @version $Id:
 */
class BuildWhereClauseViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    const WHERE_PATTERN = '/
    (?:
      (?:
        (?:(?P<logicalOperator>\s+ (?i:and|or)) \s+)? (?:(?P<negation>(?i:not)) \s+)? (?P<logicalOperand>(?P>expression))
      ) |
      (?P<expression>
        .*?(?=(?P>logicalOperator))|
        .+
      )
    )
  /x';

    const EXPRESSION_PATTERN = '/
    (?:
      (?:
        (?:\s* (?P<operator>=|!=|>=|<=|>|<|(?i:\sin\s)|(?i:\slike\s)) \s*)?  (?P<operand>(?P<term>(?P>expression))(?P<marker>\# \d+ \#) | (?P>expression))
      ) |
      (?P<expression>
        [^\#]+?(?=(?P>operator))|
        [^\#]+
      )
    )
  /x';

    /**
     *
     * @var array
     *
     */
    protected $patterns;

    /**
     *
     * @param string $clause
     *
     * @return string the processed where clause
     */
    public function render($clause)
    {
        // Replaces the contents between parentheses by markers
        $this->patterns = array();
        $index = 0;
        while (preg_match('/\(([^(]*?)\)/', $clause, $match)) {
            $marker = '#' . $index ++ . '#';
            $this->patterns[$marker] = $match[1];
            $clause = str_replace($match[0], $marker, $clause);
        }
        $out = $this->processWhereClause($clause);

        return ($out ? $out : 'null');
    }

    /**
     * Process the where clause
     *
     * @param string $clause
     * @return string the processed where clause
     */
    public function processWhereClause($clause)
    {
        // Splits the clause from the logical operators
        preg_match_all(self::WHERE_PATTERN, $clause, $matchesWhere);
        foreach ($matchesWhere[0] as $matchKey => $match) {
            if ($matchKey > 0) {
                $leftHandSideLogicalOperand = $result;
                $logicalOperator = '$query->logical' . GeneralUtility::underscoredToUpperCamelCase($matchesWhere['logicalOperator'][$matchKey]);
            }
            $rightHandSideLogicalOperand = trim($matchesWhere['logicalOperand'][$matchKey]);

            // Splits the operand from the allowed operators
            preg_match_all(self::EXPRESSION_PATTERN, $rightHandSideLogicalOperand, $matchesExpression);

            // Gets the left hand side - it must be a field name
            $leftHandSideOperand = (empty($matchesExpression['marker'][0]) ? trim($matchesExpression['operand'][0]) : trim($matchesExpression['term'][0]) . '(' . $this->processWhereClause($this->patterns[trim($matchesExpression['marker'][0])]). ')');

            // Gets the right hand side
            $rightHandSideOperand = '';
            foreach($matchesExpression[0]  as $matchExpressionKey => $matchExpression) {
                if ($matchExpressionKey > 0) {
                    $rightHandSideOperand .= (empty($matchesExpression['marker'][$matchExpressionKey]) ? trim($matchesExpression['operand'][$matchExpressionKey]) :  trim($matchesExpression['term'][$matchExpressionKey]) . '(' . $this->processWhereClause($this->patterns[trim($matchesExpression['marker'][$matchExpressionKey])]) . ')');
                }
             }

            // Processes the operator
            if (isset($matchesExpression['operator'][1])) {
                $rightHandSideOperand = '$this->createQuery()->statement(\'SELECT ' . $rightHandSideOperand . ' AS ' . $leftHandSideOperand . '\')->execute()[0]->get' .GeneralUtility::underscoredToUpperCamelCase($leftHandSideOperand) . '()';
                switch (trim($matchesExpression['operator'][1])) {
                    case '=':
                        $rightHandSideLogicalOperand = '$query->equals(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')';
                        break;
                    case '!=':
                        $rightHandSideLogicalOperand = '$query->logicalNot($query->equals(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . '))';
                        break;
                    case '<':
                        $rightHandSideLogicalOperand = '$query->lessThan(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')';
                        break;
                    case '<=':
                        $rightHandSideLogicalOperand = '$query->lessThanOrEqual(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')';
                        break;
                    case '>':
                        $rightHandSideLogicalOperand = '$query->greaterThan(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')';
                        break;
                    case '>=':
                        $rightHandSideLogicalOperand = '$query->greaterThanOrEqual(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')';
                        break;
                    case 'like':
                        $rightHandSideLogicalOperand = '$query->like(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')';
                        break;
                    case 'in':
                        $rightHandSideLogicalOperand = '$query->in(\'' . $leftHandSideOperand . '\', array(' . $rightHandSideOperand . '))';
                        break;
                    case '':
                        $rightHandSideLogicalOperand = '\'' . $leftHandSideOperand . '\'';
                        break;
                }
            } else {
                $rightHandSideLogicalOperand =  $leftHandSideOperand;
            }

            // Adds the logical not if needed
            if (! empty($matchesWhere['negation'][$matchKey])) {
                $rightHandSideLogicalOperand = '$query->logicalNot(' . $rightHandSideLogicalOperand . ')';
            }

            if ($matchKey > 0) {
                $result = $logicalOperator . '(' . $leftHandSideLogicalOperand . ',' . $rightHandSideLogicalOperand . ')';
            } else {
                $result = $rightHandSideLogicalOperand;
            }
        }

        return $result;
    }
}
?>

