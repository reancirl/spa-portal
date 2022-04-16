<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Traits\FormatResponse;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use FormatResponse;

    /**
     * Sends reset link
     *
     * @param  \App\Http\Requests\ForgotPasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function forgot(ForgotPasswordRequest $request)
    {
        try {
            Password::sendResetLink($request->validated());

            return $this->formatSuccessResponse(
                [],
                'Reset password link sent on your email id.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to send reset link.'
            );
        }
    }

    /**
     * Resets password
     *
     * @param  \App\Http\Requests\ResetPasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(ResetPasswordRequest $request)
    {
        try {
            $resetStatus = Password::reset($request->validated(), function ($user, $password) {
                $user->password = $password;
                $user->save();
            });

            if ($resetStatus === Password::INVALID_TOKEN) {
                return $this->errorResponse(
                    'Invalid token provided.'
                );
            }

            return $this->formatSuccessResponse(
                [],
                'Password has been successfully changed.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed on password reset.'
            );
        }
    }
}
