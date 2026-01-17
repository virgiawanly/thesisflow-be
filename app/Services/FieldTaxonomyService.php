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

    /**
     * Get the repository instance.
     *
     * @return \App\Repositories\FieldTaxonomyRepository
     */
    public function repository(): FieldTaxonomyRepository
    {
        return $this->repository;
    }

    /**
     * Get paginated nested resources.
     *
     * @param  array $queryParams
     * @param  array $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedNestedList(array $queryParams, array $relations = [])
    {
        $perPage = $queryParams['per_page'] ?? $this->defaultPerPage;
        return $this->repository()->getPaginatedNestedList($perPage, $queryParams, $relations);
    }
}
