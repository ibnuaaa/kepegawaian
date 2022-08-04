<?php

namespace App\Http\Controllers\MataAnggaran;

use App\Models\MataAnggaran;

use App\Traits\Browse;
use App\Traits\MataAnggaran\MataAnggaranCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class MataAnggaranBrowseController extends Controller
{
    use Browse, MataAnggaranCollection {
        MataAnggaranCollection::__construct as private __MataAnggaranCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__MataAnggaranCollectionConstruct();
    }

    public function get(Request $request)
    {
        if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'tree') {
            $Browse = MataAnggaran::tree();
        } else if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'child') {
            $Browse = MataAnggaran::child($request->ArrQuery->mata_anggaran_id);
        } else  {

            $eselonBawahanAllData = [];
            $MataAnggaranEselon3 = MataAnggaran::where('parent_id', !empty(Auth::user()->active_mata_anggaran_id) ? Auth::user()->active_mata_anggaran_id : '0')->get();

            foreach ($MataAnggaranEselon3 as $keyEselon3 => $valueEselon3) {
                $eselonBawahanAllData[] = $valueEselon3->id;
                $MataAnggaranEselon4 = MataAnggaran::where('parent_id', $valueEselon3->id)->get();
                foreach ($MataAnggaranEselon4 as $keyEselon4 => $valueEselon4) {
                    $eselonBawahanAllData[] = $valueEselon4->id;
                    $staff = MataAnggaran::where('parent_id', $valueEselon4->id)->get();
                    foreach ($staff as $keyStaff => $valueStaff) {
                        $eselonBawahanAllData[] = $valueStaff->id;
                    }
                }
            }

            $Now = Carbon::now();

            $MataAnggaranParent = [];
            if (isset($request->ArrQuery->criteria) && !empty($request->get('source_mata_anggaran_id')))
            {
                if($request->ArrQuery->criteria == 'nota_dinas')
                {
                    $MataAnggaranParent = MataAnggaran::find($request->get('source_mata_anggaran_id'));
                }
            }

            $MataAnggaran = MataAnggaran::where(function ($query) use($request, $MataAnggaranParent, $eselonBawahanAllData) {
                if (isset($request->ArrQuery->id)) {
                    $query->where("$this->MataAnggaranTable.id", $request->ArrQuery->id);
                    $request->ArrQuery->set = 'first';
                }

                if (isset($request->ArrQuery->parent_id)) {
                    $query->where("$this->MataAnggaranTable.parent_id", $request->ArrQuery->parent_id);
                }

                if (isset($request->ArrQuery->unit_kerja_id)) {
                    $query->where("$this->MataAnggaranTable.unit_kerja_id", $request->ArrQuery->unit_kerja_id);
                }

                if (isset($request->ArrQuery->tipe_indikator)) {
                    $query->where("$this->MataAnggaranTable.tipe_indikator", $request->ArrQuery->tipe_indikator);
                }

                if (isset($request->ArrQuery->id_not)) {
                    $query->where("$this->MataAnggaranTable.id",'!=', $request->ArrQuery->id_not);
                }

                if (isset($request->ArrQuery->like_name_front)) {
                    $query->where("$this->MataAnggaranTable.name", 'like', $request->ArrQuery->like_name_front.'%');
                }


                if (!empty($request->get('q'))) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->MataAnggaranTable.name", 'like', '%'.$request->get('q').'%');
                    });
                }

                if (!empty($request->ArrQuery->search)) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->MataAnggaranTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                    });
                }

                if (isset($request->ArrQuery->status)) {
                    $query->where("$this->MataAnggaranTable.status", $request->ArrQuery->status);
                }

                if (isset($request->ArrQuery->parent_id_in)) {
                    $query->whereIn("$this->MataAnggaranTable.parent_id", $request->ArrQuery->parent_id_in);
                }


           })
           ->select(
                // MataAnggaran
                "$this->MataAnggaranTable.id as id",
                "$this->MataAnggaranTable.id as mata_anggaran.id",
                "$this->MataAnggaranTable.name as mata_anggaran.name",
                "$this->MataAnggaranTable.code as mata_anggaran.code",
                "$this->MataAnggaranTable.parent_id as mata_anggaran.parent_id",
                "$this->MataAnggaranTable.parent_id as parent_id",
                "$this->MataAnggaranTable.unit_kerja_id as mata_anggaran.unit_kerja_id",

                "$this->MataAnggaranTable.updated_at as mata_anggaran.updated_at",
                "$this->MataAnggaranTable.created_at as mata_anggaran.created_at",
                "$this->MataAnggaranTable.deleted_at as mata_anggaran.deleted_at"
           );

           if (!isset($request->ArrQuery->without_with)) {
               $MataAnggaran->with('parent')
               ->with('parents')
               ->with('unit_kerja_with_parents');
           }

           $Browse = $this->Browse($request, $MataAnggaran, function ($data) use($request) {
               $data = $this->Manipulate($data);
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                   return $data->map(function($MataAnggaran) {
                       return [ 'value' => $MataAnggaran->id, 'label' => $MataAnggaran->name.'('.$MataAnggaran->pejabat.'/'.$MataAnggaran->nip.')' ];
                   });
               } else if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select2')) {
                   return $data->map(function($MataAnggaran) {
                       return [ 'value' => $MataAnggaran->id, 'label' => $MataAnggaran->name.'('.$MataAnggaran->pejabat.'/'.$MataAnggaran->nip.')' ];
                   });
               } else {
                   $data = $this->GetMataAnggaranDetails($data);
               }
               return $data;
           });

            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'selection')) {
                $data_selection = [];

                $MataAnggaranMe = MataAnggaran::where('id', $request->Me->account->mata_anggaran_id)->first();
                $data_selection[] = $MataAnggaranMe->toArray();

                if(!empty($Browse['records']->parent->user->mata_anggaran)) {
                    $data_selection = $this->getSelection($Browse['records']->parent->user->mata_anggaran->toArray(), $data_selection);
                }else{
                    $data_selection = $this->getSelection($Browse['records']->user->mata_anggaran->parents->toArray(), $data_selection);
                }


                Json::set('data', $data_selection);
                return response()->json(Json::get(), 200);
            }
        }
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'mata_anggaran.', $item);
            }
            return $item;
        });
    }
}
