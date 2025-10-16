<?php

namespace App\Repositories;

use App\Models\FieldTaxonomy;

class FieldTaxonomyRepository extends BaseResourceRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new FieldTaxonomy();
    }
}
