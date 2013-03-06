<?php

require "vendor/autoload.php";


$storage = new \Cybits\Interactive\Storage\SqliteStorage(__DIR__ . '/storage.sqlite');
$server = new \Cybits\Interactive\Console\Server($storage);
$server->registerApplication('system', '\Cybits\Interactive\Application\System', true);
$server->launchApplication('system');
$server->run(
    function ($server) {
        $server->launchApplication('system');
    }
);