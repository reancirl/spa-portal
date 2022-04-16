<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantColorRequest;
use App\Http\Resources\VariantColorResource;
use App\Models\Color;
use App\Models\Variant;
use App\Models\VariantColor;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class VariantColorController extends Controller
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
            $query = VariantColor::orderBy('created_at', 'desc')
                ->when($request->has('q'), function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->q}%");
                })
                ->when($request->has('variant_id'), function ($query) use ($request) {
                    $query->where('variant_id', $request->variant_id);
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                VariantColorResource::collection($data)
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
     * @param  \Illuminate\Http\VariantColorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariantColorRequest $request)
    {
        try {
            $variant = Variant::findOrFail($request->variant_id);
            $color = Color::findOrFail($request->color_id);

            return $this->formatSuccessResponse(
                [
                    new VariantColorResource(VariantColor::create(array_merge($request->validated(), [
                        'name'               => "{$variant->alias} $color->name",
                        'long_name'          => "{$variant->long_name} $color->name",
                        'pricing'            => $request->pricing,
                        'price'              => $request->pricing === 'custom' ? $request->price : $variant->price,
                        'created_by_user_id' => auth()->user()->id,
                    ])))
                ],
                'Variant Color successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Oops! Failed to add new Variant Color.'
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
                new VariantColorResource(VariantColor::findOrFail($id))
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
    public function update(VariantColorRequest $request, $id)
    {
        try {
            $variant = Variant::findOrFail($request->variant_id);
            $color = Color::findOrFail($request->color_id);
            $variantColor = VariantColor::findOrFail($id);

            $variantColor->update([
                $request->validated(),
                'name'               => "{$variant->alias} $color->name",
                'long_name'          => "{$variant->long_name} $color->name",
                'status'             => $request->status,
                'color_id'           => $request->color_id,
                'pricing'            => $request->pricing,
                'price'              => $request->pricing === 'custom' ? $request->price : $variant->price,
                'created_by_user_id' => auth()->user()->id,
            ]);

            return $this->formatSuccessResponse(
                [
                    new VariantColorResource($variantColor)
                ],
                'Variant Color successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update Variant Color'
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
            $variantColor = VariantColor::findOrFail($id);
            $variantColor->delete();
            return $this->formatSuccessResponse(
                [],
                'Variant Color successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create Variant Color'
            );
        }
    }
}
