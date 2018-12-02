/**
 * Starting from 0, execute all the math operations. 
 * Which is the first freq number that we see twice?
 */

#include <iostream>
#include <fstream>
#include <unordered_set>
#include <string>
#include <vector>

using std::ifstream;
using std::cerr;

typedef char operation;
typedef int frequency;

std::vector<std::pair<operation, int>> file_to_array_of_pairs(ifstream& fin) {
  std::vector<std::pair<operation, int>> pairs;

  while (!fin.eof()) {
    std::string line;
    std::getline(fin, line);

    if (line.size() == 0) {
      break;
    }

    operation op = line[0];

    int number = std::stoi(line.substr(1));

    pairs.push_back(std::make_pair(op, number));    
  }

  fin.clear();
  fin.seekg(0);
  return pairs;
}

int solve(const char* filename) {
  // open filename
  ifstream fin;
  fin.open(filename, ifstream::in);

  if (fin.bad()) {
    cerr << "Can't open file " << filename << "\n";
    exit(0);
  }

  // Load the operations and numbers into memory
  auto operation_num_pairs = file_to_array_of_pairs(fin);
  fin.close();

  std::unordered_set<frequency> freqs_encountered;

  frequency freq = 0;
  freqs_encountered.insert(freq);
  while (true) {
    for (auto pair : operation_num_pairs) {
      operation op = pair.first;
      int number   = pair.second;

      // apply the operation
      op == '+' ? freq += number : freq -= number;
      
      // Have we seen this frequency before?
      if (freqs_encountered.find(freq) != freqs_encountered.end()) {
        return freq;
      }

      freqs_encountered.insert(freq);
    }
    // Do it all over again!
  }

  // This shouldn't happen.
  printf("Could not find the answer\n");
  exit(1);
}


int main(int argc, char const *argv[])
{
  int answer = solve(argv[1]);

  std::cout << answer << '\n';

  return 0;
}
