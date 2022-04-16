<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AssetFoldersRequest;
use App\Http\Resources\AssetFoldersResource;
use App\Http\Resources\AssetsResource;
use App\Models\Asset;
use App\Models\AssetFolder;
use App\Services\AssetsService;
use App\Traits\FormatResponse;

class AssetFoldersController extends Controller
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
            $query = AssetFolder::with(['category'])
                ->when(auth()->user()->dealer_id, function ($q) {
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
                AssetFoldersResource::collection($data)
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to get folders.'
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
    public function assets(Request $request, $id)
    {
        try {
            $query = Asset::when(auth()->user()->dealer_id, function ($q) {
                $q->active()
                    ->published()
                    ->where(function ($q1) {
                        $q1->whereJsonContains('dealers', auth()->user()->dealer_id)->orWhereNull('dealers');
                    });
            })->where('folder_id', $id)
                ->when($request->q, function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->q}%");
                })
                ->orderBy('created_at', 'desc');

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                AssetsResource::collection($data)
            );
        } catch (\Throwable $th) {
            return $this->errorResponse(
                'Failed to get files.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AssetFoldersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetFoldersRequest $request)
    {
        try {
            $data = AssetFolder::create(array_merge($request->validated(), [
                'created_by_user_id' => auth()->user()->id,
            ]));

            return $this->successResponse(
                new AssetFoldersResource($data),
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
                new AssetFoldersResource(AssetFolder::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get folder.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\AssetFoldersRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssetFoldersRequest $request, $id)
    {
        try {
            $folder = AssetFolder::findOrFail($id);

            (new AssetsService())->updateFolder($folder, $request->validated());

            return $this->successResponse(
                new AssetFoldersResource($folder),
                'Folder successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update folder.'
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
            $folder = AssetFolder::findOrFail($id);

            (new AssetsService())->deleteFolder($folder);

            return $this->formatSuccessResponse(
                [],
                'Folder successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete folder.'
            );
        }
    }
}
