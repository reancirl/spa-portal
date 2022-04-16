<?php

namespace App\Services;
use App\Exceptions\AppException;
use App\Jobs\ExcelUploadJob;
use App\Models\SalesConsultantUpload;
use App\Models\UploadStatus;
use Illuminate\Support\Facades\Auth;

class SalesConsultantService
{

    /**
     * Register any application services.
     *
     * @param  App\Http\Requests\InventoryFileRequest  $request->file as $file
     * @return object
     */
    public function storeSalesConsultantViaExcel($file)
    {
        if (!$file) {
            throw new AppException("File not found.");
        }

        $name = $file->hashName();

        $file->storeAs(
            'public' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_SALES_CONSULTANT,
            $name
        );

        $salesConsultant = SalesConsultantUpload::create([
            'filename'           => $name,
            'original_filename'  => $file->getClientOriginalName(),
            'status'             =>  UploadStatus::STAT_PENDING,
            'created_by_user_id'  => auth()->user()->id
        ]);

        ExcelUploadJob::dispatch($salesConsultant, UploadStatus::FOLDER_SALES_CONSULTANT,  Auth::user());
    }
}
