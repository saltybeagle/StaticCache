<?php
if ($cache->requestIsCacheable($_GET, $_POST, $_FILES, $_SERVER)) {
    echo 'Should have failed';
}