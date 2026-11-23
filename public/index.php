<?php

declare(strict_types=1);

use App\CepController;
use App\ViaCepClient;

require_once __DIR__ . '/../src/HttpResponse.php';
require_once __DIR__ . '/../src/ViaCepClient.php';
require_once __DIR__ . '/../src/CepController.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    header('Allow: GET, OPTIONS');
    echo json_encode(['erro' => true, 'mensagem' => 'Método não permitido.']);
    exit;
}

if (preg_match('#^/api/cep/([^/]+)$#', $path, $matches) !== 1) {
    http_response_code(404);
    echo json_encode(['erro' => true, 'mensagem' => 'Rota não encontrada. Use GET /api/cep/{cep}.']);
    exit;
}

$controller = new CepController(new ViaCepClient());
$response = $controller->show($matches[1]);

http_response_code($response->status);
echo json_encode($response->body, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
