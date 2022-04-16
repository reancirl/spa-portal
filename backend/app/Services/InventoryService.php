<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Jobs\ExcelUploadJob;
use App\Jobs\StoreInventoryJob;
use App\Models\Color;
use App\Models\Dealer;
use App\Models\FileFolder;
use App\Models\InventoriesUpload;
use App\Models\Inventory;
use App\Models\UploadStatus;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InventoryService
{

    /**
     *  add inventory (single store).
     *
     * @param \App\Models\News $this->news
     * @return object
     */
    public function addInventory($dealer_code, $variant_code, $color_code, $data)
    {
        $dealer = DB::table('dealers')
            ->where('code', $dealer_code)
            ->first();

        $variant = DB::table('variants')
            ->where('code', $variant_code)
            ->first();

        $color = DB::table('colors')
            ->where('code', $color_code)
            ->first();

        return Inventory::create(array_merge($data, [
            'dealer_id'          => $dealer->id,
            'variant_id'         => $variant->id,
            'color_id'           => $color->id,
            'created_by_user_id' => auth()->user()->id,
            'updated_by_user_id' => auth()->user()->id
        ]));
    }


    /**
     * read uploaded file thru spout excel.
     * store inventories and excel file then queue the inventory job .
     * 1. Store file to local storage
     * 2. Insert to inventories_upload table
     * 3. Dispatch StoreInventoryJob
     * 4. Transfer to StoreInventoryJob
     * @param  \Illuminate\Http\Request  $request->file('file')
     * @return object
     */

    public function storeInventoriesViaExcel($file)
    {
        if (!$file) {
            throw new AppException("File not found.");
        }

        $name = $file->hashName();
        $file->storeAs(
            'public' . DIRECTORY_SEPARATOR . UploadStatus::FOLDER_INVENTORY,
            $name
        );
        $inventoriesUpload = InventoriesUpload::create([
            'filename'           => $name,
            'original_filename'  => $file->getClientOriginalName(),
            'status'             => UploadStatus::STAT_PENDING,
            // 'create_by_user_id'  => auth()->user()->id
        ]);

        ExcelUploadJob::dispatch($inventoriesUpload, FileFolder::FOLDER_INVENTORY, Auth::user());
    }
}
