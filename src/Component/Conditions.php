<?php
/*
 * This file is part of Hector ORM.
 *
 * @license   https://opensource.org/licenses/MIT MIT License
 * @copyright 2021 Ronan GIRON
 * @author    Ronan GIRON <https://github.com/ElGigi>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code, to the root.
 */

declare(strict_types=1);

namespace Hector\Query\Component;

use Closure;
use Countable;
use Hector\Query\Select;
use Hector\Query\StatementInterface;

/**
 * Class Conditions.
 *
 * @package Hector\Query\Component
 */
class Conditions extends AbstractComponent implements Countable
{
    public const LINK_AND = 'AND';
    public const LINK_OR = 'OR';

    private array $conditions = [];

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->conditions);
    }

    /**
     * Merge columns.
     *
     * @param Conditions $conditions
     */
    public function merge(Conditions $conditions): void
    {
        array_push($this->conditions, ...$conditions->conditions);
    }

    /**
     * Add equal.
     *
     * @param Closure|StatementInterface|string $column
     * @param mixed $value
     * @param string $link
     */
    public function equal(
        Closure|StatementInterface|string $column,
        mixed $value,
        string $link = Conditions::LINK_AND
    ): void {
        $operator = '=';
        if (is_array($value) || $value instanceof Select) {
            $operator = 'IN';
        }

        $this->add($column, $operator, $value, $link);
    }

    /**
     * Add equals.
     *
     * @param array $conditions
     */
    public function equals(array $conditions): void
    {
        foreach ($conditions as $key => $value) {
            if (is_int($key)) {
                if ($value instanceof Conditions) {
                    $this->merge($value);
                    continue;
                }

                $this->add($value);
                continue;
            }

            $this->equal($key, $value);
        }
    }

    /**
     * Add column.
     *
     * @param Closure|StatementInterface|string $column
     * @param string|null $operator
     * @param mixed $value
     * @param string $link
     */
    public function add(
        Closure|StatementInterface|string $column,
        ?string $operator = null,
        mixed $value = null,
        string $link = Conditions::LINK_AND
    ): void {
        $this->conditions[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'link' => $link,
        ];
    }

    /**
     * @inheritDoc
     */
    public function getStatement(array &$binding, bool $encapsulate = false): ?string
    {
        if (empty($this->conditions)) {
            return null;
        }

        $statement = '';

        for ($iCondition = 0; $iCondition < count($this->conditions); $iCondition++) {
            $condition = $this->conditions[$iCondition];

            if (null === ($subStatement = $this->getSubStatement($condition['column'], $binding, true))) {
                continue;
            }

            if (!empty($statement)) {
                $statement .= $condition['link'] . ' ';
            }

            $statement .= $subStatement;

            if (null === $condition['operator']) {
                $statement .= PHP_EOL;
                continue;
            }

            if (null !== $condition['value']) {
                $statement .=
                    ' ' . $condition['operator'] . ' ' .
                    $this->getSubStatementValue($condition['value'], $binding, true) . PHP_EOL;
                continue;
            }

            if (null === $condition['value']) {
                $statement .= ' IS NULL' . PHP_EOL;
                continue;
            }
        }

        if (empty($statement)) {
            return null;
        }

        if ($encapsulate) {
            return
                $this->indent(
                    '(' . PHP_EOL .
                    $this->indent($statement) .
                    ')' . PHP_EOL
                );
        }

        return $this->indent($statement);
    }
}