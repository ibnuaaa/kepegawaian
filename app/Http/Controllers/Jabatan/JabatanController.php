<?php

namespace App\Http\Controllers\Jabatan;



use App\Models\Jabatan;
use App\Models\JabatanPermission;


use App\Traits\Browse;

use Carbon\Carbon;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class JabatanController extends Controller
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
        $Jabatan = Jabatan::where(function ($query) use($request) {
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                   foreach ($this->search as $key => $value) {
                       $query->orWhere($value, 'like', $search);
                   }
               });

           }
        });
        $Browse = $this->Browse($request, $Jabatan, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($Jabatan) {
                    return [ 'value' => $Jabatan->id, 'label' => $Jabatan->name ];
                });
            } else {
                $data->map(function($Jabatan) {
                    if (isset($Jabatan->point->balance)) {
                        $Jabatan->point->balance = (double)$Jabatan->point->balance;
                    }
                    return $Jabatan;
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
        $Model->Jabatan->save();

        Json::set('data', $this->SyncData($request, $Model->Jabatan->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Jabatan->save();
        
        Json::set('data', $this->SyncData($request, $Model->Jabatan->id));
        return response()->json(Json::get(), 202);
    }

    public function ChangeStatus(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Jabatan->save();

        Json::set('data', $this->SyncData($request, $Model->Jabatan->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Jabatan->delete();
        return response()->json(Json::get(), 202);
    }

    public function DeveloperToken(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        Json::set('data', [
            'token_type' => 'Bearer',
            'access_token' => $Model->Jabatan->createToken('ServiceAccessToken', ['blast'])->accessToken
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
