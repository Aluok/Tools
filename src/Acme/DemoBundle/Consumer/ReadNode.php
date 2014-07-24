<?php

// src/Acme/DemoBundle/Consumer/ReadNode.php

namespace Acme\DemoBundle\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use PhpAmqpLib\Connection\AMQPConnection;

class ReadNode implements ConsumerInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(AMQPMessage $msg)
    {



          echo ' [x] ', $msg->body, "\n";

    }
}
