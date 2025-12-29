<?php

use App\Models\ProcuratContactInformation;
use App\Models\ProcuratGroupMembership;
use App\Models\ProcuratPerson;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

/**
 * @return Client
 */
function createAPIClient(): Client
{
    $stack = HandlerStack::create();
    return new Client([
        'handler' => $stack,
        'base_uri' => getenv('procurat.endpoint'),
        'headers' => [
            'X-API-KEY' => getenv('procurat.apiKey'),
            'Accept' => 'application/json'
        ]
    ]);
}

/**
 * @param int $id
 * @return ?ProcuratPerson
 */
function getProcuratPerson(int $id): ?ProcuratPerson
{
    $client = createAPIClient();
    try {
        $response = decodeResponse($client->get('persons/' . $id));
        return new ProcuratPerson($response->id, $response->firstName, $response->lastName);
    } catch (GuzzleException) {
        return null;
    }
}

function findPersonIdByUsername(string $username): ?int
{
    $usernameUdf = getenv('procurat.usernameUdf');
    $memberships = getRootGroupMemberships();
    foreach ($memberships as $membership) {
        if (property_exists($membership->getData(), $usernameUdf) && $membership->getData()->{$usernameUdf} == $username) {
            return $membership->getPersonId();
        }
    }
    return null;
}

function findContactInformationByPersonId(int $personId, string $type, string $medium): ?string
{
    $information = getContactInformationByPersonId($personId);
    foreach ($information as $info) {
        if ($info->getType() == $type && $info->getMedium() == $medium) {
            return $info->getContent();
        }
    }
    return null;
}

function findContactInformationByMediumAndPersonId(int $personId, string $medium): array
{
    $content = [];
    $information = getContactInformationByPersonId($personId);
    foreach ($information as $info) {
        if ($info->getMedium() == $medium) {
            $content[] = $info->getContent();
        }
    }
    return $content;
}

/**
 * @return ProcuratGroupMembership[]
 */
function getRootGroupMemberships(): array
{
    return getGroupMembershipsByGroupId(intval(getenv('procurat.rootGroupId')));
}

/**
 * @param int $groupId
 * @return ProcuratGroupMembership[]
 */
function getGroupMembershipsByGroupId(int $groupId): array
{
    $client = createAPIClient();
    $memberships = [];
    try {
        $rawMemberships = decodeResponse($client->get('groups/' . $groupId . '/members'));
        foreach ($rawMemberships as $rawMembership) {
            $memberships[] = constructProcuratGroupMembership($rawMembership);
        }
    } catch (GuzzleException) {
    }
    return $memberships;
}

/**
 * @param int $personId
 * @return ProcuratContactInformation[]
 */
function getContactInformationByPersonId(int $personId): array
{
    $client = createAPIClient();
    $contactInformation = [];
    try {
        $rawContactInformation = decodeResponse($client->get('contactinformation/person/' . $personId));
        foreach ($rawContactInformation as $rawInformation) {
            $contactInformation[] = constructProcuratContactInformation($rawInformation);
        }
    } catch (GuzzleException) {
    }
    return $contactInformation;
}

/**
 * @param int $personId
 * @return int[]
 */
function getContactPersonIdsByPersonId(int $personId): array
{
    $client = createAPIClient();
    $contactPersonIds = [];
    try {
        $rawContacts = decodeResponse($client->get('communication/person/' . $personId . '/contacts'));
        foreach ($rawContacts as $rawContact) {
            $contactPersonIds[] = $rawContact->contactPersonId;
        }
    } catch (GuzzleException) {
    }
    return $contactPersonIds;
}


/**
 * @param object $raw
 * @return ProcuratGroupMembership
 */
function constructProcuratGroupMembership(object $raw): ProcuratGroupMembership
{
    return new ProcuratGroupMembership($raw->id, $raw->groupId, $raw->personId, $raw->jsonData);
}

/**
 * @param object $raw
 * @return ProcuratContactInformation
 */
function constructProcuratContactInformation(object $raw): ProcuratContactInformation
{
    return new ProcuratContactInformation($raw->id, $raw->type, $raw->medium, $raw->content);
}

/**
 * @param ResponseInterface $response
 * @return mixed
 */
function decodeResponse(ResponseInterface $response): mixed
{
    return json_decode($response->getBody());
}