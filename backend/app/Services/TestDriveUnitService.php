<?php

namespace App\Services;

use App\Jobs\ExcelUploadJob;
use App\Models\TestDriveUnit;
use App\Models\TestDriveUnitUpload;
use App\Models\TestDriveUpload;
use App\Models\UploadStatus;
use App\Models\Variant;
use Illuminate\Support\Facades\Auth;

class TestDriveUnitService
{

    /**
     * store  test drive unit via excel .
     *
     * @param \App\Models\Leads $leads
     * @return object
     */

    public function storeTestDriveUnitViaExcel($file)
    {
        $name = $file->hashName();
        $file->storeAs(
            'public' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_TEST_DRIVE_UNIT,
            $name
        );

        $testDriveUnitUpload = TestDriveUnitUpload::create([
            'filename'           => $name,
            'original_filename'  => $file->getClientOriginalName(),
            'status'             =>  UploadStatus::STAT_PENDING,
            // 'create_by_user_id'  => auth()->user()->id
        ]);

        ExcelUploadJob::dispatch($testDriveUnitUpload, UploadStatus::FOLDER_TEST_DRIVE_UNIT,  Auth::user());
    }
}
