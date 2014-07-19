<?php

namespace SSS\ToDoBundle\Metier;

use SSS\ToDoBundle\Entity\Tache;

class Trieur{
	private $newTable;
	private $newTableLength;
	private $tableToSort;

	public function __construct(){
		$this->initClass();
	}
	private function initClass(){
		$this->newTable = array(new Tache());
		$this->newTableLength = 1;
		$this->tableToSort = array();
	}
	public function sortTasksList($table){
		$this->tableToSort = $table;
		$this->initTableToSort();
		for($i = 0; $i < $this->newTableLength; $i++){
//
			$this->FindChildOfTasksNumber($i);
		}
		$tmpTable = $this->newTable;

		$this->initClass();
		return $tmpTable;
	}
	private function initTableToSort(){

		foreach($this->tableToSort as $task){

			if($task->getTachePrincipale() == null){
				$task->setTachePrincipale($this->newTable[0]);
				$this->newTable[0]->addSousTach($task);
			}

		}


	}
	private function FindChildOfTasksNumber($index){
		//echo $index;
		$childs = $this->newTable[$index]->getSousTaches();

		foreach($this->tableToSort as $task){
			for($jkl = 0; $jkl < $this->newTableLength; $jkl++){
				if($task == $childs[$jkl]){
					$this->insertTaskAfter($task, $index);
				}

			}
		}
	}
	private function insertTaskAfter($task, $index){

		if($index + 1 >= $this->newTableLength){
			$this->newTable[] = $task;
			$this->newTableLength++;
		} else {
			$tmp1 = $this->newTable[$index + 1];
			$tmp2;
			$this->newTable[$index + 1] = $task;
			for($j = $index+2; $j<$this->newTableLength; $j++){
				$tmp2 = $this->newTable[$j];
				$this->newTable[$j] = $tmp1;
				$tmp1 = $tmp2;
			}
			$this->newTable[] = $tmp1;
			$this->newTableLength++;
		}
	}
}
