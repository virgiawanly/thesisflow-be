<?php

namespace App\Enums;

enum SubmissionStatus: string
{
    case DRAFT = 'DRAFT';
    case DIAJUKAN = 'DIAJUKAN';
    case DIREVIEW = 'DIREVIEW';
    case DITUGASKAN = 'DITUGASKAN';
    case DIBATALKAN = 'DIBATALKAN';
}
