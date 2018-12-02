/**
 * Starting from 0, execute all the math operations. 
 * Which is the first total number that we see twice?
 */

#include <stdio.h>
#include <stdlib.h>

int num_lines_in_file(FILE* fp) {
  int num_lines = 0;
  while (!feof(fp)) {
    char c = fgetc(fp);
    if (c == '\n') { num_lines++; }
  }

  rewind(fp);
  return num_lines;
}

int solve(const char* filename) {
  // open filename
  FILE *fp = fopen(filename, "r");
  if (fp == NULL) {
    printf("Can't open file %s", filename);
    exit(0);
  }

  // Allocate an array we'll use to count how many times each number is
  // encountered:
  // [25] = 0,
  // [26] = 1, 
  int size_of_nums_encountered = num_lines_in_file(fp);
  int* nums_encountered = malloc(sizeof(int) * size_of_nums_encountered);
  // Zero out the memory
  for (int i = 0 ; i < size_of_nums_encountered ; i++) {
    nums_encountered[i] = 0;
  }

  int total = 0;
  nums_encountered[0]++;
  char line[200];
  while (fgets(line, 200, fp)) {
    // Get our operation
    char op = line[0];

    // convert str to int
    int number = (int) strtol(
      (const char*) &line[1], // use the address where the digits start 
      NULL,                   // don't care about where it ends
      0                       // don't care about base
    );

    // apply the operation
    if (op == '+') {
      total += number;
    }
    else {
      total -= number;
    }

    // Record that we witnessed this point of the running total.
    nums_encountered[total]++;

    // Have we seen this total before? If so, return it.
    if (nums_encountered[total] > 1) {
      return nums_encountered[total];
    }
  }

  // This shouldn't happen.
  printf("Could not find the answer\n");
  exit(1);
}


int main(int argc, char const *argv[])
{
  int answer = solve(argv[1]);

  printf("%d", answer);

  return 0;
}
