<?php

// src/Acme/DemoBundle/SplitFile.php

namespace Acme\DemoBundle;

class SplitFile
{
    private $path;
    private $producer;

    public function __construct($path, $producer)
    {
        $this->path = $path;
        $this->producer = $producer;
    }

    public function process($argv)
    {

        $data = substr($argv, 19);
        if(empty($data)) $data = "Hello World!";
        echo 'sdq';
        $this->producer->publish($data);
        var_dump($data);
        echo " [x] Sent ", $data, "\n";
        $xmlReader->close();
    }
}
