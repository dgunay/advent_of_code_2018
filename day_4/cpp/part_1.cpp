#include <fstream>
#include <string>
#include <ctime>
#include <cstdio>
#include <vector>

tm parse_time(const std::string& str) {
	tm time;
	// [yyyy-mm-dd hh:mm]
	sscanf(str.c_str, "[%d-%d-%d %d:%d]", time.tm_year, time.tm_mon, time.tm_mday, 
	       time.tm_hour, time.tm_min);	

	// subtract the year
	time.tm_year -= 1900;

	// set default values
	time.tm_sec = 0;

	return time;
}

class Guard {
	private:
	int seconds_asleep = 0;

	public:
	int get_seconds_asleep() { return seconds_asleep; }
};

int main(int argc, char const *argv[])
{
	std::ifstream fin;
	fin.open(argv[1]);
	if (fin.bad()) {
		exit(1);
	}

	std::vector<Guard> guards;
	std::string line;
	bool guard_awake = true;
	tm begin_time;
	Guard* current_guard = nullptr;
	while (std::getline(fin, line)) {
		if (guard_awake)
		while (guard_awake) {

		}
		// Parse each line into dates
			begin_time = 
			first_time = false;
		}


		// If it's a Guard beginning his shift...
			// Put the previous guard in a maxheap by time asleep. 
			// Get the guard ID, set awake.
		
		// or asleep/awake state, flag it so.
	}

	return 0;
}
