<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealerGroupRequest;
use App\Http\Resources\DealerGroupResource;
use App\Models\DealerGroup;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class DealerGroupController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Request $request)
    {
        try {
            $query = DealerGroup::when($request->has('name'), function ($query) use ($request) {
                $query->where('name', $request->name);
            });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                DealerGroupResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render dealer group.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\DealerGroupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerGroupRequest $request)
    {
        try {
            return $this->formatSuccessResponse(
                [
                    new DealerGroupResource(DealerGroup::create($request->validated()))
                ],
                'Dealer group successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create dealer group.'
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
                new DealerGroupResource(DealerGroup::findOrFail($id))
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
     * @param  \Illuminate\Http\DealerGroupRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealerGroupRequest $request, $id)
    {
        try {
            $data = DealerGroup::findOrFail($id);
            $data->update($request->validated());

            return $this->formatSuccessResponse(
                [
                    new DealerGroupResource($data)
                ],
                'Dealer group successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to updated dealer group.'
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
            $data = DealerGroup::findOrFail($id);
            $data->delete();

            return $this->formatSuccessResponse(
                [],
                'Dealer group successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to deleted dealer group.'
            );
        }
    }
}
