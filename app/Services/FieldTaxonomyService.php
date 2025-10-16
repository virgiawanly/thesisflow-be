<?php

namespace App\Services;

use App\Repositories\FieldTaxonomyRepository;

class FieldTaxonomyService extends BaseResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \App\Repositories\FieldTaxonomyRepository $fieldTaxonomyRepository
     * @return void
     */
    public function __construct(FieldTaxonomyRepository $fieldTaxonomyRepository)
    {
        parent::__construct($fieldTaxonomyRepository);
    }
}
