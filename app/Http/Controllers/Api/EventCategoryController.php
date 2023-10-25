<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        $categories = EventCategory::get();
    
        if(count($categories)){
            return $this->responseSuccessWithData('Success', $categories);

        }
        else{
            return $this->responseError('Category not found', 404);
        }
    }
}
