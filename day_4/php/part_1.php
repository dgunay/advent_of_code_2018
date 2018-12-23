<?php

class Guard {
	protected $asleep_time = 0;
	protected $asleep = false;
	protected $id;
	protected $mins_slept_counters = [];

	public function __construct(string $id) { 
		$this->id = $id;
		$this->mins_slept_counters = array_fill_keys(range(0, 59), 0);
	}

	// getters
	public function id()            : string { return $this->id;           }
	public function mins_asleep()   : int    { return $this->asleep_time;  }
	public function is_awake()      : bool   { return $this->asleep;       }
	public function is_asleep()     : bool   { return !$this->asleep;       }
	public function mins_slept_counters() : array  { 
		return $this->mins_slept_counters; 
	}

	// setters
	public function wake_up()     : void { $this->asleep = false; }
	public function fall_asleep() : void { $this->asleep = true;  }

	public function sleep_for(\DateTime $to, \DateTime $from) : void {
		$diff = $from->diff($to);
		$this->asleep_time += $diff->i;

		$tot_mins_asleep = $diff->i;
		$starting_min = $from->format('i');

		// Start from the minute of from
		// increment the counters, modulo-ing by 60
		$current_min = $starting_min;
		for ($i = 0 ; $i < $tot_mins_asleep ; $i++, $current_min++) {
			$this->mins_slept_counters[$current_min % 60]++;
		}
	}

	private function most_common_minute_asleep() {
		// Just increment the counter for each minute
		$minutes_slept_during = array_fill_keys(range(0,59), 0);
		foreach ($this->mins_slept_counters() as $range) {

		}
	}
};

$lines = array_map('trim', array_filter(file($argv[1]))) or die;

$guards = [];
$current_guard = false;
$last_time = null;
$mins_asleep = 0;
foreach ($lines as $line) {
	$time = parse_time($line);

	if ($current_guard && $current_guard->is_asleep()) {
		// TODO: also, is it between 00:00 and 01:00?
		// if ()
		// Add the difference in times to this guard's asleep mins
		$current_guard->sleep_for($time, $last_time);
	}

	// Is it a new Guard?
	if (strpos($line, 'Guard') !== false) {
		// Store the last guard in a table
		if ($current_guard) { 
			$guards[$current_guard->id()] = $current_guard; 
		}

		// Make a new one
		$current_guard = parse_guard_id($line);
	}
	elseif (strpos($line, 'falls asleep')) {
		$current_guard->fall_asleep();
	}
	elseif (strpos($line, 'wakes up')) {
		$current_guard->wake_up();
	}

	$last_time = $time;
}

// Get the guard who slept for the longest time
$sleepiest_guard = current($guards);
foreach ($guards as $guard) {
	if ($sleepiest_guard->mins_asleep() < $guard->mins_asleep()) {
		$sleepiest_guard = $guard;
	}
}

// What minute of the hour was he asleep the most?
$most_common_minute_asleep = 0;
$highest_sleep_time = 0;
foreach ($sleepiest_guard->mins_slept_counters() as $time => $times_asleep) {
	if ($times_asleep > $highest_sleep_time) {
		$most_common_minute_asleep = $time;
	}
}

echo $most_common_minute_asleep . PHP_EOL;
echo $sleepiest_guard->id();
exit;
echo ($most_common_minute_asleep * $sleepiest_guard->id());



// Functions

function parse_time(string $line) : \DateTime {
	$line = substr($line, 0, strpos($line, ']'));
	return \DateTime::createFromFormat('[Y-m-d H:i', $line);
}

function parse_guard_id(string $line) : Guard {
	if (preg_match('/Guard #(\d+)/', $line, $match)) {
		return new Guard($match[1]);
	} 

	throw new Exception('Failed to parse Guard ID');
}