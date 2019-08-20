<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 8/8/19
 * Time: 2:35 PM
 */

use \App\Generators\AlphanumericGenerator;

class AlphanumericGeneratorTest extends TestCase
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
        $this->obj = new AlphanumericGenerator();
    }

    public function testGoodGenerator()
    {
        $this->obj->setLength(10);
        $value = $this->obj->generate();
        $this->assertRegExp("/[a-zA-Z0-9]{10}/", $value);
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