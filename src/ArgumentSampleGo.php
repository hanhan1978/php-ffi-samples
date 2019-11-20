<?php
namespace Hanhan1978\FFISamples;

class ArgumentSampleGo implements ArgumentSampleInterface
{
    private string $signature = "
extern int argInt(int p0);
extern double argDouble(double p0);
extern char* argString(char* p0);
struct animal {
    int age;
    const char * name;
};
typedef long long GoInt64;
extern struct animal* argStruct(struct animal* p0);
typedef long long GoInt64;
typedef GoInt64 GoInt;
typedef struct { void *data; GoInt len; GoInt cap; } GoSlice;
extern void* argIntArray(GoSlice p0);
";
    /*
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
    */
    private function loadLibrary() :\FFI
    {
        return \FFI::cdef( $this->signature, __DIR__ . "/lib/go-sample.so");
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
        $fs = $this->toFFIStr($str);
        $ret = $ffi->argString(\FFI::addr($fs[0]));
        return \FFI::string($ret);
    }

    public function argIntArray(array $nums) :array
    {
        $ffi = $this->loadLibrary();
        $slice = $ffi->new("GoSlice");
        $intArr = $ffi->new("GoInt[".count($nums)."]");
        for($i=0; $i<count($nums); $i++){
            $intArr[$i] = $nums[$i];
        }
        $slice->cap = count($nums);
        $slice->len = count($nums);
        $slice->data = \FFI::addr($intArr[0]);
        $ret = $ffi->argIntArray($slice);
        $retArr = \FFI::cast('int *', $ret);
        $r=[];
        for($i=0; $i<count($nums); $i++){
            array_push($r, $retArr[$i*2]);
        }
        return $r;
    }

    public function argStringArray(array $strs) :array
    {
        //TODO
        return [];
    }

    public function argCallback(callable $f, int $num) :int
    {
        //TODO
        return 0;
    }

    public function argCallbackDouble(callable $f, float $num) :float
    {
        //TODO
        return 0;
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