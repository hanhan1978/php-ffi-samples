<?php
namespace Hanhan1978\FFISamples;

class ArgumentSampleC implements ArgumentSampleInterface
{
    private string $signature = "
int argInt(int n);
double argDouble(double d);
const char* argString(const char* s);
int * argIntArray(int * arr, int size);
void argStringArray(char ** arr, int size);
typedef int (*callback_i)(int);
void argCallback(callback_i callback);
struct animal {
    int age;
    const char *type;
};
void argStruct(struct animal *a);
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


}