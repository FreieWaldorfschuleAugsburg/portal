<?php

namespace App\Helpers;

use App\Models\Procurat\ProcuratGroup;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * @return ProcuratGroup[]
 * @throws GuzzleException
 */
function getAbsenceGroups(Client $client): array
{
    $groups = [];
    foreach (explode(',', getenv('absence.groupIds')) as $groupIdString) {
        $groups[] = getProcuratGroup($client, intval($groupIdString));
    }
    return $groups;
}