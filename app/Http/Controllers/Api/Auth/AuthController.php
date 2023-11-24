<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Profile;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\Auth\AuthController;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        if (! $token = auth()->attempt($validator->validated())) {
            // return response()->json(['error' => 'Unauthorized'], 401);
            return $this->responseFailValidation(['error' => 'Unauthorized']);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()){
            return $this->responseFailValidation($validator->errors());

        }

        
       $validData = $validator->validated();
       $validData['password'] = bcrypt($validData['password']);
       $validData['role_id'] = 2;
       $validData['slug'] = Str::of($validData['name'])->slug('-')->append('-', Str::random(5));


        try {
            $data=User::create($validData);
            $this->createNotification($data->id, 'Selamat Datang !, Registrasi Anda Berhasil !');
            $profile['user_id'] = $data->id;
            $profile['profile_picture'] = '/profilePicture/usericon.png';

            $checkProfile = Profile::where('user_id', $profile['user_id'])->get();

            // return $checkProfile;
            if(!count($checkProfile)){
            // if (!$checkProfile) {
                $profile = Profile::create($profile);
                $succes['user'] = $data;
                $succes['profile'] = $profile;

            } 

            return $this->responseCreated("Successfully registered.", $succes);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }

    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return $this->responseSuccess("User successfully signed out");

    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return $this->responseSuccessWithData("Successfully get user profile.", auth()->user());

    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){

        return $this->responseCreated("Successfully registered.", 
                                        [
                                            'access_token' => $token,
                                            'token_type' => 'bearer',
                                            // 'expires_in' => auth()->factory()->getTTL() * 1440,
                                            'expires_in' => 'null',
                                            'user' => auth()->user()->load('role', 'profile')
                                        ]
                                    );

    }
}
