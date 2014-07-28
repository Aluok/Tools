<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPConnection;
use SSS\AuditBundle\Work\AMQP\AMQPConsAccess;

$consumer = new AMQPConsAccess();
//var_dump($consumer);
$consumer->receiveMessages();
$consumer->close();

?>
