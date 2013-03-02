<?php

require "vendor/autoload.php";


$server = new \Cybits\Interactive\Console\Server;
$server->registerApplication('system', '\Cybits\Interactive\Application\System', true);
$server->launchApplication('system');
$server->run(
    function ($server) {
        $server->launchApplication('system');
    }
    );