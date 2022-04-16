<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Jobs\ExcelUploadJob;
use App\Jobs\StoreInquiryJobs;
use App\Models\FileFolder;
use App\Models\InquiriesUpload;
use App\Models\Inquiry;
use App\Models\UploadStatus;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InquiryService
{
    /**
     * Get all the data/search in the inquiry.
     *
     * @param mixed $file
     * @return void
     */
    public function index($request){
        $query = Inquiry::with(['assignedUser'])->ofDealer(auth()->user()->dealer_id)
                ->when($request->has('status'), function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when($request->has('action'), function ($query) use ($request) {
                    $query->where('action', $request->action);
                })
                ->when($request->has('q'), function ($query) use ($request) {
                    $query->where('first_name', 'like' , "%{$request->q}%");
                    $query->orWhere('last_name', 'like' , "%{$request->q}%");
                    $query->orWhere('email', 'like' , "%{$request->q}%");
                    $query->orWhere('province', 'like' , "%{$request->q}%");
                    $query->orWhere('municipality', 'like' , "%{$request->q}%");
                    $query->orWhere('barangay', 'like' , "%{$request->q}%");
                    $query->orWhere('status', 'like' , "%{$request->q}%");
                    $query->orWhere('action', 'like' , "%{$request->q}%");
                });
        return $query;
    }
    /**
     * Reads uploaded file thru Spout excel.
     * Stores inquiry and excel file then queue the inquiry job.
     *
     * @param mixed $file
     * @return void
     */
    public function storeInquiriesViaExcel($file)
    {
        if (!$file) {
            throw new AppException("File not found.");
        }

        $name = $file->hashName();

        $file->storeAs(
            'public' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_INQUIRIES,
            $name
        );

        $inquiriesUpload = InquiriesUpload::create([
            'filename'           => $name,
            'original_filename'  => $file->getClientOriginalName(),
            'status'             =>  UploadStatus::STAT_PENDING,
            'created_by_user_id'  => auth()->user()->id
        ]);

        ExcelUploadJob::dispatch($inquiriesUpload, FileFolder::FOLDER_INQUIRIES,  Auth::user());
    }
}
