<?php

namespace App\Http\Controllers\V1\Misc;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\BaseResourceController;
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
        $result = $this->fieldTaxonomyService->paginatedList($request->all(), ['parent']);
        return ResponseHelper::data($result);
    }

    /**
     * Display a nested listing of field taxonomies.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function nestedList(Request $request)
    {
        $result = $this->fieldTaxonomyService->getPaginatedNestedList($request->all());
        return ResponseHelper::data($result);
    }
}
