<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function myProfile()
    {
        // Get Id User
        $id=auth()->user()->id;
        $UserProfile = Profile::with('user')->where('user_id', $id)->first();
        if ($UserProfile) {
            return $this->responseSuccessWithData('Success', $UserProfile);
        } else {
            return $this->responseError('UserProfile not found', 404);
        }
    }

    public function update(Request $request)
    {
        // Get Id User
        $id=auth()->user()->id;
        // return $id;
        $UserProfile = Profile::where('user_id', $id)->first();
        $userUpdate = User::where('id', $id)->first();

        if (!$UserProfile) {
            return $this->responseError('UserProfile not found', 404);
        } 
        
        $validator = Validator::make(
            $request->all(),
            [
                'name'  => "string",
                // 'email' => 'required|string|email|max:100|unique:users',
                'addres'  => "string",
                // "profile_picture" => 'image|mimes:jpg,png,jpeg,PNG',
                'gender' => "",
                'job' => "string",
                'noHp' => "string",
            ]
        );


        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();


        // if ($request->file('profile_picture')) {
        //     // $fileData = $this->uploads($request->file('image'),$path);
        //     $validData['profile_picture'] = $request->file('profile_picture')->storeAs('/public/profilePicture', Str::slug($userUpdate->name, "-").'_'.Str::random(10) . "_" . date('Y-m-d') . '.' . $request->file('profile_picture')->extension());
        //     $validData['profile_picture'] = str_replace('public', '', $validData['profile_picture']);
        // }

        try {
            $userdata['name'] = $validData['name'];

            // Update Table User
            $userUpdate->update($userdata);

            // Update Table Profile
            $UserProfile->update($validData);

            return $this->responseSuccessWithData('UserProfile updated successfully', $UserProfile);

        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }

    public function updateFoto(Request $request){
        // Get Id User
        $id=auth()->user()->id;
        $UserProfile = Profile::with('user')->where('user_id', $id)->first();
        // return $UserProfile;

        $userUpdate = User::where('id', $id)->first();

        if (!$UserProfile) {
            return $this->responseError('UserProfile not found', 404);
        }
        
        $validator = Validator::make(
            $request->all(),
            [
                "profile_picture" => 'image|mimes:jpg,png,jpeg,PNG',
            ]
        );

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();


        if ($request->file('profile_picture')) {
            // $fileData = $this->uploads($request->file('image'),$path);
            $validData['profile_picture'] = $request->file('profile_picture')->storeAs('/public/profilePicture', Str::slug($userUpdate->name, "-").'_'.Str::random(10) . "_" . date('Y-m-d') . '.' . $request->file('profile_picture')->extension());
            $validData['profile_picture'] = str_replace('public', '', $validData['profile_picture']);
        }

        try {

            // Update Table Profile
            $UserProfile->update($validData);

            return $this->responseSuccessWithData('Foto UserProfile updated successfully', $UserProfile);

        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }

    public function ubahPassword(Request $request){
        // Get Id User
        $id=auth()->user()->id;
        $userUpdate = User::where('id', $id)->first();

        
        $validator = Validator::make(
            $request->all(),
            [
                'password' => 'required|string|confirmed|min:6',
            ]
        );

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();
        $validData['password'] = bcrypt($validData['password']);

        try {
            $userdata['password'] = $validData['password'];

            // Update Table User
            $userUpdate->update($userdata);


            return $this->responseSuccessWithData('Password UserProfile updated successfully', $userUpdate);

        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }

    }


    public function getProfile(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();

        // $UserProfile = Profile::with('user')->where('user_id', $validData['user_id'])->first();

        $UserProfile = User::with('profile')->where('id', $validData['user_id'] )->first();

        if ($UserProfile) {
            return $this->responseSuccessWithData('Success', $UserProfile);
        } else {
            return $this->responseError('UserProfile not found', 404);
        }
    }
}
