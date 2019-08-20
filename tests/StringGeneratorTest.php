<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 8/8/19
 * Time: 2:55 PM
 */

use App\Generators\StringGenerator;

class StringGeneratorTest extends TestCase
{
    private $obj;

    public function badTestParams()
    {
        return [
            [0, UnexpectedValueException::class],
            ['bad_type', TypeError::class]
        ];
    }

    public function setUp(): void
    {
        $this->obj = new StringGenerator();
    }

    public function testGoodGenerator()
    {
        $this->obj->setLength(15);
        $value = $this->obj->generate();
        $this->assertEquals(15, strlen($value));
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