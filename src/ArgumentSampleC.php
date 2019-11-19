<?php
namespace Hanhan1978\FFISamples;

class ArgumentSampleC implements ArgumentSampleInterface
{
    private string $signature = "
int argInt(int n);
double argDouble(double d);
const char* argString(const char* s);
int * argIntArray(int * arr, int size);
char ** argStringArray(char ** arr, int size);
typedef int (*callback_i)(int);
int argCallback(callback_i callback, int num);
typedef double (*callback_d)(double);
double argCallbackDouble(callback_d callback, double num);
struct animal {
    int age;
    const char *name;
};
struct animal * argStruct(struct animal *a);
";

    private function loadLibrary() :\FFI
    {
        return \FFI::cdef( $this->signature, __DIR__ . "/lib/sample.so");
    }


    public function argInt(int $num): int
    {
        $ffi = $this->loadLibrary();
        return $ffi->argInt($num);
    }

    public function argDouble(float $num) :float
    {
        $ffi = $this->loadLibrary();
        return $ffi->argDouble($num);
    }

    public function argString(string $str) :string
    {
        $ffi = $this->loadLibrary();
        return $ffi->argString($str);
    }

    public function argIntArray(array $nums) :array
    {
        $ffi = $this->loadLibrary();
        $intArr = $ffi->new("int[".count($nums)."]");
        foreach($intArr as $k => $v){
            $intArr[$k] = $nums[$k];
        }
        $retArr = $ffi->argIntArray(\FFI::addr($intArr[0]), count($nums));

        $r = [];
        for($i=0; $i<count($nums); $i++){
            array_push($r, $retArr[$i]);
        }
        \FFI::free($retArr);
        return $r;
    }

    public function argStringArray(array $strs) :array
    {
        $ffi = $this->loadLibrary();
        $arg = \FFI::new("char*[".count($strs)."]");
        foreach($strs as $k => $v){
            ${'fs_'.$k}= $this->toFFIStr($v);
            $arg[$k] = \FFI::addr(${'fs_'.$k}[0]);
        }
        $ret = $ffi->argStringArray($arg, count($strs));

        $r = [];
        for($i=0; $i<count($strs); $i++){
            array_push($r, \FFI::string($ret[$i]));
        }
        \FFI::free($ret);
        return $r;
    }

    public function argCallback(callable $f, int $num) :int
    {
        $ffi = $this->loadLibrary();
        return $ffi->argCallback($f, $num);
    }

    public function argCallbackDouble(callable $f, float $num) :float
    {
        $ffi = $this->loadLibrary();
        return $ffi->argCallbackDouble($f, $num);
    }

    public function argStruct(object $animal) :object
    {
        $ffi = $this->loadLibrary();
        $struct = $ffi->new("struct animal");
        $struct->age = $animal->age;
        $name = $this->toFFIStr($animal->name);
        $struct->name = \FFI::addr($name[0]);
        $ret = $ffi->argStruct(\FFI::addr($struct));

        $obj = new \stdClass();
        $obj->age = $ret->age;
        $obj->name = \FFI::string($ret->name);
        return $obj;
    }


    /**
     * Convert PHP string to \FFI\CData string
     *
     * @param string $str
     * @return \FFI\CData
     */
    private function toFFIStr(string $str) :\FFI\CData
    {
        $len = strlen($str);
        $chars = \FFI::new("char[".($len + 1)."]");

        for($i=0; $i<$len;$i++){
            $chars[$i] = substr($str, $i, 1);
        }
        $chars[$len] = "\0";
        return $chars;
    }
}