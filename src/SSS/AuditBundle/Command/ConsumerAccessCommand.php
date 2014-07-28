<?php
namespace SSS\AuditBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SSS\AuditBundle\Work\AMQP\AMQPConsAccess;

class ConsumerAccessCommand extends ContainerAwareCommand{
    public function configure(){
        $this->setName('audit:consumer:access')
            ->setDescription('Script to treat every audit for access');
    }
    public function execute(InputInterface $input, OutputInterface $output){

        $container = $this->getContainer();
        $consumer = new AMQPConsAccess($container->get('doctrine.orm.entity_manager'));
        //var_dump($consumer);
        $consumer->receiveMessages();
        $consumer->close();
    }
}
