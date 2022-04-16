<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealerZoneRequest;
use App\Http\Resources\DealerZoneResource;
use App\Models\DealerZone;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class DealerZoneController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        try {
            $query = DealerZone::when($request->has('name'), function ($query) use ($request) {
                $query->where('name', $request->name);
            });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                DealerZoneResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render dealer zones.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\DealerZoneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerZoneRequest $request)
    {
        try {
            return $this->formatSuccessResponse(
                [
                    new DealerZoneResource(DealerZone::create($request->validated()))
                ],
                'Dealer zone successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create dealer zone.'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->successResponse(
                new DealerZoneResource(DealerZone::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get file.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\DealerZoneRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealerZoneRequest $request, $id)
    {
        try {
            $data = DealerZone::findOrFail($id);
            $data->update($request->validated());

            return $this->formatSuccessResponse(
                [
                    new DealerZoneResource($data)
                ],
                'Dealer zones successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to updated dealer zones'
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $data = DealerZone::findOrFail($id);
            $data->delete();

            return $this->formatSuccessResponse(
                [],
                'Dealer zones successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete dealer zones'
            );
        }
    }
}
