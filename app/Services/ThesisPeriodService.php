<?php

namespace App\Services;

use App\Repositories\ThesisPeriodRepository;

class ThesisPeriodService extends BaseResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \App\Repositories\ThesisPeriodRepository $thesisPeriodRepository
     * @return void
     */
    public function __construct(ThesisPeriodRepository $thesisPeriodRepository)
    {
        parent::__construct($thesisPeriodRepository);
    }
}
