<?php
/**
 * Health check endpoint pour Docker
 * Retourne un statut 200 si l'application fonctionne correctement
 */
header('Content-Type: application/json');

$health = [
    'status' => 'healthy',
    'timestamp' => date('Y-m-d H:i:s'),
    'service' => 'MyWeeklyAllowance',
    'version' => '1.0.0'
];

// Vérifier que les classes principales existent
$requiredFiles = [
    __DIR__ . '/../src/Parents.php',
    __DIR__ . '/../src/Account.php',
    __DIR__ . '/../src/Teenager.php',
    __DIR__ . '/../src/User.php'
];

foreach ($requiredFiles as $file) {
    if (!file_exists($file)) {
        $health['status'] = 'unhealthy';
        $health['error'] = 'Missing required file: ' . basename($file);
        http_response_code(503);
        break;
    }
}

http_response_code($health['status'] === 'healthy' ? 200 : 503);
echo json_encode($health, JSON_PRETTY_PRINT);

