<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryFileRequest;
use App\Http\Requests\InventoryRequest;
use App\Http\Resources\InventoryResource;
use App\Http\Resources\NewsResource;
use App\Jobs\StoreInventoryJob;
use App\Models\Color;
use App\Models\Dealer;
use App\Models\InventoriesUpload;
use App\Models\Inventory;
use App\Models\News;
use App\Models\User;
use App\Models\Variant;
use App\Services\InventoryService;
use App\Traits\FormatResponse;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    use FormatResponse;

    /**
     * Display inventories for HCPI/Dealer user.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Inventory::with('dealer', 'variant')->ofDealer(auth()->user()->dealer_id);

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                InventoryResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render inventories '
            );
        }
    }

    /**
     * Store a inventories via excel file.
     *
     * @param  App\Http\Requests\InventoryFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryFileRequest $request)
    {
        try {

            if (request()->has('file')) {
                (new InventoryService())->storeInventoriesViaExcel($request->file('file'));

                return $this->formatSuccessResponse(
                    [],
                    'Inventories successfully inserted.'
                );
            }
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to insert inventories'
            );
        }
    }

    /**
     * Store a inventories (single store).
     *
     * @param  \Illuminate\Http\InventoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function add(InventoryRequest $request)
    {
        try {
            return $this->formatSuccessResponse(
                [
                    new InventoryResource((new InventoryService())->addInventory($request->dealer_code, $request->variant_code, $request->color_code, $request->validated()))
                ],
                'inventories successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create inventory'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryRequest $request, $id)
    {

        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->update($request->validated());

            return $this->formatSuccessResponse(
                [
                    new InventoryResource($inventory)
                ],
                'inventories successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update inventory'
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
