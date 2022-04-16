<?php

namespace App\Services;

use App\Jobs\ExcelUploadJob;
use App\Models\TestDriveUpload;
use App\Models\UploadStatus;
use Illuminate\Support\Facades\Auth;

class TestDriveService
{
    /**
     * store  test drive via excel .
     *
     * @param \App\Models\Leads $leads
     * @return object
     */

    public function storeTestDriveViaExcel($file)
    {
        $name = $file->hashName();
        $file->storeAs(
            'public' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_TEST_DRIVE,
            $name
        );

        $testDriveUpload = TestDriveUpload::create([
            'filename'           => $name,
            'original_filename'  => $file->getClientOriginalName(),
            'status'             =>  UploadStatus::STAT_PENDING,
            // 'create_by_user_id'  => auth()->user()->id
        ]);

        ExcelUploadJob::dispatch($testDriveUpload, UploadStatus::FOLDER_TEST_DRIVE,  Auth::user());
    }
}
