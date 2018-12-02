#include <stdio.h>
#include <stdlib.h>
#include <string.h>

const int LINE_LEN = 28;

// Same thing, but this time find two ids which differ at just one character at
// one position, and then return their common chars.
char* solve(const char* filename) {
	FILE* fp_in = fopen(filename, "r");

	if (fp_in == NULL) {
    printf("Can't open file %s", filename);
    exit(0);
  }

  char id[LINE_LEN];
  while (fgets(id, LINE_LEN, fp_in)) {
		
	}

	return "";
}

int main(int argc, char const *argv[])
{
	char* answer = solve(argv[1]);

	printf("%s", answer);

	return 0;
}
