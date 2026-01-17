<?php

namespace App\Repositories;

use App\Models\ThesisPeriod;

class ThesisPeriodRepository extends BaseResourceRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new ThesisPeriod();
    }
}
