<?php
// default route (homepage)
define('default_ctrl','demo');

// optional: custom 404
define('default_404','notFound');

\Neoan3\Core\Event::listen('Core\\Api::incoming', function($ev){
    if(isset($_SERVER['HTTP_ORIGIN'])){
        $allowed = ['http://localhost:8080','http://localhost:8081'];
        $port = $_SERVER['HTTP_ORIGIN'];
        if(in_array($port, $allowed)){
            header("Access-Control-Allow-Origin: ".$port);
        }
    }
});