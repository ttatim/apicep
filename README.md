# API CEP

API REST em PHP 8.3 puro para preencher automaticamente dados de endereço a partir de um CEP. A consulta é feita no serviço público [ViaCEP](https://viacep.com.br/).

## Executar localmente

```bash
php -S localhost:8000 -t public
```

## Consultar um CEP

```bash
curl http://localhost:8000/api/cep/01001-000
```

Resposta de sucesso (`200`):

```json
{
  "erro": false,
  "cep": "01001-000",
  "logradouro": "Praça da Sé",
  "complemento": "lado ímpar",
  "bairro": "Sé",
  "localidade": "São Paulo",
  "uf": "SP",
  "estado": "São Paulo",
  "regiao": "Sudeste",
  "ibge": "3550308",
  "gia": "1004",
  "ddd": "11",
  "siafi": "7107"
}
```

Erros retornam JSON e um status apropriado: `422` para CEP inválido, `404` para CEP inexistente e `503` se o serviço de consulta estiver indisponível.
