<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

class ViaCepClient
{
    /** @return array<string, mixed> */
    public function find(string $cep): array
    {
        $url = sprintf('https://viacep.com.br/ws/%s/json/', rawurlencode($cep));
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 5,
                'header' => "Accept: application/json\r\nUser-Agent: ApiCep/1.0\r\n",
            ],
        ]);

        $json = @file_get_contents($url, false, $context);

        if ($json === false) {
            throw new RuntimeException('Não foi possível consultar o serviço de CEP no momento.');
        }

        try {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            throw new RuntimeException('Resposta inválida do serviço de CEP.', previous: $exception);
        }

        if (!is_array($data)) {
            throw new RuntimeException('Resposta inválida do serviço de CEP.');
        }

        return $data;
    }
}
