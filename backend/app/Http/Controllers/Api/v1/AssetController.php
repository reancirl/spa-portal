<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandingGuidelinesRequest;
use App\Http\Requests\UpdateAssetsRequest;
use App\Http\Requests\StoreAssetsRequest;
use App\Http\Resources\AssetsResource;
use App\Models\Asset;
use App\Models\UserLog;
use App\Services\AssetsService;
use App\Traits\FormatResponse;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class AssetController extends Controller
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
            $query = Asset::when(auth()->user()->dealer_id, function ($q) {
                $q->active()
                    ->published()
                    ->where(function ($q1) {
                        $q1->whereJsonContains('dealers', auth()->user()->dealer_id)->orWhereNull('dealers');
                    });
            })->when($request->q, function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%");
            })->orderBy('created_at', 'desc');

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
     * @param  \App\Http\Requests\StoreAssetsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetsRequest $request)
    {
        try {
            $assets = (new AssetsService())->store($request->all());

            return $this->successResourceResponse(
                AssetsResource::collection($assets),
                'Files successfully uploaded.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                $e->getMessage()
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
                new AssetsResource(Asset::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get file.'
            );
        }
    }

    /**
     * Upload a file
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(Request $request)
    {
        try {

            $file = (new AssetsService())->uploadChunkFile($request);

            $file['index'] = $request->has('uploadIndex') ? $request->uploadIndex : null;

            return $this->successResponse(
                $file
            );
        } catch (\Throwable $th) {
            dd($th);
            return $this->errorResponse(
                'Failed to upload file.'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAssetsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAssetsRequest $request, $id)
    {
        try {
            $asset = Asset::findOrFail($id);

            $update = (new AssetsService())->update($asset, $request->all());

            return $this->successResponse(
                new AssetsResource($update),
                'File successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update file.'
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
            $asset = Asset::findOrFail($id);

            (new AssetsService())->deleteAsset($asset);

            return $this->formatSuccessResponse(
                [],
                'File successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete file.'
            );
        }
    }

    /**
     * Get the available storage
     *
     * @return \Illuminate\Http\Response
     */
    public function storage()
    {
        try {
            $service = new AssetsService;

            $usage =  (int) $service->getStorageUsage();
            $available = (int) $service->getStorageSize();
            $percentage = null;


            if ($available) {
                $percentage = ($usage / $available) * 100;
                $percentage = number_format($percentage, 0);
            }

            return $this->successResponse(
                [
                    'used' => $service->formatSize($usage),
                    'available' => $service->formatSize($available),
                    'percentage' => $percentage,
                ]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to storage details.'
            );
        }
    }

    /**
     * Download asset
     *
     * @param  int  $id
     * @param string $file
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        try {
            $asset = Asset::where('id', $id)->first();

            if (!$asset) {
                return $this->errorResponse(
                    'Failed to process request.'
                );
            }

            UserLog::create([
                'user_id' => auth()->user()->id,
                'action' => UserLog::TYPE_ACTION,
                'message' => auth()->user()->full_name . " downloaded the {$asset->name}.",
                'loggable_id' => $asset->id,
                'loggable_type' => 'App\Models\Asset'
            ]);

            return $this->successResponse(
                [
                    'download_url' => url("/assets/{$asset->id}/file/{$asset->file}/download"),
                ]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to download file.'
            );
        }
    }

    /**
     * Get download asset
     *
     * @param  int  $id
     * @param string $file
     * @return \Illuminate\Http\Response
     */
    public function getDownload($id, $file)
    {
        try {
            $asset = Asset::where('id', $id)->where('file', $file)->first();

            if (!$asset) {
                return $this->errorResponse(
                    'Failed to process request.'
                );
            }

            $path = storage_path() . "/app/public/assets/{$file}";

            return response()->download($path);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to download file.'
            );
        }
    }

    /**
     * Get branding guidelines
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getBrandingGuidelines()
    {
        try {
            $file = (new SettingsService())->getValue('branding_guidelines');

            if (!$file) {
                return $this->errorResponse(
                    'File is not available.'
                );
            }
            return $this->successResponse(
                [
                    'path' => url("storage/assets/{$file}"),
                ]
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get file.'
            );
        }
    }

    /**
     * Update branding guidelines
     *
     * @param \App\Http\Requests\BrandingGuidelinesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateBrandingGuidelines(BrandingGuidelinesRequest $request)
    {
        try {

            $file = (new AssetsService())->updateBrandingGuidelines($request->file);

            if (!$file) {
                return $this->errorResponse(
                    'File is not available.'
                );
            }
            return $this->successResponse(
                [
                    'path' => url("storage/assets/{$file}"),
                ],
                'File successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get file.'
            );
        }
    }

    /**
     * Download branding guidelines
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadBrandingGuidelines()
    {
        try {
            $file = (new SettingsService())->getValue('branding_guidelines');

            if (!$file) {
                return $this->errorResponse(
                    'Failed to process request.'
                );
            }

            $path = storage_path() . "/app/public/assets/{$file}";

            return response()->download($path);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to download file.'
            );
        }
    }
}
