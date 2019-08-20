<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 8/8/19
 * Time: 2:53 PM
 */

use \App\Generators\IntegerGenerator;

class IntegerGeneratorTest extends TestCase
{
    private $obj;

    public function badTestParams()
    {
        return [
            [0, UnexpectedValueException::class],
            [20, UnexpectedValueException::class],
            ['bad_type', TypeError::class]
        ];
    }

    public function setUp(): void
    {
        $this->obj = new IntegerGenerator();
    }

    public function testGoodGenerator()
    {
        $this->obj->setLength(10);
        $value = $this->obj->generate();
        $this->assertIsInt($value);
    }

    /**
     * @dataProvider badTestParams
     * @param $length
     * @param $exception
     */
    public function testBadGenerator($length, $exception)
    {
        $this->expectException($exception);
        $this->obj->setLength($length);
    }
}