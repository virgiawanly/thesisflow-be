<?php

namespace App\Services;

use App\Repositories\BaseResourceRepository;

class BaseResourceService
{
    /**
     * Base resource repository instance.
     *
     * @var \App\Repositories\BaseResourceRepository
     */
    public BaseResourceRepository $repository;

    /**
     * Create a new service instance.
     *
     * @param \App\Repositories\BaseResourceRepository $repository
     */
    public function __construct(BaseResourceRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * The default per page.
     *
     * @var int
     */
    protected int $defaultPerPage = 10;

    /**
     * Get repository instance.
     *
     * @return \App\Repositories\BaseResourceRepository
     */
    public function repository(): BaseResourceRepository
    {
        return $this->repository;
    }

    /**
     * Get all resources.
     *
     * @param  array $queryParams
     * @param  array $relations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list(array $queryParams, array $relations = [])
    {
        return $this->repository->list($queryParams, $relations);
    }

    /**
     * Get paginated resources.
     *
     * @param  array $queryParams
     * @param  array $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginatedList(array $queryParams, array $relations = [])
    {
        $perPage = $queryParams['per_page'] ?? $this->defaultPerPage;
        return $this->repository->paginatedList($perPage, $queryParams, $relations);
    }

    /**
     * Get a resource by id.
     *
     * @param  int $id
     * @param  array $relations
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find(int $id, array $relations = [])
    {
        return $this->repository->find($id, $relations);
    }

    /**
     * Create a new resource.
     *
     * @param array $payload
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(array $payload)
    {
        return $this->repository->save($payload);
    }

    /**
     * Update a resource.
     *
     * @param int $id
     * @param array $payload
     */
    public function patch(int $id, array $payload)
    {
        return $this->repository->update($id, $payload);
    }

    /**
     * Delete a resource.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}
