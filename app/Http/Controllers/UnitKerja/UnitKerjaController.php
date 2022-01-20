<?php

namespace App\Http\Controllers\UnitKerja;



use App\Models\UnitKerja;
use App\Models\UnitKerjaPermission;


use App\Traits\Browse;

use Carbon\Carbon;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class UnitKerjaController extends Controller
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
        $UnitKerja = UnitKerja::where(function ($query) use($request) {
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                   foreach ($this->search as $key => $value) {
                       $query->orWhere($value, 'like', $search);
                   }
               });

           }
        });
        $Browse = $this->Browse($request, $UnitKerja, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($UnitKerja) {
                    return [ 'value' => $UnitKerja->id, 'label' => $UnitKerja->name ];
                });
            } else {
                $data->map(function($UnitKerja) {
                    if (isset($UnitKerja->point->balance)) {
                        $UnitKerja->point->balance = (double)$UnitKerja->point->balance;
                    }
                    return $UnitKerja;
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
        $Model->UnitKerja->save();

        Json::set('data', $this->SyncData($request, $Model->UnitKerja->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UnitKerja->save();
        
        Json::set('data', $this->SyncData($request, $Model->UnitKerja->id));
        return response()->json(Json::get(), 202);
    }

    public function ChangeStatus(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UnitKerja->save();

        Json::set('data', $this->SyncData($request, $Model->UnitKerja->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->UnitKerja->delete();
        return response()->json(Json::get(), 202);
    }

    public function DeveloperToken(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        Json::set('data', [
            'token_type' => 'Bearer',
            'access_token' => $Model->UnitKerja->createToken('ServiceAccessToken', ['blast'])->accessToken
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
