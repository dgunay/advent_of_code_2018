<?php

class Guard {
	protected $asleep_time = 0;
	protected $asleep = false;
	protected $id;
	protected $sleep_minute_ranges = [];

	public function __construct(string $id) { $this->id = $id; }

	// getters
	public function id()            : string { return $this->id;           }
	public function mins_asleep()   : int    { return $this->asleep_time;  }
	public function is_awake()      : bool   { return $this->asleep;       }
	public function sleep_minute_ranges() : array  { 
		return $this->sleep_minute_ranges; 
	}

	// setters
	public function wake_up()     : void { $this->asleep = false; }
	public function fall_asleep() : void { $this->asleep = true;  }

	public function sleep_for(\DateTime $to, \DateTime $from) : void {
		$diff = $from->diff($to);
		$this->asleep_time += $diff->i;

		$this->sleep_minute_ranges[] = [$from, $to];
	}

	private function most_common_minute_asleep() {
		/*
			For every range of sleeps
				Get minute begin, and minute end
				
		*/
	}
};

$lines = array_map('trim', array_filter(file($argv[1]))) or die;

$guards = [];
$current_guard = false;
$last_time = null;
$mins_asleep = 0;
foreach ($lines as $line) {
	$time = parse_time($line);

	if ($current_guard && !$current_guard->is_awake()) {
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
foreach ($sleepiest_guard->times_asleep() as $sleep_interval) {

}



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