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

namespace YolfTypo3\SavLibraryKickstarter\Parser;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Template Parser
 *
 * @package SavLibraryKickstarter
 */
class WhereClauseParser
{

    const WHERE_PATTERN = '/
        (?:(?P<logicalOperator>\s+ (?i:and|or)) \s+)? (?:(?P<negation>(?i:not)) \s+)? (?P<logicalOperand>
            (?P<between> (?:\w+ \s+ (?i:between) \s+  .*? \s+ (?i:and) \s+ .+))(?=(?P>logicalOperator)) |
            (?P>between) |
            .*?(?=(?P>logicalOperator)) |
            .+
        )
    /x';


    const EXPRESSION_PATTERN = '/
        (?P<leftOperand>.*?) \s* (?P<operator>=|!=|>=|<=|>|<|\s(?i:in|contains|like|between)\s) \s*  (?P<rightOperand>
                (?P<leftBetweenOperand>.*?) \s+ (?i:and) \s+ (?P<rightBetweenOperand>.+) |
                .+
        ) |
        (?P<marker>
            @ \d+ @
        ) |
        (?P<singleOperand>
            .+
        )
    /x';

    /**
     * @var array
     */
    protected $markers;

    /**
     * Processes the where clause
     *
     * @param string $clause
     *
     * @return string
     */
    public function processWhereClause(string $clause): string
    {
        // Escapes simple quotes
        $clause = str_replace('\'', '\\\'', $clause);

        $this->markers = [];
        $index = 0;
        $match = [];
        while (preg_match('/\(([^(]*?)\)/', $clause, $match)) {
            $marker = '@' . $index ++ . '@';
            $this->markers[$marker] = $match[1];
            $clause = str_replace($match[0], $marker, $clause);
        }

        return $this->analyzeWhereClause($clause);
    }

    /**
     * Analyzes the where clause
     *
     * @param string $clause
     *
     * @return string
     */
    protected function analyzeWhereClause(string $clause): string
    {
        // Splits the clause from the logical operators
        $matchesWhere = [];
        preg_match_all(self::WHERE_PATTERN, $clause, $matchesWhere);

//         debug($matchesWhere, '$matchesWhere');

        $operands = [];
        foreach ($matchesWhere[0] as $matchKey => $match) {

            $expression = trim($matchesWhere['logicalOperand'][$matchKey]);
            // Checks if a special processing is required
            $matchesSpecialExpression = [];
            if (preg_match('/^###(?P<method>isNotGroupMember|isGroupMember)(?P<marker>@\d+@):(?P<clause>.*?)###$/', $expression, $matchesSpecialExpression)) {
                $methodParameter = $this->markers[$matchesSpecialExpression['marker']];
                $methodName = $matchesSpecialExpression['method'];
                $clause = $matchesSpecialExpression['clause'];
                $specialOperand = '($this->' . $methodName . '(\'' . $methodParameter . '\') ? ' . $this->analyzeWhereClause($clause) . ': null)';
                 array_push($operands, $specialOperand);
            } else {
                // Splits the expression from the allowed operators
                $matchesExpression = [];
                preg_match_all(self::EXPRESSION_PATTERN, $expression, $matchesExpression);

//                 debug($matchesExpression, '$matchesExpression');

                // Gets the operator
                $operator = $matchesExpression['operator'][0];
                if (!empty($matchesExpression['marker'][0])) {
                    $operator = '@';
                }

                // Processes the operator
                if (! empty($operator)) {
                    $leftHandSideOperand = trim($matchesExpression['leftOperand'][0]);
                    $rightHandSideOperand = $matchesExpression['rightOperand'][0];
                    // Checks if a special processing is required
                    if ($leftHandSideOperand == '###group_list') {
                        $groupList = str_replace('###', '', $rightHandSideOperand);
                        $groupList = $this->processGroupList($groupList, $operator);
                        $operator = 'groupList';
                    } elseif (! empty($rightHandSideOperand)) {
                        // Processes the right hand side operand
                        if ($rightHandSideOperand == '###user###') {
                            $rightHandSideOperand = '$this->getUserId()';
                        } elseif ($rightHandSideOperand == '###userGroupIds###') {
                            $rightHandSideOperand = '$this->getUserGroupIds()';
                        } elseif (strtolower($operator) == 'between') {
                            $betweenOperand[0] = $this->processRightHandSideOperand($leftHandSideOperand, $matchesExpression['leftBetweenOperand'][0]);
                            $betweenOperand[1] = $this->processRightHandSideOperand($leftHandSideOperand, $matchesExpression['rightBetweenOperand'][0]);
                        } else {
                            $rightHandSideOperand = $this->processRightHandSideOperand($leftHandSideOperand, $rightHandSideOperand);
                        }
                    }

                    switch (trim($operator)) {
                        case '=':
                            array_push($operands, '$query->equals(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')');
                            break;
                        case '!=':
                            array_push($operands, '$query->logicalNot($query->equals(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . '))');
                            break;
                        case '<':
                            array_push($operands, '$query->lessThan(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')');
                            break;
                        case '<=':
                            array_push($operands, '$query->lessThanOrEqual(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')');
                            break;
                        case '>':
                            array_push($operands, '$query->greaterThan(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')');
                            break;
                        case '>=':
                            array_push($operands, '$query->greaterThanOrEqual(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')');
                            break;
                        case 'like':
                        case 'LIKE':
                            array_push($operands, '$query->like(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')');
                            break;
                        case 'in':
                        case 'IN':
                            if ($rightHandSideOperand != '$this->getUserGroupIds()') {
                                $rightHandSideOperand = '[' . $rightHandSideOperand . ']';
                            }
                            array_push($operands, '$query->in(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')');
                            break;
                        case 'contains':
                        case 'CONTAINS':
                            array_push($operands, '$query->contains(\'' . $leftHandSideOperand . '\', ' . $rightHandSideOperand . ')');
                            break;
                        case 'between':
                        case 'BETWEEN':
                            array_push($operands, '$query->between(\'' . $leftHandSideOperand . '\', ' . $betweenOperand[0] . ', ' . $betweenOperand[1]. ')');
                            break;
                        case '@':
                            // Marker is found, call recursively with the pattern
                            $markerId = $matchesExpression['marker'][0];
                            array_push($operands, $this->analyzeWhereClause($this->markers[$markerId]));
                            break;
                        case 'groupList':
                            array_push($operands, $groupList);
                            break;
                        default:
                            throw new \Exception(sprintf(
                                'Operator "%s" is not allowed in expression.',
                                $operator
                                )
                            );
                    }
                } else {
                    // Checks if we have only one operand
                    $operand = $matchesExpression['singleOperand'][0];
                    if (!empty($operand) && empty($matchesExpression['singleOperand'][1])) {
                        $leftHandSideOperand = trim($operand);
                        array_push($operands, '$query->equals(\'' . $leftHandSideOperand . '\', 1)');
                    } else {
                        throw new \Exception(sprintf(
                            'Expression not allowed.'
                            )
                        );
                    }
                }
            }

            // Adds the logical not if needed
            if (! empty($matchesWhere['negation'][$matchKey])) {
                $rightHandSideLogicalOperand = array_pop($operands);
                array_push($operands, '$query->logicalNot(' . $rightHandSideLogicalOperand . ')');
            }

            if ($matchKey > 0) {
                switch (trim($matchesWhere['logicalOperator'][$matchKey])) {
                    case 'or':
                    case 'OR':
                        $rightHandSideLogicalOperand = array_pop($operands);
                        $leftHandSideLogicalOperand = array_pop($operands);
                        array_push($operands, '$query->logicalOr(' . $leftHandSideLogicalOperand . ', ' . $rightHandSideLogicalOperand . ')');
                        break;
                    case 'and':
                    case 'AND':
                        $rightHandSideLogicalOperand = array_pop($operands);
                        $leftHandSideLogicalOperand = array_pop($operands);
                        array_push($operands, '$query->logicalAnd(' . $leftHandSideLogicalOperand . ', ' . $rightHandSideLogicalOperand . ')');
                        break;
                }
            }
        }

        return array_pop($operands);
    }

    /**
     * Processes the right and side operand
     *
     * @param string $propertyName
     * @param string $rightHandSideOperand
     *
     * @return string
     */
    protected function processRightHandSideOperand(string $propertyName, string $rightHandSideOperand): string
    {
        // Replaces the markers
        while (preg_match('/@\d+@/', $rightHandSideOperand, $match)) {
            $marker = $this->markers[$match[0]];
            $rightHandSideOperand = str_replace($match[0], '(' . $marker . ')', $rightHandSideOperand);
        }

        $alias = GeneralUtility::underscoredToUpperCamelCase($propertyName);
        if (strpos($alias, '.') === false) {
            $rightHandSideOperand = '$this->createQuery()->statement(\'SELECT ' . $rightHandSideOperand . ' AS _localParam_\')->execute(true)[0][\'_localParam_\']';
        }
        return $rightHandSideOperand;
    }

    /**
     * Processes grouplist
     *
     * @param string $groupList
     * @param string $operator
     *
     * @return string
     */
    protected function processGroupList(string $groupList, string $operator): string
    {
        $groups = explode(',', $groupList);

        if ($operator == '=') {
            $result = '$query->logicalAnd([';
        } else {
            $result = '$query->logicalOr([';
        }

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('fe_groups')->createQueryBuilder();
        $queryBuilder->select('uid','title','subgroup')->from('fe_groups');
        $queryResult = $queryBuilder->execute();

        while ($row = $queryResult->fetch()) {
            if (in_array($row['title'], $groups)) {
                if (empty($row['subgroup'])) {
                    $groups = explode(',',$row['uid']);
                } else {
                    $groups = explode(',', $row['uid'] . ',' . $row['subgroup']);
                }
                foreach ($groups as $group ) {
                    if ($operator == '=') {
                       $result .= '$query->contains(\'usergroup\', ' . $group . '),';
                    } else {
                       $result .= '$query->logicalNot($query->contains(\'usergroup\', ' . $group . ')),';
                    }
                }
            }
        }
        // Removes the last comma and adds the fina part of the string
        $result = rtrim($result, ',') . '])';

        return $result;
    }
}
