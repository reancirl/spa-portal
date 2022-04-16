<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AssetCategoriesRequest;
use App\Http\Resources\AssetCategoriesResource;
use App\Http\Resources\AssetFoldersResource;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetFolder;
use App\Services\AssetsService;
use App\Traits\FormatResponse;

class AssetCategoryController extends Controller
{
    use FormatResponse;

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = AssetCategory::when(auth()->user()->dealer_id, function ($q) {
                $q->active();
            })->when($request->q, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%");
            })->when($request->has('order_by') && $request->has('sort'), function ($q) use ($request) {
                $q->orderBy($request->order_by, $request->sort);
            }, function ($q) {
                $q->orderBy('name');
            });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                AssetCategoriesResource::collection($data)
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to get categories.'
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function folders(Request $request, $id)
    {
        try {
            $query = AssetFolder::where('category_id', $id)
                ->when(auth()->user()->dealer_id, function ($q) {
                    $q->active();
                })->when($request->q, function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->q}%");
                })->when($request->has('order_by') && $request->has('sort'), function ($q) use ($request) {
                    $q->orderBy($request->order_by, $request->sort);
                }, function ($q) {
                    $q->orderBy('precedence');
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                AssetFoldersResource::collection($data)
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to get folders.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AssetCategoriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetCategoriesRequest $request)
    {
        try {
            $data = AssetCategory::create(array_merge($request->validated(), [
                'created_by_user_id' => auth()->user()->id
            ]));

            return $this->successResponse(
                new AssetCategoriesResource($data),
                'Category successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to add new category.'
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
                AssetCategory::findOrFail($id)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get category.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AssetCategoriesRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetCategoriesRequest $request, $id)
    {
        try {
            $category = AssetCategory::findOrFail($id);

            (new AssetsService())->updateCategory($category, $request->validated());

            return $this->successResponse(
                new AssetCategoriesResource($category),
                'Category successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update category.'
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
            $category = AssetCategory::findOrFail($id);

            (new AssetsService())->deleteCategory($category);

            return $this->formatSuccessResponse(
                [],
                'Category successfully deleted.'
            );
        } catch (\Exception $e) {
            dd($e);
            return $this->errorResponse(
                'Failed to delete category.'
            );
        }
    }
}
