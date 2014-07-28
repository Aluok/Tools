<?php
//exemple sur compa.

namespace SSS\AuditBundle\Work\AMQP;


use PhpAmqpLib\Connection\AMQPConnection;


class AMQPConsCompa{


    private $connection;
    private $channel;
    private $queue_name;

    public function __construct(){
        $this->connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();

        $this->channel->exchange_declare('audit1', 'topic', false, false, false);
        $this->configure();
    }
    private function configure(){
        list($this->queue_name, ,) = $this->channel->queue_declare("", false, false, true, false);


       $this->channel->queue_bind($this->queue_name, 'audit1', "*.compa.*.*");


    }
    public function receiveMessages(){
        echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";


        $callback = function($msg){
          echo ' [x] ',$msg->delivery_info['routing_key'], ':', $msg->body, "\n";
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
}
