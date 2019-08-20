<?php

use App\Generators\GuidGenerator;

class GuidGeneratorTest extends TestCase
{
    private $obj;

    public function setUp(): void
    {
        $this->obj = new GuidGenerator();
    }

    public function testGenerator()
    {
        $value = $this->obj->generate();
        $this->assertRegExp('/[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{16}/', $value);
    }
}