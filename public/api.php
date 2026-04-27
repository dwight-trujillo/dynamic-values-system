<?php
declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use DynamicValues\Core\ValueManager;
use DynamicValues\Cache\RedisCache;
use DynamicValues\Security\RateLimiter;
use DynamicValues\Security\InputValidator;
use DynamicValues\DataSources\RandomDataSource;

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

try {
    $cache = new RedisCache(["127.0.0.1"]);
    $rateLimiter = new RateLimiter($cache);
    $validator = new InputValidator();
    $manager = new ValueManager($cache);

    $manager->registerSource(new RandomDataSource("random", "Random Number", 1, 100, 30));

    $clientIp = $_SERVER["REMOTE_ADDR"] ?? "unknown";
    
    if (!$rateLimiter->checkLimit($clientIp)) {
        http_response_code(429);
        echo json_encode(["error" => "Rate limit exceeded"]);
        exit;
    }

    $specificKey = $_GET["key"] ?? null;
    
    if ($specificKey) {
        if (!$validator->validateKey($specificKey)) {
            http_response_code(400);
            echo json_encode(["error" => "Invalid key format"]);
            exit;
        }
        $response = [$specificKey => $manager->getValue($specificKey)];
    } else {
        $response = $manager->getAllValues();
    }

    echo json_encode($response, JSSN_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal error"]);
}
