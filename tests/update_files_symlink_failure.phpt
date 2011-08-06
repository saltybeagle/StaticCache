--TEST--
Basic functionality
--FILE--
<?php

require __DIR__ . '/setup.inc';

$requestURI = '/testfile.txt';
$expectedFile = __DIR__ . '/testfile2.txt';
file_put_contents($expectedFile, 'NOT THIS DATA');

$link = __DIR__ . '/testfile.txt';
symlink($expectedFile, $link);

$cache->setOptions(array('update_files'=>true));


try {
    $cache->save($data, $requestURI);
    throw new Exception('SALTY');
} catch (Exception $e) {
	if ($e->getMessage() != "SECURITY ERROR: Will not write to $link as it is symlinked to $expectedFile - Possible symlink attack") {
		echo 'It should have failed';
		echo $e->getMessage();
	}
}

?>
==done==
--CLEAN--
<?php
if (file_exists(__DIR__ . '/testfile.txt')) {
    unlink(__DIR__ . '/testfile.txt');
    unlink(__DIR__ . '/testfile2.txt');
}
?>
--EXPECT--
==done==