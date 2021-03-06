--TEST--
Basic functionality
--FILE--
<?php

require __DIR__ . '/setup.inc';

$requestURI = '/dirname/file.txt';
$expectedFile = __DIR__ . '/dirname/file.txt';

include __DIR__ . '/expect_save.inc';

?>
==done==
--CLEAN--
<?php
$expectedFile = __DIR__ . '/dirname/file.txt';
if (file_exists($expectedFile)) {
    unlink($expectedFile);
    rmdir(dirname($expectedFile));
}
?>
--EXPECT--
==done==