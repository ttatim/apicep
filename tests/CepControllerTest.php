<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/HttpResponse.php';
require_once __DIR__ . '/../src/ViaCepClient.php';
require_once __DIR__ . '/../src/CepController.php';

use App\CepController;
use App\ViaCepClient;

$controller = new CepController(new class extends ViaCepClient {
    public function find(string $cep): array
    {
        return $cep === '01001000'
            ? ['cep' => '01001-000', 'logradouro' => 'Praça da Sé', 'bairro' => 'Sé', 'localidade' => 'São Paulo', 'uf' => 'SP']
            : ['erro' => true];
    }
});

$valid = $controller->show('01001-000');
assert($valid->status === 200);
assert($valid->body['localidade'] === 'São Paulo');
assert($controller->show('123')->status === 422);
assert($controller->show('99999999')->status === 404);

echo "OK\n";
