<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Exceptions\AppException;
use App\Models\FileFolder;
use App\Traits\FormatResponse;

class ColorController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\ColorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Color::orderBy('created_at', 'desc')
                ->when($request->has('q'), function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->q}%");
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                ColorResource::collection($data)
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
     * @param  \Illuminate\Http\ColorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColorRequest $request)
    {
        try {
            $name = "";

            if ($request->has('image')) {
                $name = $request->file('image')->hashName();

                $request->file('image')->storeAs(
                    'public' . DIRECTORY_SEPARATOR . FileFolder::FOLDER_COLORS,
                    $name
                );
            }

            return $this->formatSuccessResponse(
                [
                    new ColorResource(Color::create(array_merge($request->validated(), [
                        'created_by_user_id' => auth()->user()->id,
                        'updated_by_user_id' => auth()->user()->id,
                        'image'              => $name
                    ])))
                ],
                'Color successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Oops! Failed to add new Color.'
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
                new ColorResource(Color::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get Color.'
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
    public function update(ColorRequest $request, $id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->update($request->validated());
            return $this->formatSuccessResponse(
                [
                    new ColorResource($color)
                ],
                ' Color successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update Color'
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
            $color = Color::findOrFail($id);
            $color->delete();
            return $this->formatSuccessResponse(
                [],
                'Color successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create Color'
            );
        }
    }
}
