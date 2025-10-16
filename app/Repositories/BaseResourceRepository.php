<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class BaseResourceRepository
{
    /**
     * The model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected Model $model;

    /**
     * Get a list of resources.
     * 
     * @param array $params
     * @param array $relations
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function list(array $params = [], array $relations = [])
    {
        return $this->model
            ->with($relations)
            ->when(method_exists($this->model, 'scopeSearch'), function ($query) use ($params) {
                $query->search($params['search'] ?? '', $params['searchable_columns'] ?? []);
            })
            ->when(method_exists($this->model, 'scopeOfOrder'), function ($query) use ($params) {
                $query->ofOrder($params['order_by'] ?? 'created_at', $params['order_direction'] ?? 'desc');
            })
            ->when(method_exists($this->model, 'scopeFilter'), function ($query) use ($params) {
                $query->filter($params['filters'] ?? []);
            })
            ->get();
    }

    /**
     * Get a paginated list of resources.
     *
     * @param array $params
     * @param array $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginatedList(int $perPage, array $params = [], array $relations = [])
    {
        return $this->model
            ->with($relations)
            ->when(method_exists($this->model, 'scopeSearch'), function ($query) use ($params) {
                $query->search($params['search'] ?? '', $params['searchable_columns'] ?? []);
            })
            ->when(method_exists($this->model, 'scopeOfOrder'), function ($query) use ($params) {
                $query->ofOrder($params['order_by'] ?? 'id', $params['order_direction'] ?? 'asc');
            })
            ->when(method_exists($this->model, 'scopeFilter'), function ($query) use ($params) {
                $query->filter($params['filters'] ?? []);
            })
            ->paginate($perPage);
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
        return $this->model->with($relations)->findOrFail($id);
    }

    /**
     * Create a new resource.
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a resource.
     *
     * @param  int $id
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(int $id, array $data)
    {
        $resource = $this->model->findOrFail($id);
        $resource->update($data);

        return $resource;
    }

    /**
     * Delete a resource.
     *
     * @param  int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $resource = $this->model->findOrFail($id);

        return $resource->delete();
    }

    /**
     * Batch delete resources by ids.
     *
     * @param  array $ids
     * @return bool
     */
    public function batchDeleteByIds(array $ids)
    {
        return $this->model->fromUserBusiness()
            ->whereIn('id', $ids)
            ->delete();
    }
}
