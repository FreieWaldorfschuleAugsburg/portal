<?php

use App\Entities\AbsenceGrade;
use App\Entities\AbsenceStudent;
use App\Models\AbsenceGradeModel;
use App\Models\AbsenceModel;
use App\Models\AbsenceStudentModel;

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

function getAbsenceStudentModel(): AbsenceStudentModel
{
    return new AbsenceStudentModel();
}

function getAbsenceModel(): AbsenceModel
{
    return new AbsenceModel();
}