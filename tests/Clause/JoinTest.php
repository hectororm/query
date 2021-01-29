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

namespace Hector\Query\Tests\Clause;

use Hector\Query\Clause\Join;
use PHPUnit\Framework\TestCase;

class JoinTest extends TestCase
{
    public function testResetJoin()
    {
        $clause = new class {
            use Join;
        };
        $binding = [];
        $clause->resetJoin();

        $this->assertEmpty($clause->join->getStatement($binding));

        $clause->innerJoin('foo');

        $this->assertNotEmpty($clause->join->getStatement($binding));

        $clause->resetJoin();

        $this->assertEmpty($clause->join->getStatement($binding));
    }

    public function testInnerJoin()
    {
        $clause = new class {
            use Join;
        };
        $binding = [];
        $clause->resetJoin();
        $clause->innerJoin('foo', 'foo.bar IS NULL');
        $clause->innerJoin('baz');

        $this->assertEquals(
            'INNER JOIN foo' . PHP_EOL .
            '    ON ( foo.bar IS NULL )' . PHP_EOL .
            'INNER JOIN baz' . PHP_EOL,
            $clause->join->getStatement($binding)
        );
        $this->assertEmpty($binding);
    }

    public function testLeftJoin()
    {
        $clause = new class {
            use Join;
        };
        $binding = [];
        $clause->resetJoin();
        $clause->leftJoin('foo', 'foo.bar IS NULL');
        $clause->leftJoin('baz');

        $this->assertEquals(
            'LEFT JOIN foo' . PHP_EOL .
            '    ON ( foo.bar IS NULL )' . PHP_EOL .
            'LEFT JOIN baz' . PHP_EOL,
            $clause->join->getStatement($binding)
        );
        $this->assertEmpty($binding);
    }

    public function testRightJoin()
    {
        $clause = new class {
            use Join;
        };
        $binding = [];
        $clause->resetJoin();
        $clause->rightJoin('foo', 'foo.bar IS NULL');
        $clause->rightJoin('baz');

        $this->assertEquals(
            'RIGHT JOIN foo' . PHP_EOL .
            '    ON ( foo.bar IS NULL )' . PHP_EOL .
            'RIGHT JOIN baz' . PHP_EOL,
            $clause->join->getStatement($binding)
        );
        $this->assertEmpty($binding);
    }

    public function testJoinWithArrayConditions()
    {
        $clause = new class {
            use Join;
        };
        $binding = [];
        $clause->resetJoin();
        $clause->innerJoin('table', ['foo.bar IS NULL', 'baz' => 'qux']);
        $clause->rightJoin('baz');

        $this->assertEquals(
            'INNER JOIN table' . PHP_EOL .
            '    ON ( foo.bar IS NULL AND baz = qux )' . PHP_EOL .
            'RIGHT JOIN baz' . PHP_EOL,
            $clause->join->getStatement($binding)
        );
        $this->assertEmpty($binding);
    }

    public function testInnerJoinWithAlias()
    {
        $clause = new class {
            use Join;
        };
        $binding = [];
        $clause->resetJoin();
        $clause->innerJoin('foo', 'alias.bar IS NULL', 'alias');

        $this->assertEquals(
            'INNER JOIN foo AS alias' . PHP_EOL .
            '    ON ( alias.bar IS NULL )' . PHP_EOL,
            $clause->join->getStatement($binding)
        );
        $this->assertEmpty($binding);
    }
}
