<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModelRequest;
use App\Http\Resources\ModelResource;
use App\Models\FileFolder;
use App\Models\ModelVehicle;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use App\Exceptions\AppException;

class ModelVehicleController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = ModelVehicle::orderBy('created_at', 'desc')
                ->when($request->q, function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->q}%");
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                ModelResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get models '
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\ModelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ModelRequest $request)
    {
        try {
            $name = null;

            if ($request->has('image')) {
                $name = $request->file('image')->hashName();

                $request->file('image')->storeAs(
                    'public' . DIRECTORY_SEPARATOR . FileFolder::FOLDER_MODELS,
                    $name
                );
            }

            return $this->formatSuccessResponse(
                [
                    new ModelResource(ModelVehicle::create(array_merge($request->validated(), [
                        'created_by_user_id' => auth()->user()->id,
                        'updated_by_user_id' => auth()->user()->id,
                        'image'              => $name
                    ])))
                ],
                'Model successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Oops! Failed to add new model.'
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
                new ModelResource(ModelVehicle::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get model.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ModelRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ModelRequest $request, $id)
    {
        try {
            $model = ModelVehicle::findOrFail($id);
            $model->update($request->validated());
            return $this->formatSuccessResponse(
                [
                    new ModelResource($model)
                ],
                'Model successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update model.'
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
            $model = ModelVehicle::findOrFail($id);
            $model->delete();
            return $this->formatSuccessResponse(
                [],
                'Model successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create model.'
            );
        }
    }
}
