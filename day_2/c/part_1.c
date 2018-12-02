#include <stdio.h>
#include <stdlib.h>
#include <string.h>

const int LINE_LEN = 27;

int solve(const char* filename) {
	FILE* fp_in = fopen(filename, "r");

	if (fp_in == NULL) {
    printf("Can't open file %s", filename);
    exit(0);
  }

	int doubles = 0;
	int triples = 0;
  char line[LINE_LEN];
  while (fgets(line, LINE_LEN + 1, fp_in)) {
		// counts how much each letter of the alphabet happens in the line
		int counts[26];
		memset(counts, 0, 26 * sizeof(int));

		// count the letters
		for (int i = 0 ; i < LINE_LEN ; i++) {
			counts[line[i] - 97]++; // char - 97 gives number of letter of alphabet
		}

		int seen_double = 0;
		int seen_triple = 0;
		for (int i = 0 ; i < 26 ; i++) {
			if (counts[i] == 2 && !seen_double) { 
				doubles++; 
				seen_double++;
			}
			else if (counts[i] == 3 && !seen_triple) { 
				triples++; 
				seen_triple++;
			}

			if (seen_double && seen_triple) break;
		}
	}

	return doubles * triples;
}

int main(int argc, char const *argv[])
{
	int answer = solve(argv[1]);

	printf("%d", answer);

	return 0;
}
