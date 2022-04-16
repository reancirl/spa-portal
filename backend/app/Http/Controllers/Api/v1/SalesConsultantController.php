<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryFileRequest;
use App\Http\Requests\SalesConsultantRequest;
use App\Http\Resources\AuthenticatedUserResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Services\SalesConsultantService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SalesConsultantController extends Controller
{

    use FormatResponse;
    /**
     * Display a listing of the resource.
     * @param Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = User::ofDealer(auth()->user()->dealer_id)
                ->when($request->has('q'), function ($query) use ($request) {
                    $query->where('first_name', 'like', $request->q);
                })
                ->when($request->has('dealer_id'), function ($query) use ($request) {
                    $query->where('dealer_id', $request->dealer_id);
                })
                ->whereHas('userRoles.role', function (Builder $query) {
                    $query->where('slug', 'sales_consultant');
                });
            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                AuthenticatedUserResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render sales consultant.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SalesConsultantRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalesConsultantRequest $request)
    {
        try {
            $data = $request->validated();
            $data['dealer_id'] = auth()->user()->dealer_id;

            $user = User::create(array_merge($data, [
                'created_by_user_id' => auth()->user()->id
            ]));

            $role = Role::where('slug', 'sales_consultant')->firstOrFail();

            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);

            return $this->formatSuccessResponse(
                [
                    new AuthenticatedUserResource($user)
                ],
                'Sales consultant successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create sales consultant.'
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
            $user = User::ofDealer(auth()->user()->dealer_id)
                ->where('id', $id)
                ->whereHas('userRoles.role', function (Builder $query) {
                    $query->where('slug', 'sales_consultant');
                })
                ->first();

            return $this->successResponse(
                new AuthenticatedUserResource($user)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get Sales consultant.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\InventoryFileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function insert(InventoryFileRequest $request)
    {
        try {
            if ($request->has('file')) {
                (new SalesConsultantService())->storeSalesConsultantViaExcel($request->file('file'));

                return $this->formatSuccessResponse(
                    [],
                    'sales consultant successfully inserted.'
                );
            }
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create leads'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\SalesConsultantRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SalesConsultantRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update($request->validated());

            return $this->formatSuccessResponse(
                [
                    new AuthenticatedUserResource($user)
                ],
                'Sales consultant successfully update.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update sales consultant'
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
            $data = User::findOrFail($id);

            $data->delete();

            return $this->formatSuccessResponse(
                [],
                'Sales consultant successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to deleted Sales consultant.'
            );
        }
    }
}
