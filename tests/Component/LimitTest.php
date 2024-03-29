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

namespace Hector\Query\Tests\Component;

use Hector\Connection\Bind\BindParamList;
use Hector\Query\Component\Limit;
use PHPUnit\Framework\TestCase;

class LimitTest extends TestCase
{
    public function testGetStatement()
    {
        $limit = new Limit();
        $binds = new BindParamList();

        $this->assertNull($limit->getOffset());
        $this->assertNull($limit->getLimit());
        $this->assertNull($limit->getStatement($binds));
        $this->assertEmpty($binds);
    }

    public function testSetOffset()
    {
        $limit = new Limit();
        $limit->setOffset(5);
        $binds = new BindParamList();

        $this->assertEquals(5, $limit->getOffset());
        $this->assertNull($limit->getStatement($binds));
        $this->assertEmpty($binds);
    }

    public function testSetLimit()
    {
        $limit = new Limit();
        $limit->setLimit(10);
        $binds = new BindParamList();

        $this->assertEquals(10, $limit->getLimit());
        $this->assertEquals('LIMIT 10', $limit->getStatement($binds));
        $this->assertEmpty($binds);
    }

    public function testSetLimitWithOffset()
    {
        $limit = new Limit();
        $limit->setLimit(10);
        $limit->setOffset(5);
        $binds = new BindParamList();

        $this->assertEquals('LIMIT 10 OFFSET 5', $limit->getStatement($binds));
        $this->assertEmpty($binds);
    }
}
