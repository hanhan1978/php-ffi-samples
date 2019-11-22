package main

/*
struct animal {
    int age;
    const char * name;
};
*/
import "C"
import "unsafe"

/**
go build -buildmode=c-shared -o goarg.so goarg.go
**/

//export argInt
func argInt(i int64) int64 {
	return i
}

//export argDouble
func argDouble(d float64) float64 {
	return d
}

//export argString
func argString(s *C.char) *C.char {
	return C.CString(C.GoString(s))
}

//export argStruct
func argStruct(c *C.struct_animal) *C.struct_animal {
	return c
}

//export argIntArray
func argIntArray(s []int) unsafe.Pointer {
	return unsafe.Pointer(&s[0])
}

func main() {}
