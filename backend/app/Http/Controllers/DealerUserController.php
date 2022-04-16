<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\AuthenticatedUserResource;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Traits\FormatResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DealerUserController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     * @param Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $query = User::whereHas('userRoles.role', function (Builder $query) {
            $query->where('slug', 'dealer');
        });
        $data = $this->paginate($query, $request->per_page, $request->all());

        return $this->successResourceResponse(
            AuthenticatedUserResource::collection($data)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        try {
            $user = User::create(array_merge($request->validated(), [
                'created_by_user_id' => auth()->user()->id
            ]));

            $role = Role::where('slug', 'dealer')->firstOrFail();
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);
            return $this->formatSuccessResponse(
                [
                    new AuthenticatedUserResource($user)
                ],
                'Dealer user successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create dealer user.'
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
    public function update(UserRequest $request, $id)
    {
        try {
            $data = User::findOrFail($id);
            $data->update($request->validated());

            return $this->formatSuccessResponse(
                [
                    new AuthenticatedUserResource($data)
                ],
                'Dealer user successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create dealer user.'
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
                [
                    new AuthenticatedUserResource($data)
                ],
                'Dealer user successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create dealer user.'
            );
        }
    }
}
