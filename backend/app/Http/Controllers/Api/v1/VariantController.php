<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantRequest;
use App\Http\Resources\VariantResource;
use App\Http\Resources\VariantsResource;
use App\Models\ModelVehicle;
use App\Models\ModelYear;
use App\Models\Variant;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Variant::when($request->has('model'), function ($query) use ($request) {
                $query->where('model_id', $request->model);
            })
                ->when($request->has('q'), function ($query) use ($request) {
                    $query->where('code', 'like', "%{$request->q}%");
                })
                ->when($request->has('name'), function ($query) use ($request) {
                    $query->where('name', $request->name);
                })
                ->when($request->has('alias'), function ($query) use ($request) {
                    $query->where('alias', $request->alias);
                })
                ->when($request->has('long_name'), function ($query) use ($request) {
                    $query->where('long_name', $request->long_name);
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                VariantResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get Variants'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariantRequest $request)
    {
        try {
            $model  = ModelVehicle::findOrFail($request->model_id);
            $year   = ModelYear::findOrFail($request->year_id);
            $alias  = "{$model->name} {$request->name} {$year->code}";

            $data = Variant::create(array_merge($request->validated(), [
                'name'               => $request->name,
                'alias'              => $alias,
                'long_name'          => "{$request->code} {$year->name} {$alias} {$year->code}",
                'created_by_user_id' => auth()->user()->id,
            ]));

            return $this->successResponse(
                new VariantResource($data),
                'variant successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to add new variant.'
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
                new VariantResource(Variant::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get variant.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VariantRequest $request, $id)
    {
        try {
            $model  = ModelVehicle::findOrFail($request->model_id);
            $year   = ModelYear::findOrFail($request->year_id);
            $alias  = "{$model->name} {$request->name} {$year->code}";

            $variant = Variant::findOrFail($id);
            $variant->update([
                'name'               => $request->name,
                'alias'              => $alias,
                'long_name'          => "{$request->code} {$year->name} {$alias} {$year->code}",
                'updated_by_user_id' => auth()->user()->id

            ]);

            return $this->successResponse(
                new VariantResource($variant),
                'variant successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to add new variant.'
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
            $variant = Variant::findOrFail($id);
            $variant->delete();
            return $this->formatSuccessResponse(
                [],
                'Variant successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create Variant'
            );
        }
    }
}
