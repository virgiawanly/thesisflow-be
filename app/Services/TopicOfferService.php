<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
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
        $topicOffer = $this->repository()->findLecturerTopicOffer($lecturerId, $id);

        $payload = array_merge($payload, [
            'lecturer_id' => $lecturerId,
            'keywords' => json_encode($payload['keywords'])
        ]);

        $totalSubmittedSubmissions = $this
            ->repository()
            ->countTopicOfferSubmittedSubmissions($topicOffer);

        if ($totalSubmittedSubmissions > 0) {
            // Prevent bidang_id from being changed if there are submitted submissions
            $payload['bidang_id'] = $topicOffer->bidang_id;
        }

        $totalAssignedSubmissions = $this
            ->repository()
            ->countTopicOfferAssignedSubmissions($topicOffer);

        if ($payload['kuota'] < ($totalAssignedSubmissions)) {
            throw new BadRequestException(__('errors.topic_offer.quota_cannot_be_less_than_assigned_submissions'));
        }

        return $topicOffer->update($payload);
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
        $topicOffer = $this->repository()->findLecturerTopicOffer($lecturerId, $id);

        $totalSubmittedSubmissions = $this
            ->repository()
            ->countTopicOfferSubmittedSubmissions($topicOffer);

        if ($totalSubmittedSubmissions > 0) {
            throw new BadRequestException(__('errors.topic_offer.delete_error_has_submissions'));
        }

        return $topicOffer->delete();
    }
}
