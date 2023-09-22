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

/**
 * @param int $gradeId
 * @return AbsenceStudent[]
 */
function getStudents(int $gradeId): array
{
    return getAbsenceStudentModel()->where('grade_id', $gradeId)->findAll();
}

function getAbsenceStudentModel(): AbsenceStudentModel
{
    return new AbsenceStudentModel();
}

function getAbsenceModel(): AbsenceModel
{
    return new AbsenceModel();
}