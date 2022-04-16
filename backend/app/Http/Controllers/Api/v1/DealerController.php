<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DealerRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\AuthenticatedUserResource;
use App\Http\Resources\DealerResource;
use App\Models\Dealer;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class DealerController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\DealerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Dealer::when($request->has('name'), function ($query) use ($request) {
                $query->where('name', $request->name);
            })->orderBy('name');

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                DealerResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render dealer.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\DealerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerRequest $request)
    {
        try {
            $data = $request->validated();

            $data['bank_details'] = json_decode($data['bank_details']);

            return $this->formatSuccessResponse(
                [
                    new DealerResource(Dealer::create($data))
                ],
                ' dealer successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create  dealer '
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->successResponse(
                new DealerResource(Dealer::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get dealer.'
            );
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\DealerRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealerRequest $request, $id)
    {
        try {
            $data = Dealer::findOrFail($id);
            $data->update($request->validated());

            return $this->formatSuccessResponse(
                [
                    new DealerResource($data)
                ],
                'Dealers successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to updated  dealers'
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
        try {
            $data = Dealer::findOrFail($id);
            $data->delete();

            return $this->formatSuccessResponse(
                [],
                'Dealer successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete dealer. '
            );
        }
    }
}
