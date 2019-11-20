
CFLAGS =
CC = gcc

all: shared shared-go

shared:
	$(CC) $(CFLAGS) -fPIC -shared -o src/lib/sample.so src/lib/sample.c

shared-go:
	go build -buildmode=c-shared -o src/lib/go-sample.so src/lib/go-sample.go

debug: CFLAGS = -g
debug: all


.PHONY: clean
clean:
	$(RM) src/lib/*.so
	$(RM) src/lib/*.h
