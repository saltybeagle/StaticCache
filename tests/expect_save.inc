<?php
$cache->save($data, $requestURI);
if (!file_exists($expectedFile)) {
    echo 'File does not exist.';
}
$contents = file_get_contents($expectedFile);
if ($contents !== $data) {
    echo 'Data saved was incorrect';
}
