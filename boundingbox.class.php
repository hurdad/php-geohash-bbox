<?php

include 'geoPHP/geoPHP.inc';

class BoundingBox
{
	const MAXBOXES = 20;
	private $gh;
	public $ur,$ll,$ul,$lr,$geom;
	public function BoundingBox($x1, $x2, $y1, $y2){
		$this->ur = new Point($x2, $y2);
		$this->ll = new Point($x1, $y1);
		$this->ul = new Point($x1, $y2);
		$this->lr = new Point($x2, $y1);
		$this->gh = new Geohash();
		$this->geom = geoPHP::load("POLYGON(({$x1} {$y1},{$x1} {$y2},{$x2} {$y2},{$x2} {$y1},{$x1} {$y1}))",'wkt');
	}
	
	public function getCoveringGeoHashes(){
		return $this->getMinBoxes(array($this->getCoveringGeoHash()));
	}
	
	private function getMinBoxes($hashes){
	
		$intersects = array();
		
		//iterate hashes
		foreach ($hashes as $h){
		
			//iterate sub hashes
			foreach ($this->generateSubGeoHashes($h) as $sh){
		
				//check if hash intersect our boundingbox
				$val = $this->gh->read($sh, true);
				if($this->geom->intersects($val)){
					$intersects[] = $sh;
				}
			}
		}
	 
	 	if (count($intersects) < self::MAXBOXES && count($intersects) > 0){// && hashes.head.prec < precision) {
	 		$childs = $this->getMinBoxes($intersects);
	 		if(count($childs) > self::MAXBOXES){
	 			return $intersects;
	 		} else{
	 			return $childs;
	 		}
	 	}else{
	 		return $intersects;
	 	}

	}

	private function getCoveringGeoHash(){

		$ll = $this->gh->write($this->ll);
		$ur = $this->gh->write($this->ur);

		$idx = -1;
		do {
			$match = false;
			$idx++;
			if(substr($ll, $idx, 1) == substr($ur, $idx, 1))
				$match = true;

		} while ($match);
		
		return substr($ll, 0, $idx);
	}

	private function generateSubGeoHashes($hash){

		$hashes = array();
		
		if(count($hash) <= 11) {
			$hashes[] = $hash."0";
			$hashes[] = $hash."1";
			$hashes[] = $hash."2";
			$hashes[] = $hash."3";
			$hashes[] = $hash."4";
			$hashes[] = $hash."5";
			$hashes[] = $hash."6";
			$hashes[] = $hash."7";
			$hashes[] = $hash."8";
			$hashes[] = $hash."9";
			$hashes[] = $hash."b";
			$hashes[] = $hash."c";
			$hashes[] = $hash."d";
			$hashes[] = $hash."e";
			$hashes[] = $hash."f";
			$hashes[] = $hash."g";
			$hashes[] = $hash."h";
			$hashes[] = $hash."i";
			$hashes[] = $hash."j";
			$hashes[] = $hash."k";
			$hashes[] = $hash."m";
			$hashes[] = $hash."n";
			$hashes[] = $hash."p";
			$hashes[] = $hash."q";
			$hashes[] = $hash."r";
			$hashes[] = $hash."s";
			$hashes[] = $hash."t";
			$hashes[] = $hash."u";
			$hashes[] = $hash."v";
			$hashes[] = $hash."w";
			$hashes[] = $hash."y";
			$hashes[] = $hash."z";
		}
		
		return $hashes;
	}

}

?>
