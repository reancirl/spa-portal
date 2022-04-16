<?php

namespace App\Http\Controllers\Api\v1;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Dealer;
use App\Models\Inquiry;
use App\Models\Leads;
use App\Models\Quotation;
use App\Models\ReportTypes;
use App\Models\Reservation;
use App\Models\TestDrive;
use App\Models\User;
use App\Services\ReportService;
use App\Traits\FormatResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    use FormatResponse;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(ReportService $model, Request $request)
    {
        $query_ids = Dealer::ofDealerFilter($request->dealer_zone_id, $request->dealer_group_id)
            ->when($request->has('dealer_id'), function ($query) use ($request) {
                $query->whereIn('id', $request->dealer_id);
            })->pluck('id');

        try {
            return $this->successResponse(
                /** $request->name is report type */
                $model->filterModel($query_ids, $request->name),
                'Successfully get actions.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render leads.'
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function download(Request $request)
    {

        try {
            $query_ids = Dealer::ofDealerFilter($request->dealer_zone_id, $request->dealer_group_id)
                ->when($request->has('dealer_id'), function ($query) use ($request) {
                    $query->whereIn('id', $request->dealer_id);
                })->pluck('id');

            ((new ReportService())->downloadExcelFilter($query_ids, $request->name));

            return $this->successResourceResponse(
                []
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render leads.'
            );
        }
    }
}
