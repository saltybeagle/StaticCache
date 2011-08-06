--TEST--
Test constructor
--FILE--
<?php
require_once __DIR__ . '/../src/StaticCache.php';

chdir(__DIR__);
$cache = new StaticCache();
$get_options = $cache->getOptions();
if ($get_options['root_dir'] !== __DIR__) {
	echo 'root_dir should be current working directory';
}

$options = array('root_dir'=>__DIR__);

$cache = new StaticCache($options);

$get_options = $cache->getOptions();

if ($get_options['root_dir'] != $options['root_dir']) {
	echo 'Wrong root dir';
}

?>
==done==
--EXPECT--
==done==