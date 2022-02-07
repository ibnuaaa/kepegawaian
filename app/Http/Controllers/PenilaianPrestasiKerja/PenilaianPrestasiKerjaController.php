<?php

namespace App\Http\Controllers\PenilaianPrestasiKerja;

use App\Models\PenilaianPrestasiKerja;
use App\Models\IndikatorTetap;
use App\Models\Jabatan;
use App\Models\PenilaianPrestasiKerjaItem;


use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class PenilaianPrestasiKerjaController extends Controller
{
    use Browse;

    protected $search = [
        'id',
        'code',
        'name'
    ];
    public function get(Request $request)
    {
        $PenilaianPrestasiKerja = PenilaianPrestasiKerja::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->information()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                  $query->where('code', 'like', $search);
                  $query->orWhere('name', 'like', $search);
               } else {
                   $query->where(function ($query) use($search) {
                       foreach ($this->search as $key => $value) {
                           $query->orWhere($value, 'like', $search);
                       }
                   });
               }
           }
        });
        $Browse = $this->Browse($request, $PenilaianPrestasiKerja, function ($data) use($request) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianPrestasiKerja->save();

        $IndikatorTetapPerilakuKerja = IndikatorTetap::where('type', 'perilaku_kerja')->get();

        $Jabatan = Jabatan::where('id', MyAccount()->jabatan_id)->first();
        
        foreach ($IndikatorTetapPerilakuKerja as $key => $value) {

            $PenilaianPrestasiKerjaItem = new PenilaianPrestasiKerjaItem();

            if ($Jabatan->is_staff) {
              $PenilaianPrestasiKerjaItem->bobot = $value->bobot_staff;
            } else  {
              $PenilaianPrestasiKerjaItem->bobot = $value->bobot_pimpinan;
            }
            $PenilaianPrestasiKerjaItem->penilaian_prestasi_kerja_id = $Model->PenilaianPrestasiKerja->id;
            $PenilaianPrestasiKerjaItem->user_id = MyAccount()->id;
            $PenilaianPrestasiKerjaItem->indikator_tetap_id = $value->id;
            $PenilaianPrestasiKerjaItem->type = $value->type;
            $PenilaianPrestasiKerjaItem->save();

        }



        if ($Jabatan->is_staff) {
            $IndikatorTetapKualitas = IndikatorTetap::where('type', 'kualitas')->get();
            foreach ($IndikatorTetapKualitas as $key => $value) {

                $PenilaianPrestasiKerjaItem = new PenilaianPrestasiKerjaItem();
                $PenilaianPrestasiKerjaItem->penilaian_prestasi_kerja_id = $Model->PenilaianPrestasiKerja->id;
                $PenilaianPrestasiKerjaItem->user_id = MyAccount()->id;
                $PenilaianPrestasiKerjaItem->indikator_tetap_id = $value->id;
                $PenilaianPrestasiKerjaItem->type = $value->type;
                $PenilaianPrestasiKerjaItem->save();

            }
        }

        Json::set('data', $this->SyncData($request, $Model->PenilaianPrestasiKerja->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianPrestasiKerja->save();

        Json::set('data', $this->SyncData($request, $Model->PenilaianPrestasiKerja->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->PenilaianPrestasiKerja->delete();
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
