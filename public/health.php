<?php
header("Content-Type: application/json");
echo json_encode([
    "status" => "healthy",
    "timestamp" => time(),
    "version" => "4.0.0",
    "php_version" => PHP_VERSION
]);
