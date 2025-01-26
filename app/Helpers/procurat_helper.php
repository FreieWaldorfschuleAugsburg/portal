<?php


namespace App\Helpers;

use App\Models\Procurat\ProcuratAbsence;
use App\Models\Procurat\ProcuratFollowup;
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

function getAbsenceFollowUp(int $personId): ?ProcuratFollowup
{
    $client = createAPIClient();
    $response = decodeResponse($client->get('followups/persons/' . $personId));
    foreach ($response as $followup) {
        if ($followup->subject == 'Schüler/in fehlt'
            && !$followup->completed
            && str_starts_with($followup->dueDate, date('Y-m-d'))) {
            return new ProcuratFollowup(
                $followup->id,
                $followup->dueDate,
                $followup->assignedPersonId,
                $followup->subject,
                $followup->message,
                $followup->referencedPersonId,
                $followup->completed);
        }
    }
    return null;
}

function createAbsenceFollowUp(int $personId, string $reportedBy): void
{
    $client = createAPIClient();
    $client->post('followups', [
        'json' => [
            'dueDate' => date('Y-m-d') . 'T00:00:00Z',
            'assignedPersonId' => intval(getenv('absence.followUpUserId')),
            'subject' => 'Schüler/in fehlt',
            'message' => 'Von ' . $reportedBy . ' um ' . date('H:i') . ' fehlend gemeldet',
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