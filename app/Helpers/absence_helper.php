<?php

namespace App\Helpers;

use App\Entities\Absence;
use App\Entities\AbsenceGrade;
use App\Entities\AbsenceGroup;
use App\Entities\AbsenceMember;
use App\Entities\AbsenceStudent;
use App\Models\AbsenceGradeModel;
use App\Models\AbsenceGroupModel;
use App\Models\AbsenceMemberModel;
use App\Models\AbsenceModel;
use App\Models\AbsenceStudentModel;
use Config\Database;
use DateTime;
use DateTimeImmutable;

/**
 * @param int $id
 * @return ?AbsenceGrade
 */
function getGradeById(int $id): ?object
{
    return getAbsenceGradeModel()->find($id);
}

/**
 * @return AbsenceGrade[]
 */
function getGrades(): array
{
    return getAbsenceGradeModel()->findAll();
}

function getAbsenceGradeModel(): AbsenceGradeModel
{
    return new AbsenceGradeModel();
}

/**
 * @param string $id
 * @return ?AbsenceGroup
 */
function getAbsenceGroupById(string $id): ?object
{
    return getAbsenceGroupModel()->find($id);
}

function insertAbsenceGroup(string $id, string $name, array $students): void
{
    $group = new AbsenceGroup();
    $group->setId($id);
    $group->setName($name);

    getAbsenceGroupModel()->save($group);

    foreach ($students as $student) {
        insertAbsenceGroupMember($id, $student);
    }
}

function updateAbsenceGroup(string $id, string $name, array $students): void
{
    $group = getAbsenceGroupById($id);
    if ($group->getName() != $name) {
        $group->setName($name);
        getAbsenceGroupModel()->save($group);
    }

    $currentMembers = getAbsenceGroupMembers($id);
    foreach ($students as $student) {
        $isMember = false;
        foreach ($currentMembers as $member) {
            if ($member->getStudentId() == $student) {
                $isMember = true;
            }
        }

        if (!$isMember) {
            insertAbsenceGroupMember($id, $student);
        }
    }

    foreach ($currentMembers as $member) {
        if (!in_array($member->getStudentId(), $students)) {
            deleteAbsenceGroupMember($id, $member->getStudentId());
        }
    }
}

function deleteAbsenceGroup(string $id)
{
    getAbsenceGroupModel()->delete($id);
}

/**
 * @return AbsenceGroup[]
 */
function getAbsenceGroups(): array
{
    return getAbsenceGroupModel()->findAll();
}

function getAbsenceGroupModel(): AbsenceGroupModel
{
    return new AbsenceGroupModel();
}

/**
 * @param string $id
 * @return AbsenceMember[]
 */
function getAbsenceGroupMembers(string $id): array
{
    return getAbsenceMemberModel()->where(['group_id' => $id])->findAll();
}

/**
 * @param string $id
 * @return AbsenceStudent[]
 */
function getAbsenceGroupStudents(string $id): array
{
    $models = getAbsenceGroupMembers($id);
    $students = [];
    foreach ($models as $model) {
        $students[] = getStudent($model->getStudentId());
    }
    return $students;
}

function isAbsenceGroupMember(string $groupId, int $studentId): bool
{
    return getAbsenceMemberModel()->where(['group_id' => $groupId, 'student_id' => $studentId])->countAllResults() > 0;
}

function insertAbsenceGroupMember(string $groupId, int $studentId): void
{
    $member = new AbsenceMember();
    $member->setGroupId($groupId);
    $member->setStudentId($studentId);
    getAbsenceMemberModel()->insert($member);
}

function deleteAbsenceGroupMember(string $groupId, int $studentId): void
{
    getAbsenceMemberModel()->where(['group_id' => $groupId, 'student_id' => $studentId])->delete();
}

function getAbsenceMemberModel(): AbsenceMemberModel
{
    return new AbsenceMemberModel();
}

function removeAllStudents(): void
{
    Database::connect()->table('portal_absences_students')->truncate();
}

function insertStudent(int $id, string $firstName, string $lastName, int $gradeId): void
{
    $student = new AbsenceStudent();
    $student->setId($id);
    $student->setFirstName($firstName);
    $student->setLastName($lastName);
    $student->setGradeId($gradeId);

    getAbsenceStudentModel()->insert($student);
}

/**
 * @param int $gradeId
 * @return AbsenceStudent[]
 */
function getStudents(int $gradeId): array
{
    $students = getAbsenceStudentModel()->where('grade_id', $gradeId)->findAll();
    usort($students, fn($a, $b) => strcmp($a->getLastName(), $b->getLastName()));
    return $students;
}

/**
 * @return AbsenceStudent[]
 */
function getAllStudents(): array
{
    return getAbsenceStudentModel()->orderBy('last_name', 'ASC')->findAll();
}

function countStudents(): int
{
    return getAbsenceStudentModel()->countAllResults();
}

/**
 * @param int $id
 * @return ?AbsenceStudent
 */
function getStudent(int $id): ?object
{
    return getAbsenceStudentModel()->find($id);
}

function getAbsenceStudentModel(): AbsenceStudentModel
{
    return new AbsenceStudentModel();
}

/**
 * @param string $delta
 * @return Absence[]
 */
function getAbsences(string $delta): array
{
    $now = new DateTimeImmutable();
    $end = $now->modify($delta);

    return getAbsenceModel()->where([
        'reported_at >=' => $end->format('Y-m-d H:i:s'),
        'reported_at <=' => $now->format('Y-m-d H:i:s'),
        'reported_by !=' => 'Import'])->findAll();
}

/**
 * @param DateTime $dateTime
 * @return Absence[]
 */
function getAbsencesByDate(DateTime $dateTime): array
{
    return getAbsenceModel()->where('absence_date', $dateTime->format('Y-m-d'))->orderBy('reported_at', 'DESC')->findAll();
}

/**
 * @return ?Absence
 */
function getFirstImportedAbsence(): ?object
{
    return getAbsenceModel()->where('reported_by', 'Import')->select('reported_at')->first();
}

/**
 * @param Absence[] $absences
 * @param int $studentId
 * @return ?Absence
 */
function getAbsence(array $absences, int $studentId): ?Absence
{
    foreach ($absences as $absence) {
        if ($absence->getStudentId() == $studentId)
            return $absence;
    }

    return null;
}

function removeAllAbsences(): void
{
    Database::connect()->table('portal_absences')->truncate();
}

function insertAbsence(int $studentId, DateTime $date, string $reportedBy, DateTime $reportedAt, string $note): void
{
    $absence = new Absence();
    $absence->setStudentId($studentId);
    $absence->setAbsenceDate($date);
    $absence->setReportedBy($reportedBy);
    $absence->setReportedAt($reportedAt);
    $absence->setNote($note);

    getAbsenceModel()->insert($absence);
}

function getAbsenceModel(): AbsenceModel
{
    return new AbsenceModel();
}