
CFLAGS =
CC = gcc

all: shared

shared:
	$(CC) $(CFLAGS) -fPIC -shared -o src/lib/sample.so src/lib/sample.c

debug: CFLAGS = -g
debug: all


.PHONY: clean
clean:
	$(RM) src/lib/*.so
