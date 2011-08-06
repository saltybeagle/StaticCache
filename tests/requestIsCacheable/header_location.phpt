--TEST--
Tests for the StaticCache::requestIsCacheable()
--FILE--
<?php
require_once __DIR__ . '/../../src/StaticCache.php';

class HeadersTest extends StaticCache
{
    function getResponseHeaders()
    {
        return array('Location: http://www.example.com/');
    }
}

$class = 'HeadersTest';
require __DIR__ . '/../setup.inc';

include __DIR__ . '/expect_fail.inc';

?>
==done==
--EXPECT--
==done==