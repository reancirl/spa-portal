<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestDriveUnitResource;
use App\Models\TestDriveUnit;
use App\Services\TestDriveUnitService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class TestDriveUnitController extends Controller
{
    use FormatResponse;

    /**
     * Display a listing of the test drive unit resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = TestDriveUnit::ofDealer(auth()->user()->dealer_id)
                ->when($request->has('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->has('action'), function ($query) use ($request) {
                    $query->where('action', $request->action);
                })
                ->when($request->has('model'), function ($query) use ($request) {
                    $query->where('model_name', $request->model);
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                TestDriveUnitResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render test drive unit.'
            );
        }
    }

    /**
     * Store test drive unit  in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            (new TestDriveUnitService())->storeTestDriveUnitViaExcel($request->file('file'));


            return $this->formatSuccessResponse(
                [
                    TestDriveUnitResource::collection(TestDriveUnit::get())
                ],
                'test drive unit successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create test drive unit'
            );
        }
    }
}
