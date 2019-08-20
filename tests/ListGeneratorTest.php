<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 8/8/19
 * Time: 2:57 PM
 */

use App\Generators\ListGenerator;

class ListGeneratorTest extends TestCase
{
    private $obj;

    public function setUp(): void
    {
        $this->obj = new ListGenerator();
    }

    public function testGoodGenerator()
    {
        $list = ['a', 'b', 'c'];
        $this->obj->setList($list);
        $value = $this->obj->generate();
        $this->assertTrue(in_array($value, $list));
    }

    public function testBadGenerator()
    {
        $this->expectException(TypeError::class);
        $this->obj->setList('bad_type');
    }
}