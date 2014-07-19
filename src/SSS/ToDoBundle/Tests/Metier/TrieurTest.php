<?php

namespace SSS\ToDoBundle\Tests\Metier;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SSS\ToDoBundle\Metier\Trieur;
use SSS\ToDoBundle\Entity\Tache;

class TrieurTest extends WebTestCase
{
	public function testSortTasksList(){
		$arrayToTest = array();
		for($i = 0; $i < 12; $i++){
			$arrayToTest[] = new Tache();
		}
		$arrayToTest[1]->setTachePrincipale($arrayToTest[3]);
//			$arrayToTest[3]->addSousTach($arrayToTest[1]);
		$arrayToTest[2]->setTachePrincipale($arrayToTest[3]);
//			$arrayToTest[3]->addSousTach($arrayToTest[2]);
		$arrayToTest[4]->setTachePrincipale($arrayToTest[3]);
//			$arrayToTest[3]->addSousTach($arrayToTest[4]);
		$arrayToTest[8]->setTachePrincipale($arrayToTest[3]);
//			$arrayToTest[3]->addSousTach($arrayToTest[8]);

		$arrayToTest[5]->setTachePrincipale($arrayToTest[2]);
//			$arrayToTest[2]->addSousTach($arrayToTest[5]);
		$arrayToTest[7]->setTachePrincipale($arrayToTest[2]);
//			$arrayToTest[2]->addSousTach($arrayToTest[7]);

		$arrayToTest[6]->setTachePrincipale($arrayToTest[7]);
//			$arrayToTest[7]->addSousTach($arrayToTest[6]);

		$arrayToTest[9]->setTachePrincipale($arrayToTest[11]);
//			$arrayToTest[11]->addSousTach($arrayToTest[9]);


		$arrayCorrect = array(new Tache());
		$arrayCorrect[] = $arrayToTest[11]->setTachePrincipale($arrayCorrect[0]);
		$arrayCorrect[] = $arrayToTest[9];
		$arrayCorrect[] = $arrayToTest[10]->setTachePrincipale($arrayCorrect[0]);
		$arrayCorrect[] = $arrayToTest[3]->setTachePrincipale($arrayCorrect[0]);
		$arrayCorrect[] = $arrayToTest[8];
		$arrayCorrect[] = $arrayToTest[4];
		$arrayCorrect[] = $arrayToTest[2];
		$arrayCorrect[] = $arrayToTest[7];
		$arrayCorrect[] = $arrayToTest[6];
		$arrayCorrect[] = $arrayToTest[5];
		$arrayCorrect[] = $arrayToTest[1];

		$arrayCorrect[0]->addSousTach($arrayToTest[11]);
		$arrayCorrect[0]->addSousTach($arrayToTest[10]);
		$arrayCorrect[0]->addSousTach($arrayToTest[3]);

		$trieur = new Trieur();
		$arrayReturned = $trieur->sortTasksList($arrayToTest);
		//var_dump($arrayCorrect);
		//var_dump($arrayReturned);
		$this->assertTrue($arrayReturned == $arrayCorrect);
	}
}
