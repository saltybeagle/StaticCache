--TEST--
Tests for the StaticCache::requestIsCacheable()
--FILE--
<?php
require __DIR__ . '/../setup.inc';

$_SERVER['REQUEST_METHOD'] = 'GET';

include __DIR__ . '/expect_true.inc';

?>
==done==
--EXPECT--
==done==