<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticationController extends Controller
{

    use ApiResponse;

    public function register(RegisterRequest $request)
    {
        $request['password'] = bcrypt($request->password);
        $user = User::create($request->all());

        $accessToken  = $user->createToken('authToken')->plainTextToken;

        LogActivity::addToLog('Success register','true','RegisterApi');

        return $this->successResponse(["user" => new RegisterResource($user),'access_token' => $accessToken],'User Created', 201);

    }


    /**
     * Logged in
     *
     * @return [json] message object
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->only('nick', 'password');

        if (!Auth::attempt($credentials)) {

            LogActivity::addToLog('Error login','false','LoginApi','','Credentials do not match please try again');

            return $this->errorResponse('Invalid Credentials',"Credentials do not match please try again",401);
        }

        Auth::user()->tokens()->delete();

        $accessToken =Auth::user()->createToken('authToken')->plainTextToken;

        LogActivity::addToLog('Success login','true','LoginApi');
        return  $this->successResponse(['user' => auth()->user(), 'access_token' => $accessToken],'Successfully logged in!',200);
    }


     /**
     * Logged out
     *
     * @return [json] message object
     */
    public function logout(Request $request)
    {
        try {
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();
            return  $this->successResponse([''],'Successfully logged out!',200);
        } catch (\Throwable $exception) {
            LogActivity::addToLog('The record could not be updated', 'false', 'LogoutApi', '', $exception->getMessage());
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }

    }

}
