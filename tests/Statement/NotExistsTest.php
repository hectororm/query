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

namespace Hector\Query\Tests\Statement;

use Hector\Connection\Bind\BindParamList;
use Hector\Query\Statement\NotExists;
use PHPUnit\Framework\TestCase;

class NotExistsTest extends TestCase
{
    public function testGetStatement()
    {
        $exists = new NotExists('SELECT 1');
        $binds = new BindParamList();

        $this->assertEquals('NOT EXISTS( SELECT 1 )', $exists->getStatement($binds));
        $this->assertEmpty($binds);
    }

    public function testGetStatementWithEncapsulation()
    {
        $exists = new NotExists('SELECT 1');
        $binds = new BindParamList();

        $this->assertEquals('NOT EXISTS( SELECT 1 )', $exists->getStatement($binds, true));
        $this->assertEmpty($binds);
    }
}
