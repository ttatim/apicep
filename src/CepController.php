<?php

declare(strict_types=1);

namespace App;

use RuntimeException;

final readonly class CepController
{
    public function __construct(private ViaCepClient $client)
    {
    }

    public function show(string $cep): HttpResponse
    {
        $normalizedCep = preg_replace('/\D/', '', $cep) ?? '';

        if (strlen($normalizedCep) !== 8) {
            return new HttpResponse(422, [
                'erro' => true,
                'mensagem' => 'CEP inválido. Informe exatamente 8 dígitos.',
            ]);
        }

        try {
            $address = $this->client->find($normalizedCep);
        } catch (RuntimeException $exception) {
            return new HttpResponse(503, [
                'erro' => true,
                'mensagem' => $exception->getMessage(),
            ]);
        }

        if (($address['erro'] ?? false) === true) {
            return new HttpResponse(404, [
                'erro' => true,
                'mensagem' => 'CEP não encontrado.',
            ]);
        }

        return new HttpResponse(200, [
            'erro' => false,
            'cep' => $address['cep'] ?? $normalizedCep,
            'logradouro' => $address['logradouro'] ?? '',
            'complemento' => $address['complemento'] ?? '',
            'bairro' => $address['bairro'] ?? '',
            'localidade' => $address['localidade'] ?? '',
            'uf' => $address['uf'] ?? '',
            'estado' => $address['estado'] ?? '',
            'regiao' => $address['regiao'] ?? '',
            'ibge' => $address['ibge'] ?? '',
            'gia' => $address['gia'] ?? '',
            'ddd' => $address['ddd'] ?? '',
            'siafi' => $address['siafi'] ?? '',
        ]);
    }
}
