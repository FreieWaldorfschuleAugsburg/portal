<?php


namespace App\Helpers;

use App\Models\Procurat\ProcuratAbsence;
use App\Models\Procurat\ProcuratFollowup;
use App\Models\Procurat\ProcuratGroup;
use App\Models\Procurat\ProcuratPerson;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\FlysystemStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Psr\Http\Message\ResponseInterface;

/**
 * @return Client
 */
function createAPIClient(): Client
{
    $stack = HandlerStack::create();
    $stack->push(new CacheMiddleware(
        new GreedyCacheStrategy(
            new FlysystemStorage(
                new LocalFilesystemAdapter(getenv('procurat.cachePath'))
            ),
            30
        )
    ), 'cache');

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
 * @param ResponseInterface $response
 * @return mixed
 */
function decodeResponse(ResponseInterface $response): mixed
{
    return json_decode($response->getBody());
}

/**
 * @param object $rawAbsence
 * @return ProcuratAbsence
 */
function constructProcuratAbsence(object $rawAbsence): ProcuratAbsence
{
    // TODO check if properties are in object
    return new ProcuratAbsence($rawAbsence->id, $rawAbsence->personId, $rawAbsence->excused, $rawAbsence->note);
}

/**
 * @param array $response
 * @return ProcuratAbsence[]
 */
function constructProcuratAbsences(array $response): array
{
    $absences = [];
    foreach ($response as $absence) {
        $absences[] = constructProcuratAbsence($absence);
    }
    return $absences;
}

/**
 * @param object $rawGroup
 * @return ProcuratGroup
 */
function constructProcuratGroup(object $rawGroup): ProcuratGroup
{
    // TODO check if properties are in object
    return new ProcuratGroup($rawGroup->id, $rawGroup->name, $rawGroup->type, $rawGroup->grades, $rawGroup->schoolYear);
}

/**
 * @param array $response
 * @return ProcuratGroup[]
 */
function constructProcuratGroups(array $response): array
{
    $groups = [];
    foreach ($response as $group) {
        $groups[] = constructProcuratGroup($group);
    }
    return $groups;
}

function getAbsenceFollowUp(int $personId): ?ProcuratFollowup
{
    $client = createAPIClient();

    try {
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
    } catch (GuzzleException) {
    }

    return null;
}

function createAbsenceFollowUp(int $personId, string $reportedBy): void
{
    $client = createAPIClient();
    try {
        $client->post('followups', [
            'json' => [
                'dueDate' => date('Y-m-d') . 'T00:00:00Z',
                'assignedPersonId' => intval(getenv('absence.followUpUserId')),
                'subject' => 'Schüler/in fehlt',
                'message' => 'Von ' . $reportedBy . ' um ' . date('H:i') . ' fehlend gemeldet',
                'referencedPersonId' => $personId
            ]
        ]);
    } catch (GuzzleException) {
    }
}

/**
 * @return ProcuratAbsence[]
 */
function getProcuratAbsences(): array
{
    $client = createAPIClient();

    try {
        $response = decodeResponse($client->get('absences?type=today'));
        return constructProcuratAbsences($response);
    } catch (GuzzleException $e) {
        return [];
    }
}

/**
 * @return ProcuratAbsence[]
 */
function getProcuratAbsencesByGroup(int $groupId): array
{
    $client = createAPIClient();

    try {
        $response = decodeResponse($client->get('absences/group/' . $groupId . '?type=today'));
        return constructProcuratAbsences($response);
    } catch (GuzzleException) {
        return [];
    }
}

/**
 * @param int $id
 * @return ?ProcuratGroup
 */
function getProcuratGroup(int $id): ?ProcuratGroup
{
    $client = createAPIClient();

    try {
        $response = decodeResponse($client->get('groups/' . $id));
        return constructProcuratGroup($response);
    } catch (GuzzleException) {
        return null;
    }
}

/**
 * @param int $id
 * @return ProcuratGroup[]
 */
function getProcuratGroupsByPersonId(int $id): array
{
    $client = createAPIClient();

    try {
        $response = decodeResponse($client->get('groups?memberId=' . $id));
        return constructProcuratGroups($response);
    } catch (GuzzleException) {
        return [];
    }
}

/**
 * @param int $id
 * @return ProcuratPerson[]
 */
function getProcuratGroupMembers(int $id): array
{
    $client = createAPIClient();
    $persons = [];

    try {
        $response = decodeResponse($client->get('groups/' . $id . '/members'));
        foreach ($response as $membership) {
            $persons[] = getProcuratPerson($membership->personId);
        }
    } catch (GuzzleException) {
    }

    return $persons;
}

function getGroupNameOverride(int $groupId): ?string
{
    return getenv('procurat.groupNameOverride.' . $groupId);
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

/**
 * @param int $id
 * @return ?string
 */
function getProcuratPersonGrade(int $id): ?string
{
    $groups = getProcuratGroupsByPersonId($id);
    foreach ($groups as $group) {
        if ($group->getType() != 'class') continue;
        if ($group->getSchoolYear() != getenv('procurat.currentSchoolYear')) continue;

        $grades = $group->getGrades();
        if (count($grades) > 1) continue;
        return $group->getName();
    }

    return null;
}

/**
 * @param int $id
 * @return ?string
 */
function getProcuratPersonGradeId(int $id): ?string
{
    $groups = getProcuratGroupsByPersonId($id);
    foreach ($groups as $group) {
        if ($group->getType() != 'class') continue;
        if ($group->getSchoolYear() != getenv('procurat.currentSchoolYear')) continue;

        $grades = $group->getGrades();
        if (count($grades) > 1) continue;
        return $grades[0];
    }

    return null;
}



