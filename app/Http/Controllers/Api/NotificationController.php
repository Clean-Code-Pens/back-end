<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {

        $id = auth()->user()->id;
        $limit = $request->input('limit', 100); 
        $meets = Notification::take($limit)
                        ->orderBy('id', 'desc')
                        ->where('user_id', $id)
                        ->get();
        if(count($meets)){
            return $this->responseSuccessWithData('Success', $meets);

        }
        else{
            return $this->responseError('Notification not found', 404);
        }
    }
}
