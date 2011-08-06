--TEST--
Basic get functionality
--FILE--
<?php

require __DIR__ . '/setup.inc';

$requestURI = '/testfile.txt';

if ($cache->get($requestURI)) {
	echo 'No data should be there';
}

$expectedFile = __DIR__ . '/testfile.txt';

file_put_contents($expectedFile, $data);

$data = $cache->get($requestURI);

if (false === $data) {
	echo 'Could not retrieve data';
}

if ($data != 'TEST') {
	echo 'Data was incorrect';
} 

?>
==done==
--CLEAN--
<?php
if (file_exists(__DIR__ . '/testfile.txt')) {
    unlink(__DIR__ . '/testfile.txt');
}
?>
--EXPECT--
==done==