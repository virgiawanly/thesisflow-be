<?php

namespace App\Repositories;

use App\Models\ThesisSubmission;

class ThesisSubmissionRepository extends BaseResourceRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new ThesisSubmission();
    }
}
