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


void argStringArray(char ** arr, int size){

    printf("Argument is string array[%d]\n", size);
    for(int i=0; i<size; i++){
        printf("  arr[%d] => %s\n", i, arr[i]);
    }
}

typedef int (*callback_i)(int);
void argCallback(callback_i callback)
{
    printf("Argument is int-int callback, 2*2 result => %d\n", callback(2));
}


struct animal {
    int age;
    const char *type;
};

void argStruct(struct animal *a){
    printf("Argument is struct animal\n");
    printf("  age => %d\n", a->age);
    printf("  type => %s\n", a->type);

}