<?php
//énumeration pour parcourir les tests? possibles en php? comment?

//interessant pour getnote et getauditexistant

//génération password aléatoire

//generateUrl avec
namespace SSS\AuditBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

use SSS\AuditBundle\Entity\Audit;
use SSS\AuditBundle\Entity\ErgoAudit;
use SSS\AuditBundle\Entity\AccessAudit;
use SSS\AuditBundle\Entity\CompaAudit;
use SSS\AuditBundle\Entity\FctAudit;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

use SSS\AuditBundle\Work\AJAX;

class AuditController extends Controller
{
    public $em;


    public function updateAction() {
        $request = $this->get('request');
        if($request->getMethod() == 'POST') {
            return $this->understandRequest($request);
        } else {
            return $this->redirect($this->generateURL('sss_audit_audit_liste', array('errorMessage'=> 'La requete doit être de type POST. Veuillez contacter l\'administrateur si vous n\'êtes pas resposable de cette erreur')));
        }
    }
    private function understandRequest($request){
        $data = $request->getContent();
        if($data != null){
           return $this->understandData($data);
        }
        return $this->redirect($this->generateURL('sss_audit_audit_liste', array('errorMessage'=> 'Un problème est survenu, aucune donnée n\'a été transmise. Veuillez contacter l\'administrateur')));
    }
    private function understandData($data){
       $id = 0;
       $update= array();
       $data = explode('&',$data);
       $length= count($data);
       for($i = 0; $i < $length; $i++){
          $donnee = explode('=', $data[$i]);
          if($donnee[0] == 'id'){
              $id = (int)$donnee[1];
          } else if($donnee[0] == 'update'){
              array_push($update, $donnee[1]);
          }
        }
        if($id != 0){
            return $this->treatUpdate($update, $id);
        }
    }
    private function treatUpdate($update, $id){
        if(!empty($update)){
            $audits = $this->auditsToPrint($update);
            $client = $this->getDoctrine()->getManager()->getRepository('SSSAuditBundle:Audit')->find($id)->getClient();
            $auditsExistants = $this->getAuditExistant($id, $update);
            return $this->render('SSSAuditBundle:Audit:add_update.html.twig', array('audits' => $audits,
                                                                                    'client' => $client,
                                                                                    'existant' => $auditsExistants,
                                                                                   ));
        }
    }
    private function getAuditExistant($id, $update){
        $auditsExistants = array('id' => $id);
        $em = $this->getDoctrine()->getManager();
        if(in_array('ergo', $update)){
            $audit = $em->getRepository('SSSAuditBundle:ErgoAudit')->find($id);
            $auditsExistants['ergo'] = $audit;
        }
        if(in_array('access', $update)){
            $audit = $em->getRepository('SSSAuditBundle:AccessAudit')->find($id);
            $auditsExistants['access'] = $audit;
        }
        if(in_array('compa', $update)){
            $audit = $em->getRepository('SSSAuditBundle:CompaAudit')->find($id);
            $auditsExistants['compa'] = $audit;
        }
        if(in_array('fct', $update)){
            $audit = $em->getRepository('SSSAuditBundle:FctAudit')->find($id);
            $auditsExistants['fct'] = $audit;
        }
        return $auditsExistants;
    }

    public function listAction($errorMessage) {
        $this->em = $this->getDoctrine()->getManager();

        $id_auditeur = $this->get('security.context')->getToken()->getUser()->getId();
        $audits = $this->em->getRepository('SSSAuditBundle:Audit')->findByAuditeur($id_auditeur);
        $note_audits = $this->getAuditsComplementaires($audits);
        return $this->render('SSSAuditBundle:Audit:list.html.twig', array('audits'=>$audits,
                                                                         'note_audits' => $note_audits,
                                                                         'error_message'=>$errorMessage));
    }
    private function getAuditsComplementaires($listAudits){
        $length = count($listAudits);
        $note_audits = array();
        for($i = 0; $i < $length; $i++){
            $array_to_push = $this->getNote($listAudits[$i]);
            array_push($note_audits, $array_to_push);
        }
        return $note_audits;
    }
    private function getNote($audit){
        $array = array();
        $total = 0;
        $audits = $audit->arrayAudit();
        for($i = 0; $i < 4; $i++){
            if($audit($audits[$i])){
                $array[$audits[$i]] = $this->getPartAudit($audit->getId(), ucfirst($audits[$i]));
                $total += $array[$audits[$i]];
            }
        }
        $array['total'] = $total;
        return $array;
    }
    private function getPartAudit($id, $part){
        return $this->em->getRepository('SSSAuditBundle:'.$part.'Audit')->find($id)
                ->generateNote()
                ->getNote();
    }

    public function addAction() {
        $audits = $this->auditsToPrint(array());
        return $this->render('SSSAuditBundle:Audit:add_update.html.twig', array('audits' => $audits,
                                                                               'client' => $_POST['nom_client']));
    }
    public function addAutomatedAction() {
        $request = $this->get('request');
        if($request->getMethod() == 'POST'){
            $content = $request->request;
            if($content != null){
                $params = array();
                if(isset($_POST['nom_client']) &&
                  isset($_POST['site_client'])){
                    $params['general'] = array('client' => $_POST['nom_client'],
                                              'site_client' => $_POST['site_client'],
                                              'commentaire' => null);
                }
                if(isset($params['general']['client'])){
                    $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
                    $channel = $connection->channel();

                    $channel->exchange_declare('audit1', 'topic', false, false, false);

                    $audits = $this->auditsToPrint(array());
                    $key ="";
                    if(in_array(Audit::ERGO, $audits)){
                        $params['ergo'] = null;
                        $key .= "ergo.";
                    }else{
                        $key .= "not.";
                    }
                    if(in_array(Audit::COMPA, $audits)){
                        $key .= "compa.";
                    }else{
                        $key .= "not.";
                    }
                    if(in_array(Audit::ACCESS, $audits)){
                        $key .= "access.";
                    }else{
                        $key .= "not.";
                    }
                    if(in_array(Audit::FCT, $audits)){
                        $key .= "fct";
                    }else{
                        $key .= "not";
                    }
                    $ajax = new AJAX($this->getDoctrine()->getManager());
                    $audits_to_save = $ajax->getAudits($params, $this->get('security.context')->getToken()->getUser()->getId());
                    $id = $this->saveToBdd($audits_to_save);
                    $channel->basic_publish(new AMQPMessage($id), 'audit1', $key);
                    $message = "Nous avons enregistré votre demande de test automatisé. <br />
                    Celui-ci sera effectué dans les 24h suivantes.";
                    $title = 'Audit pour '.$_POST['nom_client'].'. id= '.$id.' key = '.$key;
                    $channel->close();
                    $connection->close();
                }else{
                    $message = "Une erreur est survenue : Veuillez contacter l'administrateur et lui signaler l'erreur : automated.params.general";
                    $title = 'Erreur';
                }
            }else{

                $message = "Une erreur est survenue : Veuillez contacter l'administrateur et lui signaler l'erreur : automated.content.null";
                $title = 'Erreur';
            }
        }else{
            $message = "Une erreur est survenue : Veuillez contacter l'administrateur et lui signaler l'erreur : automated.method.type";
            $title = 'Erreur';
            //var_dump($$request->getMethod());
        }
        return $this->render('SSSAuditBundle:Audit:message.html.twig', array('message' => $message,
                                                                            'title' => $title));

    }

    public function AJAXsaveAction($audit){
        $request = $this->get('request');
        if($request->getMethod() == 'POST'){
            $content = $request->getContent();

            if($content != null){
                $params = json_decode($content, true);
                if(isset($params['general'])){
                    $ajax = new AJAX($this->getDoctrine()->getManager());
                    $audits = $ajax->getAudits($params, $this->get('security.context')->getToken()->getUser()->getId(), $audit);
                    $this->saveToBdd($audits);
                }
                return new Response(
                    'ok',
                    Response::HTTP_OK,
                    array('content-type' => 'text/html')
                );
            }
            return new Response(
                    'Erreur : '. $request->get('general'),
                    '400',
                    array('content-type' => 'text/html')
                    );
        }
        return new Response(
            'Vous devez utiliser la méthode POST pour joindre cette page',
            '418',
                array('content-type' => 'text/html')
        );
    }
    private function saveToBdd($audits){
        $length = count($audits);
        $em = $this->getDoctrine()->getManager();

                   // var_dump($audits);
        $em->persist($audits[0]);
        $em->flush();
        $id= $audits[0]->getId();
        for($i = 1; $i < $length; $i++){
            $audits[$i]->setId($id);
            $em->persist($audits[$i]);
        }
        $em->flush();
        return $id;
    }

    public function deleteAction(Audit $audit){
        $this->getDoctrine()->getManager()->remove($audit);
        $this->getDoctrine()->getManager()->flush();
        return new Response(
            'ok',
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
    }

    public function createAccessAction($client){
        $password = "acddadd";
        system('php ../app/console fos:user:create '.$client.' '.htmlspecialchars($_POST['mail']).' '.$password);
        system('php ../app/console fos:user:promote '.$client.' ROLE_CLIENT');
        return $this->redirect($this->generateUrl('sss_audit_audit_index'));

    }

    private function auditsToPrint($update){
        $audits = array();
        if(isset($_POST['ergo']) || in_array('ergo', $update)){
            array_push($audits, Audit::ERGO);
        }
        if(isset($_POST['access']) || in_array('access', $update)){
            array_push($audits, Audit::ACCESS);
        }
        if(isset($_POST['compa']) || in_array('compa', $update)){
            array_push($audits, Audit::COMPA);
        }
        if(isset($_POST['fct']) || in_array('fct', $update)){
            array_push($audits, Audit::FCT);
        }
        return $audits;
    }

    public function notificationsAction(){
        $user = $this->get('security.context')->getToken()->getUser();
        $notifs = $this->getDoctrine()->getManager()->getRepository('SSSUserBundle:Notification')->getNotifs($user);
        $length = count($notifs);
        for($i =0; $i < $length; $i++){
            $notifs[$i]->setNew(false);
        }
        $this->getDoctrine()->getManager()->flush();
        return $this->render('SSSUserBundle:Notifs:notification.html.twig', array('notifs'=>$notifs));
    }
}

