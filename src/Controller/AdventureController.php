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
use Symfony\Component\Uid\Uuid;

/**
 * @Route("/api", name="api_")
 */
class AdventureController extends AbstractController
{
    /**
	 * start adventure	
     * @Route("/adventure/start", name="adventure_new", methods={"POST"})
     */
    public function adventure_start(): Response
    {
		$entityManager = $this->getDoctrine()->getManager();
		
		$adventure = new Adventure();
        $adventure->setScore(0);
		
		
		$character = new Character();
		$character->setAdenture($adventure);
		$character->setLifePoint(20);
		$character->setAttackValue('2D6');
		$character->setArmorValue(5);
		
		
		$entityManager->persist($adventure);
		$entityManager->persist($character);
        
		$keytype = rand(0,4);
		
		$tile_value = [
		['type' => 'grasslands', 'effect' => '1D6+2'],
		['type' => 'hills', 'effect' => '1D4+2'],
		['type' => 'hills', 'effect' => '1D4+1'],
		['type' => 'mountains', 'effect' => '1D6+2'],
		['type' => 'desert', 'effect' => '-1']
		];
		
		$tile_type = $tile_value[$keytype]['type'];		
		$tile_effect = $tile_value[$keytype]['effect'];
		
		$tile = new Tile();
		$tile->setType($tile_type);
		$tile->setSpecialEffects($tile_effect);
		$tile->setActif(1);
		$tile->setAdventure($adventure);			
		
		$monster_value = [
		['type' => 'Ork', 'point' => '10', 'attack'=>'1D6','armor'=>'4'],
		['type' => 'Gobelin', 'point' => '12', 'attack'=>'1D4-1','armor'=>'0'],
		['type' => 'Ghost', 'point' => '8', 'attack'=>'1D4','armor'=>'6'],
		['type' => 'Troll', 'point' => '12', 'attack'=>'1D6','armor'=>'6']
		];
		$monster_type = $monster_value[$keytype]['type'];
		$monster_point = $monster_value[$keytype]['point'];
		$monster_attack = $monster_value[$keytype]['attack'];
		$monster_armor = $monster_value[$keytype]['armor'];
		
		$monster = new Monster();
		$monster->setType($monster_type);
		$monster->setLifePoint($monster_point);
		$monster->setAttackValue($monster_attack);
		$monster->setArmorValue($monster_armor);
		$monster->setTile($tile);
		
		$entityManager->persist($tile);
		$entityManager->persist($monster);
		
		$entityManager->flush();
		
		$data = array(
				"name"=> "Start Adventure",
				"id"=> Uuid::v4(),
				"response" =>[
					'message' => 'start adventure'
				]
         );
		
         return $this->json($data);
    }
		
	
	/**
     * @Route("/adventure/{adventure_id}", name="get_adventure", methods={"GET"})
     */
    public function adventure_show(Request $request, int $adventure_id): Response
    {
		$entityManager = $this->getDoctrine()->getManager();
        $adventure = $entityManager->getRepository(Adventure::class)->find($adventure_id);
 
        if (!$adventure) {
            return $this->json('L\'aventure n\'a pas encore commencée', 404);
        }
		
		$data = array(
				"name"=> "Get Adventure",
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
     * @Route("/adventure/{adventure_id}/tile", name="get_tile_adventure", methods={"GET"})
     */
    public function adventure_tile_active(Request $request, int $adventure_id): Response
    {
		$entityManager = $this->getDoctrine()->getManager();
        $adventure = $entityManager->getRepository(Adventure::class)->find($adventure_id);
 
       $tile = $entityManager->getRepository(Tile::class)->findTileActif($adventure);
		
		$data = array(
				"name"=> "Get Adventure",
				"id"=> Uuid::v4(),
				"response" =>[
					'tile_id' =>  $tile->getId(),
					'type' => $tile->getType(),
					'special_effects' => $tile->getSpecialEffects(),
					'monster_id' =>  $tile->getMonster()->getId(),
					'life_point_monster' =>  $tile->getMonster()->getId(),
					'attack_value_monster' =>  $tile->getMonster()->getAttackValue(),
					'armor_value_monster' =>  $tile->getMonster()->getArmorValue(),
					'type_monster' =>  $tile->getMonster()->getType(),
				]
         );
        return $this->json($data);
		
	}
	
}
