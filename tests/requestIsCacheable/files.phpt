--TEST--
Tests for the StaticCache::requestIsCacheable()
--FILE--
<?php
require __DIR__ . '/../setup.inc';

$_FILES[0] = 'l';

include __DIR__ . '/expect_fail.inc';

?>
==done==
--EXPECT--
==done==