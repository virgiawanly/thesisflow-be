<?php

namespace App\Services;

use App\Repositories\TopicOfferRepository;

class TopicOfferService extends BaseResourceService
{
    /**
     * Create a new service instance.
     *
     * @param \App\Repositories\TopicOfferRepository $topicOfferRepository
     * @return void
     */
    public function __construct(TopicOfferRepository $topicOfferRepository)
    {
        parent::__construct($topicOfferRepository);
    }

    /**
     * Get repository instance.
     *
     * @return \App\Repositories\TopicOfferRepository
     */
    public function repository(): TopicOfferRepository
    {
        return $this->repository;
    }

    /**
     * Get paginated lecturer topic offers.
     *
     * @param  int|string $lecturerId
     * @param  array $queryParams
     * @param  array $relations
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedLecturerTopicOffers(int|string $lecturerId, array $queryParams, array $relations = [])
    {
        $perPage = $queryParams['per_page'] ?? $this->defaultPerPage;
        return $this->repository()->paginatedLecturerTopicOffers($lecturerId, $perPage, $queryParams, $relations);
    }

    /**
     * Create a new lecturer topic offer.
     *
     * @param int|string $lecturerId
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function saveLecturerTopicOffer(int|string $lecturerId, array $data)
    {
        $data = array_merge($data, [
            'lecturer_id' => $lecturerId,
            'keywords' => json_encode($data['keywords'])
        ]);

        return parent::save($data);
    }

    /**
     * Update a lecturer topic offer.
     *
     * @param int|string $lecturerId
     * @param int $id
     * @param array $payload
     */
    public function patchLecturerTopicOffer(int|string $lecturerId, int $id, array $payload)
    {
        $payload = array_merge($payload, [
            'lecturer_id' => $lecturerId,
            'keywords' => json_encode($payload['keywords'])
        ]);

        return parent::patch($id, $payload);
    }

    /**
     * Find lecturer topic offer.
     *
     * @param  int|string $lecturerId
     * @param  int $id
     * @param  array $relations
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findLecturerTopicOffer(int|string $lecturerId, int $id, array $relations = [])
    {
        return $this->repository()->findLecturerTopicOffer($lecturerId, $id, $relations);
    }

    /**
     * Delete a lecturer topic offer.
     *
     * @param int|string $lecturerId
     * @param int $id
     * @return bool
     */
    public function deleteLecturerTopicOffer(int|string $lecturerId, int $id)
    {
        return $this->repository()->deleteLecturerTopicOffer($lecturerId, $id);
    }
}
