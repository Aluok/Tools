<?php

namespace SSS\ToDoBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SSS\ToDoBundle\Controller\DefaultController;
use SSS\ToDoBundle\Entity\Tache;

class DefaultControllerTest extends WebTestCase
{
//    public function testIndex() {
//        $client = static::createClient();

/*
        $crawler = $client->request('GET', 'http://localhost/SSS/Site_perso/web/app_dev.php/admin/ToDo/');
        $this->assertTrue($crawler->filter('html:contains("Finir cette page")')
        		->count() == 1);

        $this->assertTrue($crawler->filter('html:contains("Afficher plusieurs tâches")')
        		->count() == 1);
        $this->assertTrue($crawler->filter('html:contains("Afficher depuis la db")')
        		->count() == 1);
    }
    public function testAdd() {
    	$client = static::createClient();
   */
  //  	$crawler = $client->request('GET', '/admin/ToDo/add');

 //   	$this->assertTrue($crawler->filter('textarea')->count() == 2);
 //   }
    public function testSmth(){
        $controller = new DefaultController();
        $arrayToTest = array();
        for($i = 0; $i < 12; $i++){
            $arrayToTest[] = new Tache();
        }
          $arrayToTest[3]->addSousTach($arrayToTest[1]);
          $arrayToTest[3]->addSousTach($arrayToTest[2]);
          $arrayToTest[3]->addSousTach($arrayToTest[4]);
          $arrayToTest[3]->addSousTach($arrayToTest[8]);

          $arrayToTest[2]->addSousTach($arrayToTest[5]);
          $arrayToTest[2]->addSousTach($arrayToTest[7]);

          $arrayToTest[7]->addSousTach($arrayToTest[6]);

          $arrayToTest[11]->addSousTach($arrayToTest[9]);

          $arrayCorrect = array(
                $arrayToTest[3],
                $arrayToTest[1],
                $arrayToTest[2],
                $arrayToTest[5],
                $arrayToTest[7],
                $arrayToTest[6],
                $arrayToTest[4],
                $arrayToTest[8],
                );
        $array = $controller->getAllSousTaches($arrayToTest[3]);
        $this->assertTrue($array == $arrayCorrect);
        }
        public function testSmthElse(){
        $controller = new DefaultController();
        $arrayToTest = array();
        for($i = 0; $i < 12; $i++){
            $arrayToTest[] = new Tache();
        }
          $arrayToTest[3]->addSousTach($arrayToTest[1]);
          $arrayToTest[3]->addSousTach($arrayToTest[2]);
          $arrayToTest[3]->addSousTach($arrayToTest[4]);
          $arrayToTest[3]->addSousTach($arrayToTest[8]);

          $arrayToTest[2]->addSousTach($arrayToTest[5]);
          $arrayToTest[2]->addSousTach($arrayToTest[7]);

          $arrayToTest[7]->addSousTach($arrayToTest[6]);

          $arrayToTest[11]->addSousTach($arrayToTest[9]);

          $arrayCorrect = array(
                $arrayToTest[3],
                $arrayToTest[1],
                $arrayToTest[2],
                $arrayToTest[5],
                $arrayToTest[7],
                $arrayToTest[6],
                $arrayToTest[4],
                $arrayToTest[8],
                );
        $arrayCorrect2= array(
            $arrayToTest[11],
            $arrayToTest[9],
            );
        $array = $controller->getAllSousTaches($arrayToTest[11]);
        $this->assertTrue($array == $arrayCorrect2);

    }
    public function arraDiff($mainArray, $array){
        $MainMax = count($mainArray);
        $max = count($array);
        $j_to_skip = array();
        for($i = 0; $i < $MainMax; $i++){
            for($j = 0; $j < $max; $j++){
                if(!in_array($j, $j_to_skip)){
                    if($mainArray[$i] == $array[$j]){
                        unset($mainArray[$i]);
                        unset($array[$j]);
                        $j_to_skip[] = $j;
                        break;

                    }
                }
            }
        }
        return $mainArray;
    }
}
