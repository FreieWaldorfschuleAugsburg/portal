<?php


namespace App\Helpers;

use App\Models\Procurat\ProcuratAbsence;
use App\Models\Procurat\ProcuratGroup;
use App\Models\Procurat\ProcuratPerson;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * @return Client
 */
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

/**
 * @param ResponseInterface $response
 * @return mixed
 */
function decodeResponse(ResponseInterface $response): mixed
{
    return json_decode($response->getBody());
}

function createAbsence(int $personId, string $note): void
{
    $client = createAPIClient();
    $client->post('absences', [
        'json' => [
            'personId' => $personId,
            'startDate' => date('Y-m-d') . 'T00:00:00Z',
            'excused' => false,
            'parentsInformed' => false,
            'note' => $note
        ]
    ]);
}

function createAbsenceFollowUp(int $personId): void
{
    $client = createAPIClient();
    $client->post('followups', [
        'json' => [
            'dueDate' => date('Y-m-d'). 'T00:00:00Z',
            'assignedPersonId' => intval(getenv('absence.followUpUserId')),
            'subject' => 'Absenzen',
            'message' => 'Es liegt eine ungeprüfte Absenz vor!',
            'referencedPersonId' => $personId
        ]
    ]);
}

/**
 * @return ProcuratAbsence[]
 * @throws GuzzleException
 */
function getProcuratAbsences(): array
{
    $client = createAPIClient();
    $response = decodeResponse($client->get('absences?type=today'));

    $absences = [];
    foreach ($response as $absence) {
        $absences[] = new ProcuratAbsence($absence->id, $absence->personId, $absence->excused, $absence->note);
    }
    return $absences;
}

/**
 * @param int $id
 * @return ProcuratGroup
 * @throws GuzzleException
 */
function getProcuratGroup(int $id): ProcuratGroup
{
    $client = createAPIClient();
    $response = decodeResponse($client->get('groups/' . $id));
    return new ProcuratGroup($response->id, $response->name);
}

/**
 * @param int $id
 * @return ProcuratPerson
 * @throws GuzzleException
 */
function getProcuratPerson(int $id): ProcuratPerson
{
    $client = createAPIClient();
    $response = decodeResponse($client->get('persons/' . $id));
    return new ProcuratPerson($response->id, $response->firstName, $response->lastName);
}

/**
 * @param int $id
 * @return ProcuratPerson[]
 * @throws GuzzleException
 */
function getProcuratGroupMembers(int $id): array
{
    $client = createAPIClient();
    $response = decodeResponse($client->get('groups/' . $id . '/members'));
    $persons = [];
    foreach ($response as $membership) {
        $persons[] = getProcuratPerson($membership->personId);
    }
    return $persons;
}