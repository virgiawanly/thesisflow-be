<?php

namespace App\Services;

use App\Models\Student;
use Illuminate\Support\Facades\Log;

class SISIntegrationService
{
    /**
     * Sync student data by id.
     * 
     * @todo Implement the logic to sync student data from SIS.
     * @param int $studentId
     * @return \App\Models\Student|null
     */
    public static function syncStudentWithSIS(int $studentId)
    {
        $student = Student::findOrFail($studentId);

        Log::info('Syncing student data from SIS', ['student_id' => $studentId]);

        // TODO: Implement the logic to sync student data from SIS.

        Log::info('Student data synced from SIS', ['student_id' => $studentId]);

        return $student;
    }
}
