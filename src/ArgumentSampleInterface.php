<?php
namespace Hanhan1978\FFISamples;


interface ArgumentSampleInterface {

    public function argInt(int $num) :int;

    public function argDouble(float $num) :float;

    public function argString(string $str) :string;

    public function argIntArray(array $nums) :array;

    public function argStringArray(array $strs) :array;

    public function argCallback(callable $f, int $num) :int;

    public function argCallbackDouble(callable $f, float $num) :float;

    public function argStruct(object $animal) :object;
}
