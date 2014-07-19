<?php

namespace SSS\ToDoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SSS\ToDoBundle\Entity\Tache;
use SSS\ToDoBundle\Form\TacheType;
use SSS\ToDoBundle\Metier\Trieur;

class DefaultController extends Controller
{


    public function indexAction() {
	    return $this->render('SSSToDoBundle:Default:index.html.twig',
                        $this->getAttributes());
    }
    private function getAttributes() {
        //$tasks = $this->getAllTasks();
        return array(//'tasksList' => $tasks,
                    //'TaskMaxId' => count($tasks) - 1,
                    'form' => $this->addForm()->createView(),
                    );
    }
    private function getAllTasks() {
        $tasks_raw = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository("SSSToDoBundle:Tache")
                ->findAll();
                ;
        $trieur = new Trieur();
        return $trieur->sortTasksList($tasks_raw);
    }
    private function addForm($tache = null) {
        if($tache = null){
        	$tache = new Tache();
        }
    	$form = $this->createForm(new TacheType(), $tache);
    	return $form;
    }


    public function addAction() {
        $tache = new Tache();
        $additionForm = $this->addForm($tache);

        if($this->isPostResquest()){
            $this->treatForm($additionForm);
        }
        return $this->redirectToHomepage();
    }
    private function isPostResquest() {
        return $this->get('request')->getMethod() == "POST";
    }
    private function treatForm($form) {
        if($this->isFormValid($form)){
            $tache = $form->getData();
            $this->saveInDatabase($tache);
        }
    }
    private function isFormValid($form) {
        $form->bind($this->get('request'));
        return $form->isValid();
    }
    private function saveInDatabase($task) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($task);
        $em->flush();
    }
    private function redirectToHomepage() {
        return $this->redirect($this->generateUrl('sss_to_do_homepage'));
    }


    public function deleteAction(Tache $task, $validated) {
        if($validated){
            $this->deleteTaskAndSubTasks($task);
            return $this->redirectToHomepage();
        }else{
            $tasks = $this->getAllSousTaches($task);
            return $this->render('SSSToDoBundle:Default:deleteValidation.html.twig', array(
                                        'tasks' => $tasks,
                                        'mainTask'=>$task));
        }
    }
    private function deleteTaskAndSubTasks($task) {

        $this->deleteSubTasks($task);
        $this->deleteMainTask($task);
    }
    private function deleteSubTasks($mainTask) {
        $em =$this->getDoctrine()->getManager();
        $tasks = $this->getAllSousTaches($mainTask);
        $tasks_lenght = count($tasks);
        for($i = 1;$i < $tasks_lenght; $i++) {
            $em->remove($tasks[$i]);
        }
    }
    private function deleteMainTask($task) {
        $em =$this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
    }


    public function getAllSousTaches($task) {
        $array_to_return = array();
        $array_to_return[] = $task;
        $sousTaches = $task->getSousTaches();
        if($sousTaches != null){
            foreach($sousTaches as $tache){

                $array_to_return = array_merge($array_to_return, $this->getAllSousTaches($tache));
            }
        }
        return $array_to_return;
    }
    public function updateAction(Tache $task) {
        $updateForm = $this->createForm(new TacheType(), $task);
        if($this->isPostResquest()){
            $this->treatForm($updateForm);
            return $this->redirectToHomepage();
        }
        return $this->render('SSSToDoBundle:Default:update.html.twig',
            array("form"=> $updateForm->createView()
            ));
    }
}
