<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MeetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class MeetRequestController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            // "user_id" => "required|string",
            "meet_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();

        $validData['user_id'] = auth()->user()->id;


        try {
            $meet = MeetRequest::create($validData);
            return $this->responseSuccessWithData('Meet Request Successfully Created', $meet);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            "id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();

        $meet = MeetRequest::find($validData['id']);
        if (!$meet) {
            return $this->responseError('Meet Request not found', 404);
        } 

        $validData['status'] = true;

        try {
            $meet->update($validData);
            return $this->responseSuccessWithData('Meet Request Updated', $meet);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }

    }
}
