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

use Hector\Query\StatementInterface;

/**
 * Class Raw.
 *
 * @package Hector\Query\Statement
 */
class Raw implements StatementInterface
{
    private string $expression;
    private array $binds;

    /**
     * Raw constructor.
     *
     * @param string $expression
     * @param array $binds
     */
    public function __construct(string $expression, array $binds = [])
    {
        $this->expression = $expression;
        $this->binds = $binds;
    }

    /**
     * @inheritDoc
     */
    public function getStatement(array &$binding, bool $encapsulate = false): ?string
    {
        array_push($binding, ...$this->binds);

        return $this->expression;
    }
}