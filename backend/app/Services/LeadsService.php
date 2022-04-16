<?php

namespace App\Services;

use App\Jobs\ExcelUploadJob;
use App\Models\Leads;
use App\Models\LeadsUpload;
use App\Models\UploadStatus;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AppException;
use App\Models\FileFolder;
use App\Models\ReportTypes;

class LeadsService
{

    /**
     * Download any leads excel .
     *
     * @param \App\Models\User $user
     * @return object
     */
    public function downloadExcel()
    {
        $array_header =  [
            'Activity Source', 'First Name', 'Last Name',
            'Province', 'Municipality',
            'Zip Code', 'Barangay', 'Street 1/ House number/ Subd.',
            'Mobile number', 'Preferred Communication Method', 'Email',
            'Model', 'Variant', 'Color', 'Inquiry Date'
        ];

        $leads = Leads::where('dealer_id', auth()->user()->dealer_id)->get();
        ((new DownloadExcelService())->downloadExcel($leads, $array_header, ReportTypes::LEADS));
    }

    /**
     * store  leads via excel .
     *
     * @param \App\Models\Leads $leads
     * @return object
     */

    public function storeLeadsViaExcel($file)
    {
        if (!$file) {
            throw new AppException("File not found.");
        }


        $name = $file->hashName();
        $file->storeAs(
            'public' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_LEADS,
            $name
        );

        $leadsUpload = LeadsUpload::create([
            'filename'           => $name,
            'original_filename'  => $file->getClientOriginalName(),
            'status'             =>  UploadStatus::STAT_PENDING,
            // 'create_by_user_id'  => auth()->user()->id
        ]);

        ExcelUploadJob::dispatch($leadsUpload, FileFolder::FOLDER_LEADS,  Auth::user());
    }
}
