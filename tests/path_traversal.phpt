--TEST--
Basic functionality
--FILE--
<?php

require __DIR__ . '/setup.inc';

$requestURI = '/../testfile.txt';

try {
    $cache->save($data, $requestURI);
    throw new Exception('SALTY');
} catch (Exception $e) {
    if ($e->getMessage() != "upper directory reference .. cannot be used") {
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