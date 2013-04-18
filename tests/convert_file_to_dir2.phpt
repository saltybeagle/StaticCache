--TEST--
Test converting a file to a directory when file is many directories deep
--FILE--
<?php

require __DIR__ . '/setup.inc';

// First request a collection URI
$requestURI = '/testcollection2';
$expectedFile = __DIR__ . '/testcollection2';

include __DIR__ . '/expect_save.inc';

// Then request a specific resource inside that collection
$requestURI = '/testcollection2/parentresource/childresource';
$expectedFile = __DIR__ . '/testcollection2/parentresource/childresource';

include __DIR__ . '/expect_save.inc';

?>
==done==
--CLEAN--
<?php

$expectedFile = __DIR__ . '/testcollection2/parentresource/childresource';
if (file_exists($expectedFile)) {
    unlink($expectedFile);
    unlink(dirname($expectedFile).'/index.html');
    rmdir(dirname($expectedFile));
}

?>
--EXPECT--
==done==