<?php

namespace App\Repositories;

use App\Models\TopicOffer;

class TopicOfferRepository extends BaseResourceRepository
{
    /**
     * Create a new repository instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new TopicOffer();
    }

    /**
     * Get a paginated list of lecturer topic offers.
     *
     * @param int|string $lecturerId
     * @param int $perPage
     * @param array $params
     * @param array $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginatedLecturerTopicOffers(int|string $lecturerId, int $perPage, array $params = [], array $relations = [])
    {
        return $this->model
            ->with($relations)
            ->where('lecturer_id', $lecturerId)
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
     * Get a lecturer topic offer by id.
     *
     * @param int|string $lecturerId
     * @param  int $id
     * @param  array $relations
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findLecturerTopicOffer(int|string $lecturerId, int $id, array $relations = [])
    {
        return $this->model
            ->with($relations)
            ->where('lecturer_id', $lecturerId)
            ->findOrFail($id);
    }

    /**
     * Delete a lecturer topic offer.
     *
     * @param int|string $lecturerId
     * @param  int $id
     * @return bool
     */
    public function deleteLecturerTopicOffer(int|string $lecturerId, int $id)
    {
        $resource = $this->model
            ->where('lecturer_id', $lecturerId)
            ->findOrFail($id);

        return $resource->delete();
    }
}
