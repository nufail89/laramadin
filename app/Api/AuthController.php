<?php

namespace App\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use OpenAdmin\Admin\Facades\Admin;


class AuthController extends Controller
{
    public function index(){
        return response()->json([
            'status'=>false,
            'message'=>'akses tidak diperbolehkan'
        ],401 );
    }
        /**
     * Handle a login request.
     *
     * @param Request $request
     *
     * @return mixed
     */

    public function postLogin(Request $request)
    {
        try {
            $this->loginValidator($request->all())->validate();
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $e->errors()
            ], 422);
        }
        
        $rate_limit_key = 'login-tries-'.Admin::guardName();
        $credentials = $request->only([$this->username(), 'password']);
        $remember    = $request->get('remember', false);

        if ($this->guard()->attempt($credentials, $remember)) {
            RateLimiter::clear($rate_limit_key);
            $user = $this->guard()->user();
            $tUsrPersons = $user->tUsrPerson()->first();
            dd($tUsrPersons->jabatan_id);
            $token = $user->createToken($user->username, ['guru'], now()->addYear())->plainTextToken;
            return response()->json(['status'=>true,'token' => $token, 'message' => 'Successfully Logged in!']);
        }

        if (config('admin.auth.throttle_logins')) {
            $throttle_timeout = config('admin.auth.throttle_timeout', 600);
            RateLimiter::hit($rate_limit_key, $throttle_timeout);
        }
        return response()->json(['status' => false, 'message' => 'Invalid username/password'], 401);
    }

    /**
     * Get a validator for an incoming login request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function loginValidator(array $data)
    {
        return Validator::make($data, [
            $this->username() => 'required',
            'password'        => 'required',
        ]);
    }

    public function getLogout(Request $request)
    {
        $this->guard()->logout();
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => true, 'message' => 'Berhasil Logout'], 200);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
        return 'username';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Admin::guard();
    }
}
