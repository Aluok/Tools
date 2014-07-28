<?php

require_once __DIR__ . '/../vendor/autoload.php';
use SSS\AuditBundle\Work\AMQP\AMQPConsErgo;

$consumer = new AMQPConsErgo();
//var_dump($consumer);
$consumer->receiveMessages();
$consumer->close();

?>
