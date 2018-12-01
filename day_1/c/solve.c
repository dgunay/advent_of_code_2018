/**
 * Starting from 0, execute all the math operations. What's the result?
 */

#include <stdio.h>
#include <stdlib.h>

int solve(const char* filename) {
  // open filename
  FILE *fp = fopen(filename, "r");
  if (fp == NULL) {
    printf("Can't open file %s", filename);
    exit(0);
  }

  int result = 0;

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
      result += number;
    }
    else {
      result -= number;
    }
  }

  return result;
}


int main(int argc, char const *argv[])
{
  int answer = solve(argv[1]);

  printf("%d", answer);

  return 0;
}
