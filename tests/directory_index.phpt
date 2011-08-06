--TEST--
Basic functionality
--FILE--
<?php

require __DIR__ . '/setup.inc';

$requestURI = '/dirname/';
$expectedFile = __DIR__ . '/dirname/index.html';

include __DIR__ . '/expect_save.inc';

?>
==done==
--CLEAN--
<?php
$expectedFile = __DIR__ . '/dirname/index.html';
if (file_exists($expectedFile)) {
    unlink($expectedFile);
    rmdir(dirname($expectedFile));
}
?>
--EXPECT--
==done==