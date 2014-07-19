<?php

namespace SSS\ToDoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use SSS\ToDoBundle\Entity\Tache;
use SSS\ToDoBundle\Form\TacheType;

use SSS\ToDoBundle\Metier\Trieur;

class AjaxController extends Controller
{
	public function getTasksAction() {

        //$response = new Json private function addForm($tache = null) {
   /*     if($tache = null){
            $tache = new Tache();
        }
        $form = $this->createForm(new TacheType(), $tache);
        return $form;*/
        //Response($this->getAttributes());
     //   $response->setData(array());
        //$response->prepare($this->get('request'));
        //$response->send();
        return $this->render('SSSToDoBundle:layout:list_tasks.html.twig',
            $this->getAttributes());
    }
    private function getAttributes() {
        $tasks = $this->getAllTasks();
        return array('tasksList' => $tasks,
                    'TaskMaxId' => count($tasks) - 1,
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
    public function addAction($task) {
        $request = $this->get('request');
        $id = $request->request->get('id');

        if( $task == null){
            $task = new Tache();
        }
        $additionForm = $this->addForm($task);
        if($this->isPostResquest()){
            $this->treatForm($additionForm);
        }
        return $this->render('SSSToDoBundle:Default:jg.html.twig');
    }
     private function addForm($tache = null) {
        if($tache = null){
            $tache = new Tache();
        }
        $form = $this->createForm(new TacheType(), $tache);
        return $form;
    }
    private function isPostResquest() {
        return $this->get('request')->getMethod() == "POST";
    }
    private function treatForm($form, $titre, $description, $mainTask) {
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
}
