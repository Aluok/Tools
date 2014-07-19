<?php

namespace SSS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SSSUserBundle extends Bundle
{
    public function getParent(){
        return 'FOSUserBundle';
    }
}
