<?php

namespace App\Http\Controllers\V1\SystemAdmin;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\BaseResourceController;
use App\Http\Requests\Api\V1\SystemAdmin\FieldTaxonomy\CreateFieldTaxonomyRequest;
use App\Http\Requests\Api\V1\SystemAdmin\FieldTaxonomy\UpdateFieldTaxonomyRequest;
use App\Services\FieldTaxonomyService;
use Illuminate\Http\Request;

class FieldTaxonomyController extends BaseResourceController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected FieldTaxonomyService $fieldTaxonomyService)
    {
        parent::__construct($fieldTaxonomyService->repository);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = $this->service->paginatedList($request->all(), ['parent']);
        return ResponseHelper::data($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\SystemAdmin\FieldTaxonomy\CreateFieldTaxonomyRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateFieldTaxonomyRequest $request)
    {
        $result = $this->service->save($request->validated());
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
        $result = $this->service->find($id, ['parent']);
        return ResponseHelper::data($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Api\V1\SystemAdmin\FieldTaxonomy\UpdateFieldTaxonomyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateFieldTaxonomyRequest $request, int $id)
    {
        $result = $this->service->patch($id, $request->validated());
        return ResponseHelper::success(trans('messages.successfully_updated'), $result);
    }
}
