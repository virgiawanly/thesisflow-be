<?php

namespace App\Http\Controllers\V1\Lecturer;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\BaseResourceController;
use App\Http\Requests\Api\V1\Lecturer\CreateTopicOfferRequest;
use App\Http\Requests\Api\V1\Lecturer\UpdateTopicOfferRequest;
use App\Services\TopicOfferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicOfferController extends BaseResourceController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected TopicOfferService $topicOfferService)
    {
        parent::__construct($topicOfferService->repository);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = $this->topicOfferService->getPaginatedLecturerTopicOffers(Auth::user()->lecturer_id, $request->all(), ['field']);
        return ResponseHelper::data($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\Lecturer\CreateTopicOfferRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateTopicOfferRequest $request)
    {
        $result = $this->topicOfferService->saveLecturerTopicOffer(Auth::user()->lecturer_id, $request->validated());
        return ResponseHelper::success(trans('messages.successfully_created'), $result, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $result = $this->topicOfferService->findLecturerTopicOffer(Auth::user()->lecturer_id, $id, ['field']);
        return ResponseHelper::data($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\Lecturer\UpdateTopicOfferRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateTopicOfferRequest $request, int $id)
    {
        $result = $this->topicOfferService->patchLecturerTopicOffer(Auth::user()->lecturer_id, $id, $request->validated());
        return ResponseHelper::success(trans('messages.successfully_updated'), $result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $this->topicOfferService->deleteLecturerTopicOffer(Auth::user()->lecturer_id, $id);
        return ResponseHelper::success(trans('messages.successfully_deleted'));
    }
}
