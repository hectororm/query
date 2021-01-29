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

namespace Hector\Query\Statement;

use Closure;
use Hector\Query\Component\IndentHelperTrait;
use Hector\Query\StatementInterface;

/**
 * Class SqlFunction.
 *
 * @package Hector\Query\Statement
 */
class SqlFunction implements StatementInterface
{
    use IndentHelperTrait;

    protected string $function;
    protected Closure|StatementInterface|string $expression;

    /**
     * SqlFunction constructor.
     *
     * @param string $function
     * @param Closure|StatementInterface|string $expression
     */
    public function __construct(string $function, Closure|StatementInterface|string $expression)
    {
        $this->function = $function;
        $this->expression = $expression;
    }

    /**
     * @inheritDoc
     */
    public function getStatement(array &$binding, bool $encapsulate = false): ?string
    {
        if ($this->expression instanceof StatementInterface) {
            return
                sprintf(
                    '%s(' . PHP_EOL .
                    rtrim($this->indent($this->expression->getStatement($binding, false))) . PHP_EOL .
                    ')' . PHP_EOL,
                    $this->function
                );
        }

        return sprintf('%s( %s )', $this->function, $this->expression);
    }
}