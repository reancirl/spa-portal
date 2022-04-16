<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestDriveRequest;
use App\Http\Resources\TestDriveResource;
use App\Models\TestDrive;
use App\Models\TestDriveUnit;
use App\Models\User;
use App\Services\TestDriveService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestDriveController extends Controller
{

    use FormatResponse;

    /**
     * Display a listing of the  test drive resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        try {
            $query = TestDrive::ofDealer(auth()->user()->dealer_id)
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
                TestDriveResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render test drives.'
            );
        }
    }


    /**
     * Store a newly created test drive resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            (new TestDriveService())->storeTestDriveViaExcel($request->file('file'));

            return $this->formatSuccessResponse(
                [
                    TestDriveResource::collection(TestDrive::get())
                ],
                'Test drives successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create test drive.'
            );
        }
    }



    /**
     * Update the specified test drive resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestDriveRequest $request, $id)
    {
        try {
            return $this->formatSuccessResponse(
                [
                    new TestDriveResource(TestDrive::create(array_merge($request->validated(), [
                        'updated_by_user_id' => auth()->user()->id
                    ])))
                ],
                'Test Drive List successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render Test Drive.'
            );
        }
    }
}
