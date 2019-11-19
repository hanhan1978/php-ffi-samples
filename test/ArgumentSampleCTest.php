<?php

use Hanhan1978\FFISamples\ArgumentSampleC;

class ArgumentSampleCTest extends \PHPUnit\Framework\TestCase
{

    private ArgumentSampleC $obj;

    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->obj = new \Hanhan1978\FFISamples\ArgumentSampleC();
    }

    /**
     * @test
     */
    public function argInt()
    {
        $this->assertSame(4, $this->obj->argInt(4));
    }

    /**
     * @test
     */
    public function argDouble()
    {
        $this->assertSame(0.001, $this->obj->argDouble(0.001));
    }

    /**
     * @test
     */
    public function argString()
    {
        $this->assertSame("あいうえお", $this->obj->argString("あいうえお"));

    }

    /**
     * @test
     */
    public function argIntArray()
    {
        $arr = [1,3,4,5];
        $this->assertSame($arr, $this->obj->argIntArray($arr));
    }

    /**
     * @test
     */
    public function argStringArray()
    {
        $arr = ['abcde', '12345', 'あいうえお'];
        $this->assertSame($arr, $this->obj->argStringArray($arr));
    }

    /**
     * @test
     */
    public function argCallback()
    {
        $this->assertSame(16, $this->obj->argCallback(fn($i) => $i*2, 8));
    }

    /**
     * @test
     */
    public function argStruct()
    {
        $animal = new Class {public $age = 9; public $name = 'hanhan';};
        $ret = $this->obj->argStruct($animal);
        $this->assertSame($animal->age, $ret->age);
        $this->assertSame($animal->name, $ret->name);
    }


    /**
     * @test
     */
    public function argCallbackDouble()
    {
        $this->assertSame(0.12, $this->obj->argCallbackDouble(fn($i) => $i/25, 3));
    }
}