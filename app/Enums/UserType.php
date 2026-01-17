<?php

namespace App\Enums;

enum UserType: string
{
    case SYSTEM_ADMIN = 'system_admin';
    case PROGRAM_STUDY_ADMIN = 'program_study_admin';
    case LECTURER = 'lecturer';
    case STUDENT = 'student';
}
