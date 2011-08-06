--TEST--
Basic functionality
--FILE--
<?php

require __DIR__ . '/setup.inc';

$requestURI = '/testfile.txt';
$expectedFile = __DIR__ . '/testfile.txt';

$cache->setOptions(array('update_files'=>false));

file_put_contents($expectedFile, 'NOT THIS DATA');

try {
    $cache->save($data, $requestURI);
    throw new Exception('SALTY');
} catch (Exception $e) {
	if ($e->getMessage() != "The file $expectedFile already exists. Set update_files=>true or empty the cache") {
		echo 'It should have failed';
	}
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