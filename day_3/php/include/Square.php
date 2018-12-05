<?php

// Represents a square inch of fabric 
class Square {
	protected $occupants = [];

	public function occupy(Claim $claim) : void {
		if (!array_key_exists($claim->id(), $this->occupants)) {
			$this->occupants[$claim->id()] = true;
		}
	}

	public function get_occupants() : array { return $this->occupants; }
}