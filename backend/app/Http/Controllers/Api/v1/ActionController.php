<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusesResource;
use App\Services\ActionService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class ActionController extends Controller
{
    use FormatResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ActionService $action, Request $request)
    {
        try {
            return $this->successResponse(
                $action->execute($request->type),
                'Successfully get actions.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage()
            );
        }
    }
}
