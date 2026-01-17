<?php

namespace App\Services;

use App\Enums\SubmissionStatus;
use App\Enums\ThesisPeriodStage;
use App\Exceptions\BadRequestException;
use App\Models\Student;
use App\Models\ThesisPeriod;
use App\Repositories\ThesisSubmissionRepository;

class ThesisSubmissionService extends BaseResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \App\Repositories\ThesisSubmissionRepository $thesisSubmissionRepository
     * @return void
     */
    public function __construct(ThesisSubmissionRepository $thesisSubmissionRepository)
    {
        parent::__construct($thesisSubmissionRepository);
    }

    /**
     * Check if the period stage is within the current period.
     *
     * @param string|ThesisPeriodStage $stage
     * @return bool
     */
    public function checkIsWithinPeriodStage(string|ThesisPeriodStage $stage)
    {
        if ($stage instanceof ThesisPeriodStage) {
            $stage = $stage->value;
        }

        return ThesisPeriod::where('stage', $stage)
            ->where('start_at', '<=', now())
            ->where('end_at', '>=', now())
            ->exists();
    }

    /**
     * Check if the student is eligible to submit thesis.
     *
     * @param int|Student $student
     * @return array<string, mixed>
     */
    public function checkStudentEligibility(int|Student $student)
    {
        if (!$student instanceof Student) {
            $student = Student::findOrFail($student);
        }

        $student->loadMissing(['programStudy.config']);
        if (empty($student->programStudy) || empty($student->programStudy->config)) {
            return [
                'is_eligible' => false,
                'reason' => 'Invalid program study',
            ];
        }

        $programStudyConfig = $student->programStudy->config;
        if (floatval($student->total_sks) < floatval($programStudyConfig->submission_min_sks)) {
            return [
                'is_eligible' => false,
                'reason' => 'Student does not meet the minimum SKS requirement (' . $programStudyConfig->submission_min_sks . ' SKS)',
            ];
        }

        if ($programStudyConfig->submission_require_financial_clear && strtoupper($student->status_keuangan) !== 'LANCAR') {
            return [
                'is_eligible' => false,
                'reason' => 'Student is not financial clear',
            ];
        }

        if (strtoupper($student->status_akademik) !== 'AKTIF') {
            return [
                'is_eligible' => false,
                'reason' => 'Student is not active',
            ];
        }

        return [
            'is_eligible' => true,
            'reason' => null,
        ];
    }

    /**
     * Save a student submission.
     * 
     * @param array $payload
     * @return \App\Models\ThesisSubmission
     * @throws \App\Exceptions\BadRequestException
     */
    public function saveStudentSubmission(array $payload)
    {
        $student = Student::findOrFail($payload['student_id']);

        // Check student eligibility
        $studentEligibility = $this->checkStudentEligibility($student);
        if (!$studentEligibility['is_eligible']) {
            throw new BadRequestException($studentEligibility['reason'] ?? 'Student is not eligible to submit thesis.');
        }

        // Check if the submission is within the active submission period
        $isWithinPeriodStage = $this->checkIsWithinPeriodStage(ThesisPeriodStage::PENGAJUAN->value);
        if (!$isWithinPeriodStage) {
            throw new BadRequestException('Submission is not allowed at this moment.');
        }

        // @todo: get active semester from user's selected semester during login
        $activeSemester = "2025/1";

        // Save submission
        $submission = $this->repository()->save([
            'student_id' => $payload['student_id'],
            'semester' => $activeSemester,
            'sumber' => $payload['sumber'],
            'topic_offer_id' => $payload['topic_offer_id'],
            'topik_kategori' => $payload['topik_kategori'],
            'judul' => $payload['judul'],
            'abstrak' => $payload['abstrak'],
            'keywords' => json_encode($payload['keywords']),
            'status' => SubmissionStatus::DIAJUKAN->value,
        ]);

        // Save eligibility snapshot
        $submission->eligibilitySnapshots()->create([
            'total_sks' => $student->total_sks,
            'ipk' => $student->ipk,
            'status_akademik' => $student->status_akademik,
            'status_keuangan' => $student->status_keuangan,
            'prasyarat_ok' => true, // @todo: check from prasyarat (next feature)
        ]);

        // Save submission prefs
        foreach ($payload['submission_prefs'] as $submissionPref) {
            $submission->submissionPrefs()->create([
                'lecturer_id' => $submissionPref['lecturer_id'],
                'urutan' => $submissionPref['urutan'],
            ]);
        }

        // Save matching scores
        $scoreCriteria = [
            // 'field_match_score' => 0, // 0 or 1 (false or true)
            'student_preference_score' => 0, // 1, 2, 3 (based on submission prefs)
            'lecturer_load_score' => 0, // more quota available, higher score
            'lecturer_interest_score' => 0, // 0 or 1 (false or true)
        ];

        foreach ($submission->submissionPrefs as $submissionPref) {
            $submissionPref->loadMissing(['lecturer']);

            $isTopicMatch = $submissionPref->lecturer
                ->topicOffers()
                ->where('bidang_id', $payload['topik_kategori'])
                ->exists();

            $lecturerQuota = $submissionPref->lecturer
                ->lecturerQuotas()
                ->where('semester', $activeSemester)
                ->value('kuota_max') ?? 0;
        }

        return;
    }
}
