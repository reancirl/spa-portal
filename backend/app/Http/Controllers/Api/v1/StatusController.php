<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusesResource;
use App\Services\StatusesService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    use FormatResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StatusesService $action, Request $request)
    {
        try {
            return $this->successResponse(
                $action->execute($request->type),
                'Successfully get statuses.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage()
            );
        }
    }
}
