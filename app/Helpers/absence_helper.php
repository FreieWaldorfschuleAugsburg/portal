<?php

use App\Entities\Absence;
use App\Entities\AbsenceGrade;
use App\Entities\AbsenceGroup;
use App\Entities\AbsenceStudent;
use App\Models\AbsenceGradeModel;
use App\Models\AbsenceGroupModel;
use App\Models\AbsenceMemberModel;
use App\Models\AbsenceModel;
use App\Models\AbsenceStudentModel;
use Config\Database;

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