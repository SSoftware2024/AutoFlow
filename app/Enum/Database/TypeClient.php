<?php
namespace App\Enum\Database;

enum TypeClient: string
{
    case CLIENT = 'client';
    case DRIVING_SCHOOL_STUDENT = 'driving_school_student';
    case DRIVING_SCHOOL_TEACHER = 'driving_school_teacher';
}
