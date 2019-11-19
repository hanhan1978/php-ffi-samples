#include <stdio.h>
#include <unistd.h>
#include <string.h>
#include <stdlib.h>


int argInt(int n){
    return n;
}

double argDouble(double d){
    return d;
}

const char* argString(const char* s){
    char* str = (char*)malloc(sizeof(char) * strlen(s));
    strcpy(str, s);
    return str;
}

int * argIntArray(int * arr, int size){
    int *ret = malloc(sizeof(int) * size);
    for(int i=0; i<size; i++){
        ret[i] = arr[i];
    }
    return ret;
}


char ** argStringArray(char ** arr, int size){

    char **retArr;
    retArr = malloc(size * sizeof(char *));
    for(int i=0; i<size; i++){
        retArr[i] = malloc(strlen(arr[i]));
        strcpy(retArr[i], arr[i]);
    }
    return retArr;
}

typedef int (*callback_i)(int);
int argCallback(callback_i callback, int num)
{
    return callback(num);
}

typedef double (*callback_d)(double);
double argCallbackDouble(callback_d callback, double num)
{
    return callback(num);
}


struct animal {
    int age;
    const char *name;
};

struct animal * argStruct(struct animal *a){
    return a;
}