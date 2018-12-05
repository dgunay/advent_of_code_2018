<?php

// represents a Claim because PHP doesn't have immutable structs, kms
class Claim {
	protected $raw_text;
	protected $id;
	protected $in_from_left_edge;
	protected $in_from_top_edge;
	protected $width;
	protected $height;
	protected $coords_occupied = [];

	// protected $intersects_flag = false;

	public function __construct(array $matches) {
		$this->raw_text          = $matches[0];
		$this->id                = $matches[1];
		$this->in_from_left_edge = $matches[2];
		$this->in_from_top_edge  = $matches[3];
		$this->width             = $matches[4];
		$this->height            = $matches[5];
	}

	public function raw_text()       : string { return $this->raw_text; }
	public function id()             : string { return $this->id; }
	public function in_from_left_edge() : int { return $this->in_from_left_edge; }
	public function in_from_top_edge()  : int { return $this->in_from_top_edge; }
	public function width()             : int { return $this->width; }
	public function height()            : int { return $this->height; }

	// public function set_intersect_flag(bool $to) : void { 
	// 	$this->intersects_flag = $to; 
	// }

	public function coords_occupied() : array {
		if (!empty($this->coords_occupied)) {
			return $this->coords_occupied;
		}

		$horizontal = range(
			$this->in_from_left_edge, 
			$this->in_from_left_edge + $this->width  - 1
		);
		$vertical   = range(
			$this->in_from_top_edge,  
			$this->in_from_top_edge  + $this->height - 1
		);
		
		$coordinates = [];
		foreach ($horizontal as $y) {
			foreach ($vertical as $x) {
				$coordinates[] = [$x, $y];
			}
		}

		return $coordinates;
	}
};

