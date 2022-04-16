<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuotationRequest;
use App\Http\Requests\UploadRequest;
use App\Http\Resources\QuotationResource;
use App\Models\Quotation;
use App\Models\UploadStatus;
use App\Services\QuotationService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    use FormatResponse;

    /**
     * Display a listing of the quotation resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Quotation::with(['assignedSC'])->ofDealer(auth()->user()->dealer_id)
                ->when($request->has('q'), function ($query) use ($request) {
                    $query->where('email', 'like', "%{$request->q}%");
                })
                ->when($request->has('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->has('action'), function ($query) use ($request) {
                    $query->where('action', $request->action);
                })
                ->when($request->has('model'), function ($query) use ($request) {
                    $query->where('model_name', $request->model);
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                QuotationResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render quotations.'
            );
        }
    }

    /**
     * Store a newly created quotation resource.
     *
     * @param  \Illuminate\Http\QuotationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuotationRequest $request)
    {
        try {
            return $this->formatSuccessResponse(
                [
                    new QuotationResource(Quotation::create(array_merge(
                        $request->validated(),
                        ['created_by_user_id' => auth()->user()->id]
                    )))
                ],
                'Quotation successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create quotation.'
            );
        }
    }

    /**
     * Store a newly created quotation resource.
     *
     * @param  \Illuminate\Http\QuotationRequest  $request
     * @param  App\Models\Quotation $quotation
     * @return \Illuminate\Http\Response
     */
    public function upload(UploadRequest $request, $id)
    {
        try {
            $quotation = Quotation::findOrFail($id);

            (new QuotationService())->uploadFile($request->file('file'), $quotation);
            return $this->formatSuccessResponse(
                [
                    new QuotationResource($quotation)
                ],
                'Quotation successfully document file.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to upload document quotation.'
            );
        }
    }

    /**
     * Update the specified quotation resource in storage.
     *
     * @param  \Illuminate\Http\QuotationRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuotationRequest $request, $id)
    {
        try {
            $data = Quotation::findOrFail($id);
            $data->update(
                array_merge(
                    $request->validated(),
                    ['updated_by_user_id' => auth()->user()->id]
                )
            );
            return $this->formatSuccessResponse(
                [
                    new QuotationResource($data)
                ],
                'Quotation successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update quotation.'
            );
        }
    }


    /**
     * Download quotation document
     *
     * @param  int  $id
     * @param string $file
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        try {
            $quotation = Quotation::findOrFail($id);

            if (!$quotation) {
                return $this->errorResponse(
                    'Failed to process request.'
                );
            }

            $path = storage_path() . "/app/public/quotation/{$quotation->document}";

            return response()->download($path);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->errorResponse(
                'Failed to download file.'
            );
        }
    }
}
