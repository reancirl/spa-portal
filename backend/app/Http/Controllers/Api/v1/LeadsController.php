<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadsRequest;
use App\Http\Resources\LeadsResource;
use App\Models\Leads;
use App\Models\User;
use App\Services\LeadsService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadsController extends Controller
{
    use FormatResponse;

    /**
     * Display a listing of the leads resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        try {
            $query = Leads::with(['assignedSC'])->ofDealer(auth()->user()->dealer_id)
                ->when($request->has('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->has('action'), function ($query) use ($request) {
                    $query->where('action', $request->action);
                });

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                LeadsResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render leads.'
            );
        }
    }

    /**
     * Store leads via Inquiry excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            (new LeadsService())->storeLeadsViaExcel($request->file('file'));

            return $this->formatSuccessResponse(
                [
                    LeadsResource::collection(Leads::get())
                ],
                'leads successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create leads'
            );
        }
    }

    /**
     * download a leads via excel
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        try {
            ((new LeadsService())->downloadExcel());
            return $this->formatSuccessResponse(
                [],
                'leads successfully downloaded.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create leads'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\LeadsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeadsRequest $request, $id)
    {
        try {
            $leads = Leads::findOrFail($id);
            $leads->update(array_merge($request->validated(), [
                'updated_by_user_id' => auth()->user()->id
            ]));
            return $this->formatSuccessResponse(
                [
                    new LeadsResource($leads)
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
