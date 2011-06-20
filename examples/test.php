<?php
require_once __DIR__.'/../src/StaticCache.php';

$options = array('root_dir' => __DIR__);
$cache = new StaticCache($options);


$key = substr($_SERVER['REQUEST_URI'], strlen(parse_url('/workspace/StaticCache/examples/', PHP_URL_PATH)));

if ($data = $cache->get($key)) {
    echo 'Got from cache';
} else {
    $data = $key.' cached at '.date('Y-m-d H:i:s');
    $cache->save($data, $key);
}
echo $data;