<?php
require_once __DIR__.'/../src/StaticCache.php';
StaticCache::autoCache();

echo 'This page was cached at '.date('Y-m-d H:i:s');
