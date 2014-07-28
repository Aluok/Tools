<?php
//exemple sur compa.

namespace SSS\AuditBundle\Tests\Work;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use SSS\AuditBundle\Work\AJAX;

class AJAXTest extends WebTestCase{
    public function testCalculateIndex(){
        $ajax = new AJAX('em');
        $this->assertNull($ajax->calculateIndex());
        $ajax->setErgo(true)
            ->setAccess(true)
            ->setCompa(true)
            ->setFct(true);
        $this->assertEquals(4, $ajax->calculateIndex());
        $this->assertEquals(3, $ajax->setErgo(false)->calculateIndex());
    }
    public function initiateGeneral(){
        $ajax = new AJAX('em');

        $audit = new Audit();
        $audit->setClient('killian')
            ->setCommentaire('this is a comment')
            ->setAuditeur(2);
        $this->assertEquals($audit, $ajax->initiateGeneral(array("client"=>'killian', "commentaire"=> 'this is a comment'), 2, 0));
    }
}
