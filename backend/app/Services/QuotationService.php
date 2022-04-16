<?php

namespace App\Services;

use App\Models\UploadStatus;

class QuotationService
{


    /**
    * upload document file.
    *
    * @param  \Illuminate\Http\QuotationRequest  $request
    * @param  App\Models\Quotation $quotation
    *
     */
    public function uploadFile($file,$quotation)
    {
        $name = $file->hashName();
        $file->storeAs(
            'public' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_QUOTATION,
            $name
        );

        $quotation->update([
            'document' =>$name
        ]);
    }
}
