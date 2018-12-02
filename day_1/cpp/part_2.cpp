/**
 * Starting from 0, execute all the math operations. 
 * Which is the first total number that we see twice?
 */

#include <iostream>
#include <fstream>
#include <unordered_map>
#include <string>

using std::ifstream;
using std::cerr;

int num_lines_in_file(ifstream& fin) {
  int num_lines = 0;
  while (fin.good()) {
    char c = fin.get();
    if (c == '\n') { num_lines++; }
  }

  fin.clear();
  fin.seekg(0);
  return num_lines;
}

int solve(const char* filename) {
  // open filename
  ifstream fin;
  fin.open(filename, ifstream::in);

  if (fin.bad()) {
    cerr << "Can't open file " << filename << "\n";
    exit(0);
  }

  // int size_of_nums_encountered = num_lines_in_file(fin);
  std::unordered_map<int, int> nums_encountered;

  int total = 0;
  nums_encountered[0]++;
  std::string line;
  while (true) {
    while (!fin.eof()) {
      std::getline(fin, line);

      // Get our operation
      char op = line[0];

      // convert str to int
      int number = std::stoi(line.substr(1, std::string::npos));
      
      // apply the operation
      if (op == '+') {
        total += number;
      }
      else {
        total -= number;
      }

      // Record that we witnessed this point of the running total.
      if (nums_encountered.find(total) != nums_encountered.end()) {
          return nums_encountered[total];
      } 
      else {
        nums_encountered[total] = 1;
      }
    }

    // Do it all over again!
    fin.clear();
    fin.seekg(0);
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
