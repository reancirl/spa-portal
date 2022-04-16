<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\Dealer;
use App\Models\Leads;
use App\Models\Quotation;
use App\Models\QuotationAction;
use App\Models\ReportTypes;
use App\Models\Reservation;
use App\Models\TestDrive;
use App\Models\TestDriveAction;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Database\Eloquent\Builder;

class ReportService
{
    /**
     *
     * @param ids of Dealers $query_ids
     * @param App\Models\ReportTypes $types
     * @return object
     */
    public function filterModel($query_ids, $type)
    {
        switch ($type) {
            case ReportTypes::LEADS:
                $collection = Leads::whereIn('dealer_id', $query_ids)->get();
                break;
            case ReportTypes::QUOTATIONS:
                $collection = Quotation::whereIn('dealer_id', $query_ids)->get();
                break;
            case ReportTypes::TEST_DRIVES:
                $collection = TestDrive::whereIn('dealer_id', $query_ids)->get();
                break;
            case ReportTypes::RESERVATIONS:
                $collection = Reservation::whereIn('dealer_id', $query_ids)->get();
                break;
            case ReportTypes::BRAND_ASSETS:
                $collection = Asset::whereJsonContains('dealers', $query_ids)->get();
                break;
            case ReportTypes::USER_ACTIVITIES:
                $user_dealer_ids = User::whereIn('dealer_id', $query_ids)->pluck('id');
                $collection = UserLog::whereIn('user_id', $user_dealer_ids)->get();
                break;
            case ReportTypes::SALES_CONSULTANTS:
                $collection = User::whereIn('dealer_id', $query_ids)
                    ->whereHas('userRoles.role', function (Builder $query) {
                        $query->where('slug', 'sales_consultant');
                    })
                    ->get();
                break;

            default:
                throw new \ErrorException("Invalid action type.");
                break;
        }

        return $collection;
    }
    /**
     *
     * @param ids of Dealers $query_ids
     * @param App\Models\ReportTypes $types
     * @return object
     */
    public function downloadExcelFilter($query_ids, $type)
    {
        switch ($type) {
            case ReportTypes::LEADS:
                $array_header =  [
                    'Activity Source', 'First Name', 'Last Name',
                    'Province', 'Municipality',
                    'Zip Code', 'Barangay', 'Street 1/ House number/ Subd.',
                    'Mobile number', 'Preferred Communication Method', 'Email',
                    'Model', 'Variant', 'Color', 'Inquiry Date'
                ];
                $collection = Leads::whereIn('dealer_id', $query_ids)->get();
                break;
            case  ReportTypes::QUOTATIONS:
                $array_header =  [
                    'Customer', 'First Name', 'Last Name',
                    'Province', 'Municipality',
                    'Zip Code', 'Barangay', 'Street 1/ House number/ Subd.',
                    'Mobile number', 'Title', 'Email',
                    'Model', 'Variant', 'Color', 'Status',
                    'SC Assigned', 'SsC Asigned Date'
                ];
                $collection = Quotation::whereIn('dealer_id', $query_ids)->get();
                break;
            case ReportTypes::TEST_DRIVES:
                $array_header = [
                    'Title', 'First Name', 'Last Name', 'Date of Birth', 'Province',
                    'Municipality', 'Barangay', 'Street 1/ House number/ Subd.',
                    'Zip Code', 'Mobile Number',    'Preferred Communication',
                    'Email', 'Preferred  Dealer', 'Model', 'Variant', 'Color',
                    'Test Drive Date'
                ];
                $collection = TestDrive::whereIn('dealer_id', $query_ids)->get();
                break;
            case ReportTypes::RESERVATIONS:
                $array_header =  [
                    'Customer', 'First Name', 'Last Name', 'Title',
                    'Province', 'Municipality',
                    'Barangay', 'Street 1/ House number/ Subd.',
                    'Zip Code',
                    'Mobile number',  'Email',
                    'Model', 'Variant', 'Color', 'Status',
                    'Preferred Communication', 'Dealer',
                    'SC Assigned', 'SsC Asigned Date'
                ];
                $collection = Reservation::whereIn('dealer_id', $query_ids)->get();
                break;

            case ReportTypes::USER_ACTIVITIES:
                $array_header =  [
                    'User', 'action', 'message',  'data',
                ];
                $user_dealer_ids = User::whereIn('dealer_id', $query_ids)->pluck('id');
                $collection = UserLog::whereIn('user_id', $user_dealer_ids)->get();
                break;


            case ReportTypes::SALES_CONSULTANTS:
                $array_header =  [
                    'First Name', 'Last Name', 'Email',  'CRM ID', 'Dealer Name'
                ];

                $collection = User::whereIn('dealer_id', $query_ids)
                    ->whereHas('userRoles.role', function (Builder $query) {
                        $query->where('slug', 'sales_consultant');
                    })
                    ->get();
                break;


            default:
                throw new \ErrorException("Invalid action type.");
                break;
        }

        // download file here
        ((new DownloadExcelService())->downloadExcel($collection, $array_header, $type));


        return $collection;
    }
}
