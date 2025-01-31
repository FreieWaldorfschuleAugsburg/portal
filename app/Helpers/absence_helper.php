<?php

namespace App\Helpers;

use App\Models\Procurat\ProcuratAbsence;
use App\Models\Procurat\ProcuratGroup;

/**
 * @return ProcuratGroup[]
 */
function getAbsenceGroups(): array
{
    $groups = [];
    foreach (explode(',', getenv('absence.groupIds')) as $groupIdString) {
        $groups[] = getProcuratGroup(intval($groupIdString));
    }
    return $groups;
}

/**
 * @param ProcuratAbsence[] $absences
 * @param int $personId
 * @return ?ProcuratAbsence
 */
function filterAbsences(array $absences, int $personId): ?ProcuratAbsence
{
    foreach ($absences as $absence) {
        if ($absence->getPersonId() == $personId) {
            return $absence;
        }
    }
    return null;
}

function isHalfDayAbsence(ProcuratAbsence $absence): bool
{
    $lowercaseKeywords = mb_strtolower(getenv('absence.halfDayKeywords'));
    $lowercaseNote = mb_strtolower($absence->getNote());
    $keywords = explode(',', $lowercaseKeywords);

    foreach ($keywords as $keyword) {
        if (str_contains($lowercaseNote, $keyword)) {
            return true;
        }
    }

    return false;
}