<?php

namespace App\Http\Controllers\MataAnggaran;



use App\Models\MataAnggaran;
use App\Models\MataAnggaranPermission;


use App\Traits\Browse;

use Carbon\Carbon;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class MataAnggaranController extends Controller
{
    use Browse;

    protected $search = [
        'id',
        'name',
        'updated_at',
        'created_at'
    ];
    public function get(Request $request)
    {
        $MataAnggaran = MataAnggaran::where(function ($query) use($request) {
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                   foreach ($this->search as $key => $value) {
                       $query->orWhere($value, 'like', $search);
                   }
               });

           }
        });
        $Browse = $this->Browse($request, $MataAnggaran, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($MataAnggaran) {
                    return [ 'value' => $MataAnggaran->id, 'label' => $MataAnggaran->name ];
                });
            } else {
                $data->map(function($MataAnggaran) {
                    if (isset($MataAnggaran->point->balance)) {
                        $MataAnggaran->point->balance = (double)$MataAnggaran->point->balance;
                    }
                    return $MataAnggaran;
                });
            }
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->MataAnggaran->save();

        Json::set('data', $this->SyncData($request, $Model->MataAnggaran->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->MataAnggaran->save();

        Json::set('data', $this->SyncData($request, $Model->MataAnggaran->id));
        return response()->json(Json::get(), 202);
    }

    public function ChangeStatus(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->MataAnggaran->save();

        Json::set('data', $this->SyncData($request, $Model->MataAnggaran->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->MataAnggaran->delete();
        return response()->json(Json::get(), 202);
    }

    public function DeveloperToken(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        Json::set('data', [
            'token_type' => 'Bearer',
            'access_token' => $Model->MataAnggaran->createToken('ServiceAccessToken', ['blast'])->accessToken
        ]);
        return response()->json(Json::get(), 202);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $data = $this->get($QueryRoute);
        return $data->original['data']['records'];
    }
}
