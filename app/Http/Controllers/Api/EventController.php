<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Helper\Media;
use App\Models\ReportEvent;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{


    public function index( Request $request)
    {
        $limit = $request->input('limit', 100); 
        $events = Event::with(['eventCategory', 'user'])
                            // ->where('status',true)
                            ->take($limit)
                            ->orderBy('id', 'desc')
                            ->get();

        $formattedEvent = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => strlen($event->name) > 20 ? substr($event->name, 0, 20) . '...' : $event->name,
                'event_category_id' => $event->event_category_id,
                'description' => $event->description,
                'date' => $event->date,
                'image' => $event->image,
                'place' => $event->place,
                'address' => $event->address,
                'user' => [
                    'id' => $event->user->id,
                    'name' => $event->user->name,
                ],
                'eventCategory' => [
                    'id' => $event->eventCategory->id,
                    'name' => $event->eventCategory->name,
                    // Include other category data here
                ],
                // Include other post data here
            ];
        });
    
        if(count($formattedEvent)){
            return $this->responseSuccessWithData('Success', $formattedEvent);
        }
        else{
            return $this->responseError('Event not found', 404);
        }
    }

    public function getEventByCategory(Request $request, $id){

        $limit = $request->input('limit', 100); 

        $events = Event::with(['eventCategory'])
        // ->where('status',true)
        ->where('event_category_id',$id)
        ->take($limit)
        ->orderBy('id', 'desc')
        ->get();

        if(count($events)){
            return $this->responseSuccessWithData('Success', $events);

        }
        else{
            return $this->responseError('Event not found', 404);
        }

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|string",
            "event_category_id" => "required",
            "description" => "required|string",
            "date" => "required",
            "image" => "required",
            "place" => "required",
            "address" => "required",

        ]);

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();

        $validData['status'] = false;
        $validData['user_id'] = auth()->user()->id;

        //  $path = storage_path('public/event/');

        if ($request->file('image')) {
            // $fileData = $this->uploads($request->file('image'),$path);
            $validData['image'] = $request->file('image')->storeAs('/public/event', Str::slug($validData['name'], "-").'_'.Str::random(10) . "_" . date('Y-m-d') . '.' . $request->file('image')->extension());
            $originalPath = 'public/event/coba1aa-1698422765.jpg';
            $validData['image'] = str_replace('public', '', $validData['image']);
        }

        try {
            $event = Event::create($validData);
            return $this->responseSuccessWithData('Event Successfully Created', $event);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }

    public function storebase(Request $request)
    {

        // return 'base';
        $validator = Validator::make($request->all(),[
            "name" => "required|string",
            "event_category_id" => "required",
            "description" => "required|string",
            "date" => "required",
            "image" => "required",
            "place" => "required",
            "address" => "required",

        ]);

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();

        $validData['status'] = false;
        $validData['user_id'] = auth()->user()->id;


        // if ($request->file('image')) {
        //     $validData['image'] = $request->file('image')->storeAs('/public/event', Str::slug($validData['name'], "-").'_'.Str::random(10) . "_" . date('Y-m-d') . '.' . $request->file('image')->extension());
        //     $originalPath = 'public/event/coba1aa-1698422765.jpg';
        //     $validData['image'] = str_replace('public', '', $validData['image']);
        // }

        // Get the base64 image data from the request
        $base64Image = $request->input('image');

        // Decode the base64 data to a binary image
        $imageData = base64_decode($base64Image);

        // Define the desired file path and name in the storage folder
        $filePath = 'public/event/' .Str::slug($validData['name'], "-") . uniqid() . '.jpg';

        // Save the binary image data to the specified path
        Storage::put($filePath, $imageData);

        // Save the image name to the database
        $imageName = basename($filePath);
        $validData['image'] = '/event/'.$imageName;
        // Image::create(['image_name' => $imageName]);

        try {
            $event = Event::create($validData);
            return $this->responseSuccessWithData('Event Successfully Created', $event);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }

    public function show(string $id){
        $events = Event::with(['eventCategory', 'meets.user'])->find($id);

        if($events){
            return $this->responseSuccessWithData('Success', $events);

        }
        else{
            return $this->responseError('Event not found', 404);
        }
    }

    public function myEvent(Request $request){
        $id = auth()->user()->id;

        $limit = $request->input('limit', 100); 
        $events = Event::with(['eventCategory', 'user'])
                            ->where('user_id',$id)
                            // ->where('status',true)
                            ->take($limit)
                            ->orderBy('id', 'desc')
                            ->get();

        $formattedEvent = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => strlen($event->name) > 20 ? substr($event->name, 0, 20) . '...' : $event->name,
                'event_category_id' => $event->event_category_id,
                'description' => $event->description,
                'date' => $event->date,
                'image' => $event->image,
                'place' => $event->place,
                'address' => $event->address,
                'user' => [
                    'id' => $event->user->id,
                    'name' => $event->user->name,
                ],
                'eventCategory' => [
                    'id' => $event->eventCategory->id,
                    'name' => $event->eventCategory->name,
                    // Include other category data here
                ],
                // Include other post data here
            ];
        });
    
        if(count($formattedEvent)){
            return $this->responseSuccessWithData('Success', $formattedEvent);
        }
        else{
            return $this->responseError('Event not found', 404);
        }

    }

    public function searchEvent(Request $request){
 
        $query = $request->input('query'); 
        $limit = $request->input('limit', 100); 
        $events = Event::with(['eventCategory', 'user'])
                            ->where('name', 'LIKE', "%$query%")
                            // ->where('status',true)
                            ->take($limit)
                            ->orderBy('id', 'desc')
                            ->get();

        $formattedEvent = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'name' => strlen($event->name) > 20 ? substr($event->name, 0, 20) . '...' : $event->name,
                'event_category_id' => $event->event_category_id,
                'description' => $event->description,
                'date' => $event->date,
                'image' => $event->image,
                'place' => $event->place,
                'address' => $event->address,
                'user' => [
                    'id' => $event->user->id,
                    'name' => $event->user->name,
                ],
                'eventCategory' => [
                    'id' => $event->eventCategory->id,
                    'name' => $event->eventCategory->name,
                    // Include other category data here
                ],
                // Include other post data here
            ];
        });
    
        if(count($formattedEvent)){
            return $this->responseSuccessWithData('Success', $formattedEvent);
        }
        else{
            return $this->responseError('Event not found', 404);
        }

    }

    public function report(Request $request){
        $id = auth()->user()->id;

        $validator = Validator::make($request->all(),[
            "event_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();

        $validData['user_id'] = $id;


        try {
            $meet = ReportEvent::create($validData);
            return $this->responseSuccessWithData('Event Berhasil Dilaporkan', $meet);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }
}
