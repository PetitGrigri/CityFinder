<?php
$m = new \Memcached();
$m->addServer('localhost', 11212);
$token1 = $m->get('test');

var_dump($token1);

$token1 = $m->set('test', 'coucou');

$token1 = $m->get('test');

var_dump($token1);

?>