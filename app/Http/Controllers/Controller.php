<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function responseFailValidation($errors)
    {
        return response()->json([
            'success' => false,
            'message' => $errors
        ], 422);
    }

    public function responseError($msg, $code, $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $msg,
            'error' => $error,
        ], $code);
    }

    public function responseSuccess($msg = null)
    {
        return response()->json([
            'success' => true,
            'message' => $msg,
        ], 200);
    }

    public function responseSuccessWithData($msg = null, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $msg,
            'data' => $data
        ], 200);
    }

    public function createNotification($user_id = null, $description = null)
    {

        $validData['user_id'] = $user_id;
        $validData['description'] = $description;
        $notif = Notification::create($validData);
    }

    // public function responseSuccessWithData($msg = null, $data = null)
    // {
    //     $response = new \stdClass;
    //     $response->success = true;
    //     $response->message = $msg;
    //     $response->data = $data;

    //     return response()->json($response, 200);
    // }



    public function responseCreated($msg = null, $data = null)
    {
        return response()->json([
            'success' => true,
            'message' => $msg,
            'data' => $data
        ], 201);
    }
}
