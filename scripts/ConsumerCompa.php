<?php

require_once __DIR__ . '/../vendor/autoload.php';
use SSS\AuditBundle\Work\AMQP\AMQPConsCompa;

$consumer = new AMQPConsCompa();
//var_dump($consumer);
$consumer->receiveMessages();
$consumer->close();

?>
