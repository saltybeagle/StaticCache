<?php
require_once __DIR__ . '/../src/StaticCache.php';

if (!isset($class)) {
	$class = 'StaticCache';
}

$cache = new $class(array('root_dir'=>__DIR__));
$data = 'TEST';
