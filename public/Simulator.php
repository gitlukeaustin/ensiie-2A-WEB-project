<?php


class Simulator {
	private $log;
	private $winner;

	public function __construct(){
		$this->log = [];
		$this->winner = NULL;
	}

	public function simulate($cards1,$cards2,$j1,$j2){
		$attack = 0;
		$c1 = $this->drawCard($cards1,$j1);
		$c2 = $this->drawCard($cards2,$j2);
		$i = 20; 
		while($i > 0){
			$i -= 1;
			if($c1 == NULL){
				if($c2 == NULL)
					return NULL;
				else{
					$i = 0;
					$this->winner = $j2;
				}		
			}
			else if($c2 == NULL){
				$i = 0;
				$this->winner = $j1;
			}
			else{
				$this->log[] = $c1['name']." [".$j1['login']."] a:".$c1['attack']."/d:".$c1['defence']." &#9876;  ".$c2['name']."  [".$j2['login']."] a:".$c2['attack']."/d:".$c2['defence'];

				$attack = $this->confront($c1,$c2,$j1,$j2);
				$c2['defence'] = $c2['defence'] - $attack;
				
				$attack = $this->confront($c2,$c1,$j2,$j1);
				 
				$c1['defence'] = $c1['defence'] - $attack;
				
				if($c1['defence'] <= 0){
					$this->log[] = "La ".$c1['name']." de ".$j1['login']." est tombé!";
					$c1 = $this->drawCard($cards1,$j1);
				}
				if($c2['defence'] <= 0){
					$this->log[] = "La ".$c2['name']." de ".$j2['login']." est tombé!";
				 	$c2 = $this->drawCard($cards2,$j2);
				}
			}
			
		}
		return $this->winner;
	}
	
	private function drawCard(& $c, $j) {// passage par reference
		$draw = array_shift($c);
		$def = 0;
		while($draw != NULL && ($draw['attack']??0) == 0){
			$def += $draw['defence'];
			$this->log[] = $j['login']." a posé un ".$draw['name']." (+$def défence)!";
			$draw = array_shift($c);
		}
		if($draw != NULL) $draw['defence'] = $draw['defence'] + $def;
		return $draw;
	}
	
	private function confront($attackCard,$defenceCard,$attacker,$defender){
		if(rand(0,1) > $attackCard['chance']){
			$this->log[] = "L'attaque du ".$attackCard['name']." de ".$attacker['login']." a échoué!";
			return 0;
		}
		else{
			//$this->log[] = $attackCard['name']." de ".$attacker['login']." a attaqué un(e) ".$defenceCard['name']." pour ".$attackCard['attack']." points!";
			//$this->log[] = "Vie de ".$defenceCard['name']." : ".($defenceCard['defence'] - $attackCard['attack']); 
			return $attackCard['attack'];	
		}
	}
	
	 /**
     * @return array
     */
	public function getWinner(){
		return $this->winner;
	}

	 /**
     * @return array
     */
	public function  getLog(){
		return $this->log;
	}
}
