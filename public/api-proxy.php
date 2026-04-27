<?php
// api-proxy.php - Conector con backend real
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

// Intentar conectar con Redis
$useRealBackend = false;

if (extension_loaded('redis')) {
    try {
        $redis = new Redis();
        $redis->connect('localhost', 6379, 1);
        $useRealBackend = true;
    } catch (Exception $e) {
        $useRealBackend = false;
    }
}

if ($useRealBackend) {
    // Datos reales desde Redis
    $response = [
        'random' => $redis->get('dv:random') ?? rand(1, 100),
        'temperature' => $redis->get('dv:temperature') ?? (15 + rand(0, 2000)/100),
        'humidity' => $redis->get('dv:humidity') ?? rand(30, 90),
        'online' => true,
        'source' => 'redis'
    ];
} else {
    // Datos simulados (demo)
    $response = [
        'random' => rand(1, 100),
        'temperature' => 15 + rand(0, 2000)/100,
        'humidity' => rand(30, 90),
        'online' => false,
        'source' => 'simulated'
    ];
}

echo json_encode($response);
