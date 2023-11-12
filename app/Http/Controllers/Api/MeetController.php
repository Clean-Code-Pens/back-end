<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Meet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class MeetController extends Controller
{
    public function index(Request $request)
    {

        $limit = $request->input('limit', 100); 

        $meets = Meet::with(['user', 'event'])
                        ->take($limit)
                        ->orderBy('id', 'desc')
                        ->get();
    
        if(count($meets)){
            return $this->responseSuccessWithData('Success', $meets);

        }
        else{
            return $this->responseError('Meeting not found', 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|string",
            "event_id" => "required",
            "description" => "required|string",
            "people_need" => "required",
        ]);

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();

        $validData['user_id'] = auth()->user()->id;


        try {
            $meet = Meet::create($validData);
            return $this->responseSuccessWithData('Meet Successfully Created', $meet);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }

    public function show(string $id){
        $meets = Meet::with(['user', 'event'])->find($id);

        if($meets){
            return $this->responseSuccessWithData('Success', $meets);

        }
        else{
            return $this->responseError('Meet not found', 404);
        }
    }

    public function byevent(Request $request, string $id)
    {

        $limit = $request->input('limit', 100); 

        $meets = Meet::with(['user', 'event'])
                        ->where('event_id', $id)
                        ->take($limit)
                        ->orderBy('id', 'desc')
                        ->get();
    
        if(count($meets)){
            return $this->responseSuccessWithData('Success', $meets);

        }
        else{
            return $this->responseError('Meeting not found', 404);
        }
    }

    public function event(Request $request)
    {

        $limit = $request->input('limit', 100); 
        $id = $request->event_id;
        $meets = Meet::with(['user', 'event'])
                        ->where('event_id', $id)
                        ->take($limit)
                        ->get();
    
        if(count($meets)){
            return $this->responseSuccessWithData('Success', $meets);

        }
        else{
            return $this->responseError('Meeting not found', 404);
        }
    }

    public function myMeet(Request $request){
        $id = auth()->user()->id;
        $limit = $request->input('limit', 100); 
        $meets = Meet::with(['user', 'event'])
                        ->take($limit)
                        ->orderBy('id', 'desc')
                        ->where('user_id', $id)
                        ->get();
        if(count($meets)){
            return $this->responseSuccessWithData('Success', $meets);

        }
        else{
            return $this->responseError('Meeting not found', 404);
        }
    }

}
