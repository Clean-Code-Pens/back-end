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

        $meetRequest = MeetRequest::where('user_id', $validData['user_id'])->where('meet_id', $validData['meet_id'])->first();
        if($meetRequest){
            return $this->responseFailValidation('Anda Sudah Pernah Mengajukan !!');
            // return $this->responseSuccessWithData('Success', $meets);

        }

        try {
            $meet = MeetRequest::create($validData);
            $this->createNotification($validData['user_id'], 'Pengajuan Meeting Anda Berhasil, Mohon Tunggu Hingga Disetujui');

            return $this->responseSuccessWithData('Meet Request Successfully Created', $meet);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }

    public function acceptMeet(Request $request){
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

        $validData['status'] = 'accepted';

        try {
            $meet->update($validData);
            $this->createNotification(auth()->user()->id, 'Anda telah menyetujui pengguna lain untuk hadir di pertemuan anda');
            $this->createNotification($meet->user_id, 'Pengajuan anda telah di setujui pembuat meet');

            return $this->responseSuccessWithData('Berhasil Disetujui', $meet);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }

    }

    public function rejectMeet(Request $request){
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

        $validData['status'] = 'reject';

        try {
            $meet->update($validData);
            $this->createNotification(auth()->user()->id, 'Anda telah menolak pengguna lain untuk hadir di pertemuan anda');
            $this->createNotification($meet->user_id, 'Pengajuan anda telah ditolak pembuat meet');
            return $this->responseSuccessWithData('Berhasil Ditolak', $meet);
        } catch (QueryException $e) {
            return $this->responseError("Internal Server Error", 500, $e->errorInfo);
        }
    }

    public function getByMeet(Request $request){
        $validator = Validator::make($request->all(),[
            "meet_id" => "required",
        ]);

        if ($validator->fails()) {
            return $this->responseFailValidation($validator->errors());
        }

        $validData = $validator->validated();

        $meet = MeetRequest::with('user.profile')
                ->where('meet_id', $validData['meet_id'])
                ->where('status', '!=', 'reject')
                ->get();

        
        if(count($meet)){
            return $this->responseSuccessWithData('Success', $meet);

        }
        else{
            return $this->responseError('Belum Ada Orang Yang Mendaftar', 404);
        }
    }
}
