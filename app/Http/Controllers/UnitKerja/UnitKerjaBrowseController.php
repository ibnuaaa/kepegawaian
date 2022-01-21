<?php

namespace App\Http\Controllers\UnitKerja;

use App\Models\UnitKerja;

use App\Traits\Browse;
use App\Traits\UnitKerja\UnitKerjaCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class UnitKerjaBrowseController extends Controller
{
    use Browse, UnitKerjaCollection {
        UnitKerjaCollection::__construct as private __UnitKerjaCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UnitKerjaCollectionConstruct();
    }

    public function get(Request $request)
    {
        if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'tree') {
            $Browse = UnitKerja::tree();
        } else if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'child') {
            $Browse = UnitKerja::child($request->ArrQuery->unit_kerja_id);
        } else  {

            $eselonBawahanAllData = [];
            $UnitKerjaEselon3 = UnitKerja::where('parent_id', !empty(Auth::user()->active_unit_kerja_id) ? Auth::user()->active_unit_kerja_id : '0')->get();

            foreach ($UnitKerjaEselon3 as $keyEselon3 => $valueEselon3) {
                $eselonBawahanAllData[] = $valueEselon3->id;
                $UnitKerjaEselon4 = UnitKerja::where('parent_id', $valueEselon3->id)->get();
                foreach ($UnitKerjaEselon4 as $keyEselon4 => $valueEselon4) {
                    $eselonBawahanAllData[] = $valueEselon4->id;
                    $staff = UnitKerja::where('parent_id', $valueEselon4->id)->get();
                    foreach ($staff as $keyStaff => $valueStaff) {
                        $eselonBawahanAllData[] = $valueStaff->id;
                    }
                }
            }

            $Now = Carbon::now();

            $UnitKerjaParent = [];
            if (isset($request->ArrQuery->criteria) && !empty($request->get('source_unit_kerja_id')))
            {
                if($request->ArrQuery->criteria == 'nota_dinas')
                {
                    $UnitKerjaParent = UnitKerja::find($request->get('source_unit_kerja_id'));
                }
            }

            $UnitKerja = UnitKerja::where(function ($query) use($request, $UnitKerjaParent, $eselonBawahanAllData) {
                if (isset($request->ArrQuery->id)) {
                    $query->where("$this->UnitKerjaTable.id", $request->ArrQuery->id);
                    $request->ArrQuery->set = 'first';
                }

                if (isset($request->ArrQuery->null_parent_id)) {
                    $query->whereNull("$this->UnitKerjaTable.parent_id");
                }

                if (isset($request->ArrQuery->parent_id)) {
                    $query->where("$this->UnitKerjaTable.parent_id", $request->ArrQuery->parent_id);
                }

                if (isset($request->ArrQuery->id_not)) {
                    $query->where("$this->UnitKerjaTable.id",'!=', $request->ArrQuery->id_not);
                }

                if (isset($request->ArrQuery->like_name_front)) {
                    $query->where("$this->UnitKerjaTable.name", 'like', $request->ArrQuery->like_name_front.'%');
                }

                if (isset($request->ArrQuery->ses_id)) {
                    $query->where("$this->UnitKerjaTable.id", $request->ArrQuery->ses_id.'%');
                }

                if (!empty($request->get('q'))) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->UnitKerjaTable.name", 'like', '%'.$request->get('q').'%');
                    });
                }

                if (!empty($request->ArrQuery->search)) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->UnitKerjaTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                    });
                }

                if (isset($request->ArrQuery->status)) {
                    $query->where("$this->UnitKerjaTable.status", $request->ArrQuery->status);
                }

                if (isset($request->ArrQuery->parent_id_in)) {
                    $query->whereIn("$this->UnitKerjaTable.parent_id", $request->ArrQuery->parent_id_in);
                }

                if (isset($request->ArrQuery->all_bawahan) && $request->ArrQuery->all_bawahan == 'y') {
                    $query->whereIn("$this->UnitKerjaTable.id", $eselonBawahanAllData);
                }

                if (MyAccount()->unit_kerja_id == '4' && MyAccount()->website_id) {
                    $query->whereIn("$this->UnitKerjaTable.id", [1]);
                }

                // if (isset($request->ArrQuery->criteria) && !empty($request->get('source_unit_kerja_id')))
                // {
                //     if($request->ArrQuery->criteria == 'surat')
                //     {
                //         $query->where("$this->UnitKerjaTable.parent_id", $request->get('source_unit_kerja_id'));
                //     }
                //     else if($request->ArrQuery->criteria == 'nota_dinas')
                //     {
                //         $query->where(function ($query) use($request, $UnitKerjaParent) {
                //             $query->where("$this->UnitKerjaTable.id", $UnitKerjaParent->parent_id);
                //             $query->orWhere("$this->UnitKerjaTable.parent_id", $UnitKerjaParent->parent_id);
                //         });
                //     }
                // }
           })
           ->select(
                // UnitKerja
                "$this->UnitKerjaTable.id as id",
                "$this->UnitKerjaTable.id as user.id",
                "$this->UnitKerjaTable.name as user.name",
                "$this->UnitKerjaTable.parent_id as user.parent_id",

                "$this->UnitKerjaTable.updated_at as user.updated_at",
                "$this->UnitKerjaTable.created_at as user.created_at",
                "$this->UnitKerjaTable.deleted_at as user.deleted_at"
           );

           if (!isset($request->ArrQuery->without_with)) {
               $UnitKerja->with('parent')
               ->with('parents');
           }

           $Browse = $this->Browse($request, $UnitKerja, function ($data) use($request) {
               $data = $this->Manipulate($data);
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                   return $data->map(function($UnitKerja) {
                       return [ 'value' => $UnitKerja->id, 'label' => $UnitKerja->name.'('.$UnitKerja->pejabat.'/'.$UnitKerja->nip.')' ];
                   });
               } else if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select2')) {
                   return $data->map(function($UnitKerja) {
                       return [ 'value' => $UnitKerja->id, 'label' => $UnitKerja->name.'('.$UnitKerja->pejabat.'/'.$UnitKerja->nip.')' ];
                   });
               } else {
                   $data = $this->GetUnitKerjaDetails($data);
               }
               return $data;
           });

            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'selection')) {
                $data_selection = [];

                $UnitKerjaMe = UnitKerja::where('id', $request->Me->account->unit_kerja_id)->first();
                $data_selection[] = $UnitKerjaMe->toArray();

                if(!empty($Browse['records']->parent->user->unit_kerja)) {
                    $data_selection = $this->getSelection($Browse['records']->parent->user->unit_kerja->toArray(), $data_selection);
                }else{
                    $data_selection = $this->getSelection($Browse['records']->user->unit_kerja->parents->toArray(), $data_selection);
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
                $this->Group($item, $key, 'user.', $item);
            }
            return $item;
        });
    }
}
