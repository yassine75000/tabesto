<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Adventure;
use App\Entity\Tile;
use App\Entity\Character;
use App\Entity\Monster;
use App\Service\AttackService;

/**
 * @Route("/api", name="api_")
 */
class CharacterController extends AbstractController
{
   
	/**
     * @Route("/character/{character_id}/action/move", name="character_move", methods={"POST"})
     */
    public function character_move(Request $request, int $character_id, AttackService $attackService): Response
    {
		$entityManager = $this->getDoctrine()->getManager();
        $character = $entityManager->getRepository(Character::class)->find($character_id);
		$monster = $entityManager->getRepository(Monster::class)->find(1);		
		
		$character_armor_value = $character->getArmorValue();		

		$exact_monster_attack_value = $attackService->attackMonster($monster);
 
       
		if($exact_monster_attack_value>$character_armor_value)
		{
			$perte_point = $exact_monster_attack_value-$character_armor_value;
			$life_point_character = $character->getLifePoint()-$perte_point;
			
			$character->setLifePoint($life_point_character);
			$entityManager->persist($character);		
			$entityManager->flush();
		
			if($life_point_character <= 0)
			{
				
				return $this->json('end of adventure');
			}	
			
		}
		
		$data = array(
				"name"=> "Character do action move",
				"id"=> Uuid::v4(),
				"response" =>[
					'adventure_id' => $adventure_id,
					'adventure_score' => $adventure->getScore(),
					'character_id' => $adventure->getPersonnage()->getId(),
					]
         );
				
         
        return $this->json($data);
		
	}
	
	/**
     * @Route("/character/{character_id}/action/attack", name="character_attack", methods={"POST"})
     */
    public function character_attack(Request $request, int $character_id): Response
    {
		$entityManager = $this->getDoctrine()->getManager();
        $character = $entityManager->getRepository(Character::class)->find($character_id);
		$adventure = $character->getAdenture()->getId();
		
		$tile = $entityManager->getRepository(Tile::class)->findTileActif($adventure);
		
		if($tile->getMonster()->getLifePoint()>0)
		{
			
			$character_attack_value = $character->getAttackValue();
			$monster_armor_value = $tile->getMonster()->getArmorValue();
			if(strlen($character_attack_value)>3)
			{
			
				if($character_attack_value[3] == '-')
				{
					$exact_character_attack_value=$character_attack_value[0]*$character_attack_value[2]-$character_attack_value[4];
				}		
				else
				{
					$exact_character_attack_value=$character_attack_value[0]*$character_attack_value[2]+$character_attack_value[4];
				}
			}
			else
			{
				$exact_character_attack_value = $character_attack_value[0]*$character_attack_value[2];
			}	

			if($exact_character_attack_value>$monster_armor_value)
			{
				
				$perte_point = $exact_character_attack_value-$monster_armor_value;
				$life_point_monster = $tile->getMonster()->getLifePoint()-$perte_point;
				$tile->getMonster()->setLifePoint($life_point_monster);
				$entityManager->persist($tile);		
				$entityManager->flush();
				
				if($life_point_monster<=0)
				{
					
					$data = array(
						"name"=> "Character do action Attack",
						"id"=> Uuid::v4(),
						"response" =>[
							'message' => 'the monster lost'
							]
					);
					
					return $this->json($data);
				}
				else				
				{
					$character_armor_value = $character->getArmorValue();
					
					$exact_monster_attack_value = $attackService->attackMonster($monster);
					if($exact_monster_attack_value>$character_armor_value)
					{
						$perte_point = $exact_monster_attack_value-$character_armor_value;
						$life_point_character = $character->getLifePoint()-$perte_point;
						
						$character->setLifePoint($life_point_character);
						$entityManager->persist($character);		
						$entityManager->flush();
					
						if($life_point_character <= 0)
						{
							$data = array(
								"name"=> "End of adventure",
								"id"=> Uuid::v4(),
								"response" =>[
									'message' => 'end of adventure'
									]
							);
							return $this->json($data);
						}	
						
					}
				}	
				
			}
			
 
			
		}
		
	}
	
	/**
     * @Route("/character/{character_id}", name="get_character", methods={"GET"})
     */
    public function character_show(Request $request, int $character_id): Response
    {
		$character = $entityManager->getRepository(Character::class)->find($character_id);
		
		$data = array(
				"name"=> "Get Character",
				"id"=> Uuid::v4(),
				"response" =>[					
					'life_point' =>  $tile->getMonster()->getLifePoint(),
					'attack_value' =>  $tile->getMonster()->getAttackValue(),
					'armor_value' =>  $tile->getMonster()->getArmorValue()
					
				]
         );
        return $this->json($data);
		
	}
	
}
