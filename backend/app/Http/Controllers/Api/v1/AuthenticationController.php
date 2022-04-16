<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\AuthenticatedUserResource;
use App\Models\User;
use App\Services\RegistrationService;
use App\Services\UserService;
use App\Traits\FormatResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    use FormatResponse;

    /**
     * Registers user
     *
     * @param  \App\Http\Requests\RegistrationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegistrationRequest $request)
    {
        try {
            $user = (new RegistrationService)->store($request);

            $auth = (new UserService())->createAppToken($user);

            return $this->successResponse(
                [
                    'access_token' => $auth->access_token,
                    'token_type' => $auth->token_type,
                    'user' => new AuthenticatedUserResource($user),
                ],
                'User successfully registered.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Oops! User failed to register.'
            );
        }
    }

    /**
     * Login user
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                return $this->errorResponse(
                    'Invalid username or password.',
                    null,
                    [],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $user = User::where('email', $request->email)->firstOrFail();

            $auth = (new UserService())->createAppToken($user);

            return response()->json([
                'access_token' => $auth->access_token,
                'token_type' => $auth->token_type,
                'user' => new AuthenticatedUserResource($user),
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Invalid username or password.'
            );
        }
    }

    /**
     * Logouts user
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        try {
            request()->user()->currentAccessToken()->delete();

            return $this->successResponse(
                [],
                'User successfully logged out.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Oops! User failed to logout.'
            );
        }
    }
}
