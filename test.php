<?php
$logPath = __DIR__ . '/storage/logs/laravel.log';
if (file_exists($logPath)) {
    $content = file_get_contents($logPath);
    echo substr($content, -2000);
} else {
    echo "Log not found.";
}
