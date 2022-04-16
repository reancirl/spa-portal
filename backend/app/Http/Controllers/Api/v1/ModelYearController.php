<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModelYearRequest;
use App\Http\Resources\ModelYearResource;
use App\Models\ModelYear;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class ModelYearController extends Controller
{

    use FormatResponse;

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\ModelYearRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = ModelYear::orderBy('created_at', 'desc')
                ->when($request->has('q'), function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->q}%");
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                ModelYearResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get model years'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ModelYearRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModelYearRequest $request)
    {
        try {
            return $this->formatSuccessResponse(
                [
                    new ModelYearResource(ModelYear::create(array_merge($request->validated(), [
                        'created_by_user_id' => auth()->user()->id,
                        'updated_by_user_id' => auth()->user()->id
                    ])))
                ],
                'Model Year successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Oops! Failed to add new Model Year.'
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
                new ModelYearResource(ModelYear::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get Model Year.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ModelYearRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModelYearRequest $request, $id)
    {
        try {
            $modelYear = ModelYear::findOrFail($id);
            $modelYear->update($request->validated());

            return $this->formatSuccessResponse(
                [
                    new ModelYearResource($modelYear)
                ],
                'Model Year successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Oops! Failed to add new Model Year.'
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
            $modelYear = ModelYear::findOrFail($id);
            $modelYear->delete();
            return $this->formatSuccessResponse(
                [],
                'Model Year successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create Model Year'
            );
        }
    }
}
