<?php
namespace Hanhan1978\FFISamples;


interface ArgumentSampleInterface {

//    public function noArg() :void;

    public function argInt(int $num) :int;

    public function argDouble(float $num) :float;

    public function argString(string $str) :string;

    public function argIntArray(array $nums) :array;
}
