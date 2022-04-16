<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryRequest;
use App\Http\Resources\InquiryResource;
use App\Models\Inquiry;
use App\Models\User;
use App\Services\InquiryService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InquiryController extends Controller
{
    use FormatResponse;

    /**
     * Display a listing of the inquiries resource with dealer.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = (new InquiryService())->index($request);
            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                InquiryResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create Inquiry'
            );
        }
    }

    /**
     * Stores via upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            (new InquiryService())->storeInquiriesViaExcel($request->file('file'));

            return $this->formatSuccessResponse(
                [],
                'File successfully uploaded.'
            );
        } catch (AppException $e) {
            return $this->errorResponse(
                $e->getMessage()
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create inquiry'
            );
        }
    }

    /**
     * Update Inquiry.
     *
     * @param  \App\Http\Requests\InquiryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\InquiryResource
     */
    public function update(InquiryRequest $request, $id)
    {
        try {
            $inquiry = Inquiry::ofDealer(auth()->user()->dealer_id)
                ->where('id', $id)
                ->first();

            $inquiry->update(array_merge($request->validated(), [
                'updated_by_user_id' => auth()->user()->id
            ]));

            return $this->successResponse(
                [
                    new InquiryResource($inquiry)
                ],
                'Inquiry successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update Inquiry'
            );
        }
    }

    /**
     * Remove Inquiry.
     *
     * @param  int  $id
     * @return \Illuminate\Http\InquiryResource
     */
    public function destroy($id)
    {
        try {
            $inquiry = Inquiry::ofDealer(auth()->user()->dealer_id)
                ->where('id', $id)
                ->first();

            $inquiry->delete();

            return $this->formatSuccessResponse(
                [],
                'Inquiry successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete Inquiry.'
            );
        }
    }
}
