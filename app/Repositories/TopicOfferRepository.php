<?php

namespace App\Repositories;

use App\Enums\SubmissionStatus;
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
            ->where('lecturer_id', $lecturerId)
            ->with($relations)
            ->withCount([
                'submissions AS pending_submissions_count' =>  function ($query) {
                    $query->whereIn('status', [
                        SubmissionStatus::DIAJUKAN,
                        SubmissionStatus::DIREVIEW,
                    ]);
                },
                'submissions AS assigned_submissions_count' => function ($query) {
                    $query->whereIn('status', [
                        SubmissionStatus::DITUGASKAN,
                    ]);
                }
            ])
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

    /**
     * Count the number of submissions for a topic offer.
     * 
     * @param int|TopicOffer $topicOfferOrId
     * @return bool
     */
    public function countTopicOfferSubmittedSubmissions(int|TopicOffer $topicOfferOrId)
    {
        $topicOffer = $topicOfferOrId instanceof TopicOffer ? $topicOfferOrId : $this->find($topicOfferOrId);

        return $topicOffer->submissions()->whereIn('status', [
            SubmissionStatus::DIAJUKAN,
            SubmissionStatus::DIREVIEW,
            SubmissionStatus::DITUGASKAN,
            SubmissionStatus::DIBATALKAN,
        ])->count();
    }

    /**
     * Count the number of assigned submissions for a topic offer.
     * 
     * @param int|TopicOffer $topicOfferOrId
     * @return bool
     */
    public function countTopicOfferAssignedSubmissions(int|TopicOffer $topicOfferOrId)
    {
        $topicOffer = $topicOfferOrId instanceof TopicOffer ? $topicOfferOrId : $this->find($topicOfferOrId);

        return $topicOffer->submissions()->whereIn('status', [
            SubmissionStatus::DITUGASKAN,
        ])->count();
    }
}
