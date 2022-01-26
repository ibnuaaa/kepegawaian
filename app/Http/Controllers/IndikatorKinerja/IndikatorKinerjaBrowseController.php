<?php

namespace App\Http\Controllers\IndikatorKinerja;

use App\Models\IndikatorKinerja;

use App\Traits\Browse;
use App\Traits\IndikatorKinerja\IndikatorKinerjaCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class IndikatorKinerjaBrowseController extends Controller
{
    use Browse, IndikatorKinerjaCollection {
        IndikatorKinerjaCollection::__construct as private __IndikatorKinerjaCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__IndikatorKinerjaCollectionConstruct();
    }

    public function get(Request $request)
    {
        if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'tree') {
            $Browse = IndikatorKinerja::tree();
        } else if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'child') {
            $Browse = IndikatorKinerja::child($request->ArrQuery->indikator_kinerja_id);
        } else  {

            $eselonBawahanAllData = [];
            $IndikatorKinerjaEselon3 = IndikatorKinerja::where('parent_id', !empty(Auth::user()->active_indikator_kinerja_id) ? Auth::user()->active_indikator_kinerja_id : '0')->get();

            foreach ($IndikatorKinerjaEselon3 as $keyEselon3 => $valueEselon3) {
                $eselonBawahanAllData[] = $valueEselon3->id;
                $IndikatorKinerjaEselon4 = IndikatorKinerja::where('parent_id', $valueEselon3->id)->get();
                foreach ($IndikatorKinerjaEselon4 as $keyEselon4 => $valueEselon4) {
                    $eselonBawahanAllData[] = $valueEselon4->id;
                    $staff = IndikatorKinerja::where('parent_id', $valueEselon4->id)->get();
                    foreach ($staff as $keyStaff => $valueStaff) {
                        $eselonBawahanAllData[] = $valueStaff->id;
                    }
                }
            }

            $Now = Carbon::now();

            $IndikatorKinerjaParent = [];
            if (isset($request->ArrQuery->criteria) && !empty($request->get('source_indikator_kinerja_id')))
            {
                if($request->ArrQuery->criteria == 'nota_dinas')
                {
                    $IndikatorKinerjaParent = IndikatorKinerja::find($request->get('source_indikator_kinerja_id'));
                }
            }

            $IndikatorKinerja = IndikatorKinerja::where(function ($query) use($request, $IndikatorKinerjaParent, $eselonBawahanAllData) {
                if (isset($request->ArrQuery->id)) {
                    $query->where("$this->IndikatorKinerjaTable.id", $request->ArrQuery->id);
                    $request->ArrQuery->set = 'first';
                }

                if (isset($request->ArrQuery->parent_id)) {
                    $query->where("$this->IndikatorKinerjaTable.parent_id", $request->ArrQuery->parent_id);
                }

                if (isset($request->ArrQuery->unit_kerja_id)) {
                    $query->where("$this->IndikatorKinerjaTable.unit_kerja_id", $request->ArrQuery->unit_kerja_id);
                }

                if (isset($request->ArrQuery->tipe_indikator)) {
                    $query->where("$this->IndikatorKinerjaTable.tipe_indikator", $request->ArrQuery->tipe_indikator);
                }

                if (isset($request->ArrQuery->id_not)) {
                    $query->where("$this->IndikatorKinerjaTable.id",'!=', $request->ArrQuery->id_not);
                }

                if (isset($request->ArrQuery->like_name_front)) {
                    $query->where("$this->IndikatorKinerjaTable.name", 'like', $request->ArrQuery->like_name_front.'%');
                }

                if (isset($request->ArrQuery->ses_id)) {
                    $query->where("$this->IndikatorKinerjaTable.id", $request->ArrQuery->ses_id.'%');
                }

                if (!empty($request->get('q'))) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->IndikatorKinerjaTable.name", 'like', '%'.$request->get('q').'%');
                    });
                }

                if (!empty($request->ArrQuery->search)) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->IndikatorKinerjaTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                    });
                }

                if (isset($request->ArrQuery->status)) {
                    $query->where("$this->IndikatorKinerjaTable.status", $request->ArrQuery->status);
                }

                if (isset($request->ArrQuery->parent_id_in)) {
                    $query->whereIn("$this->IndikatorKinerjaTable.parent_id", $request->ArrQuery->parent_id_in);
                }

                if (isset($request->ArrQuery->all_bawahan) && $request->ArrQuery->all_bawahan == 'y') {
                    $query->whereIn("$this->IndikatorKinerjaTable.id", $eselonBawahanAllData);
                }

                if (MyAccount()->indikator_kinerja_id == '4' && MyAccount()->website_id) {
                    $query->whereIn("$this->IndikatorKinerjaTable.id", [1]);
                }

                // if (isset($request->ArrQuery->criteria) && !empty($request->get('source_indikator_kinerja_id')))
                // {
                //     if($request->ArrQuery->criteria == 'surat')
                //     {
                //         $query->where("$this->IndikatorKinerjaTable.parent_id", $request->get('source_indikator_kinerja_id'));
                //     }
                //     else if($request->ArrQuery->criteria == 'nota_dinas')
                //     {
                //         $query->where(function ($query) use($request, $IndikatorKinerjaParent) {
                //             $query->where("$this->IndikatorKinerjaTable.id", $IndikatorKinerjaParent->parent_id);
                //             $query->orWhere("$this->IndikatorKinerjaTable.parent_id", $IndikatorKinerjaParent->parent_id);
                //         });
                //     }
                // }
           })
           ->select(
                // IndikatorKinerja
                "$this->IndikatorKinerjaTable.id as id",
                "$this->IndikatorKinerjaTable.id as indikator_kinerja.id",
                "$this->IndikatorKinerjaTable.name as indikator_kinerja.name",
                "$this->IndikatorKinerjaTable.parent_id as indikator_kinerja.parent_id",
                "$this->IndikatorKinerjaTable.parent_id as parent_id",
                "$this->IndikatorKinerjaTable.unit_kerja_id as indikator_kinerja.unit_kerja_id",
                "$this->IndikatorKinerjaTable.perspektif_id as indikator_kinerja.perspektif_id",

                "$this->IndikatorKinerjaTable.updated_at as indikator_kinerja.updated_at",
                "$this->IndikatorKinerjaTable.created_at as indikator_kinerja.created_at",
                "$this->IndikatorKinerjaTable.deleted_at as indikator_kinerja.deleted_at"
           );

           if (!isset($request->ArrQuery->without_with)) {
               $IndikatorKinerja->with('parent')
               ->with('parents')
               ->with('unit_kerja_with_parents');
           }

           $Browse = $this->Browse($request, $IndikatorKinerja, function ($data) use($request) {
               $data = $this->Manipulate($data);
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                   return $data->map(function($IndikatorKinerja) {
                       return [ 'value' => $IndikatorKinerja->id, 'label' => $IndikatorKinerja->name.'('.$IndikatorKinerja->pejabat.'/'.$IndikatorKinerja->nip.')' ];
                   });
               } else if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select2')) {
                   return $data->map(function($IndikatorKinerja) {
                       return [ 'value' => $IndikatorKinerja->id, 'label' => $IndikatorKinerja->name.'('.$IndikatorKinerja->pejabat.'/'.$IndikatorKinerja->nip.')' ];
                   });
               } else {
                   $data = $this->GetIndikatorKinerjaDetails($data);
               }
               return $data;
           });

            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'selection')) {
                $data_selection = [];

                $IndikatorKinerjaMe = IndikatorKinerja::where('id', $request->Me->account->indikator_kinerja_id)->first();
                $data_selection[] = $IndikatorKinerjaMe->toArray();

                if(!empty($Browse['records']->parent->user->indikator_kinerja)) {
                    $data_selection = $this->getSelection($Browse['records']->parent->user->indikator_kinerja->toArray(), $data_selection);
                }else{
                    $data_selection = $this->getSelection($Browse['records']->user->indikator_kinerja->parents->toArray(), $data_selection);
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
                $this->Group($item, $key, 'indikator_kinerja.', $item);
            }
            return $item;
        });
    }
}
