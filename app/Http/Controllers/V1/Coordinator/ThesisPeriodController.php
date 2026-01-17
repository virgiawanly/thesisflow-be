<?php

namespace App\Http\Controllers\V1\Coordinator;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\BaseResourceController;
use App\Services\ThesisPeriodService;
use Illuminate\Http\Request;

class ThesisPeriodController extends BaseResourceController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected ThesisPeriodService $thesisPeriodService)
    {
        parent::__construct($thesisPeriodService->repository);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $result = $this->service->list($request->all(), ['parent']);
        return ResponseHelper::data($result);
    }
}
