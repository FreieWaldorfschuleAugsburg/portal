<?php


namespace App\Helpers;

use App\Models\Procurat\ProcuratGroup;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

function createAPIClient(): Client
{
    return new Client([
        'base_uri' => getenv('procurat.endpoint'),
        'headers' => [
            'X-API-KEY' => getenv('procurat.apiKey'),
            'Accept' => 'application/json'
        ]
    ]);
}

function decodeResponse(ResponseInterface $response): mixed
{
    return json_decode($response->getBody());
}

/**
 * @throws GuzzleException
 */
function getProcuratGroup(Client $client, int $id): ProcuratGroup
{
    $response = decodeResponse($client->get('groups/' . $id));
    return new ProcuratGroup($response->id, $response->name);
}