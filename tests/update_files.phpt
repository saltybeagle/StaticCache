--TEST--
Basic functionality
--FILE--
<?php

require __DIR__ . '/setup.inc';

$requestURI = '/testfile.txt';
$expectedFile = __DIR__ . '/testfile.txt';

$cache->setOptions(array('update_files'=>true));

file_put_contents($expectedFile, 'NOT THIS DATA');

include __DIR__ . '/expect_save.inc';

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