<?php
require_once __DIR__.'/../src/StaticCache.php';

$options = array('root_dir' => __DIR__);
$cache = new StaticCache($options);

ob_start();
echo 'This page was cached at '.date('Y-m-d H:i:s');
$data = ob_get_clean();

/**
 * Simple checks to determine if a request should be cached or not.
 */
function OkToCache()
{
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
        case 'PUT':
            return false;
        case 'GET':
        case 'HEAD':
        default:
            continue;
    }

    if (headers_sent()) {
        // We have no clue what the headers should be, so abort caching
        return false;
    }

    foreach (headers_list() as $header) {
        if (preg_match('/^(HTTP\/[\d]+\.[\d]+|Status:)\s+([3-5][\d]+)\s*.*$/', $header)) {
            // Do not cache anything greater than 299
            return false;
        }
        if (0 === strpos($header, 'Location:')) {
            // Do not cache redirects
            return false;
        }
    }

    return true;
}

if (OkToCache()) {
    $key = substr($_SERVER['REQUEST_URI'], strlen(parse_url('/workspace/StaticCache/examples/', PHP_URL_PATH)));
    $cache->save($data, $key);
} else {
    echo 'This request will not be cached';
}

echo $data;