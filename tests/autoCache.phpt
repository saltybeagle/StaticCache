--TEST--
Test StaticCache::autoCache() for basic functionality
--ENV--
return <<<END
REQUEST_URI=/testfile.txt
SCRIPT_NAME=/autoCache.php
END;
--FILE--
<?php
require_once __DIR__ . '/../src/StaticCache.php';
// sometimes the ENV SCRIPT_NAME doesn't get set correctly
$_SERVER['SCRIPT_NAME'] = '/autoCache.php';
StaticCache::autoCache(array('root_dir'=>__DIR__));
?>
==done==
--CLEAN--
<?php
if (!file_exists(__DIR__ . '/testfile.txt')) {
	echo "File should have been there, but it wasn't!";
}
unlink(__DIR__ . '/testfile.txt');
?>
--EXPECT--
==done==