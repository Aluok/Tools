<?php
//exemple sur compa.

namespace SSS\AuditBundle\Work\AMQP;

use Symfony\Component\DependencyInjection\ContainerInterface;
use PhpAmqpLib\Connection\AMQPConnection;
use SSS\UserBundle\Entity\Notification;
use Symfony\Component\Security\Core\SecurityContext;

class AMQPConsAccess{

    private $em;
    private $connection;
    private $channel;
    private $queue_name;

    public function __construct($em){
        $this->em = $em;

        $this->connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();

        $this->channel->exchange_declare('audit1', 'topic', false, false, false);
        $this->configure();
    }
    private function configure(){
        list($this->queue_name, ,) = $this->channel->queue_declare("", false, false, true, false);


       $this->channel->queue_bind($this->queue_name, 'audit1', "*.*.access.*");


    }
    public function receiveMessages(){
        echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";


        $callback = function($msg){
            //var_dump($msg);
            $audit = $this->em->getRepository('SSSAuditBundle:Audit')->find(intval($msg->body));
            $message = 'Un audit d\'accessibilité pour le client : '.$audit->getClient().' à été commencé';
            //var_dump($audit);
            $user = $this->em->getRepository('SSSUserBundle:User')->find($audit->getAuditeur());
            $this->postNotif($message, Notification::INFO, $user);

            //echo ' [x] ',$msg->delivery_info['routing_key'], ':', $msg->body, "\n";
        };

        $this->channel->basic_consume($this->queue_name, '', false, true, false, false, $callback);


        while(count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
    public function close(){
        $this->channel->close();
        $this->connection->close();
    }
    private function postNotif($message, $type, $user){
        $notif = new Notification();

        $notif->setUser($user)
            ->setDate(new \Datetime())
            ->setMessage($message)
            ->setTypeNotif($type)
            ->setNew(true);
        //var_dump($this);
        $this->em->persist($notif);


        $this->em->flush();
        var_dump($notif);
    }
}
