<?php
declare(strict_types=1);

if (!defined('COLLECTIONS_VERSION')) {
    $path = __DIR__ . '/../../VERSION';
    $version = '';

    if (is_file($path)) {
        $contents = file_get_contents($path);
        if ($contents !== false) {
            $version = trim($contents);
        }
    }

    define('COLLECTIONS_VERSION', $version);
}
