<?php

require_once __DIR__ . '/../vendor/autoload.php';
use SSS\AuditBundle\Work\AMQP\AMQPConsFct;

$consumer = new AMQPConsFct();
//var_dump($consumer);
$consumer->receiveMessages();
$consumer->close();

?>
