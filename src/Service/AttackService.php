<?php

namespace App\Service;

use App\Entity\Monster;
use Doctrine\ORM\EntityManagerInterface;

class AttackService
{
	private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
	
	public function attackMonster(Monster $monster)
    {
		
		$monster_attack_value = $monster->getAttackValue();
		
		if(strlen($monster_attack_value)>3)
		{
			
			if($monster_attack_value[3] == '-')
			{
				$exact_monster_attack_value=$monster_attack_value[0]*$monster_attack_value[2]-$monster_attack_value[4];
			}		
			else
			{
				$exact_monster_attack_value=$monster_attack_value[0]*$monster_attack_value[2]+$monster_attack_value[4];
			}
		}
		else
		{
			$exact_monster_attack_value = $monster_attack_value[0]*$monster_attack_value[2];
		}

		return $exact_monster_attack_value;	
		
	}
	
}
