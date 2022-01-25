<?php

namespace App\Http\Controllers\Jabatan;

use App\Models\Jabatan;

use App\Traits\Browse;
use App\Traits\Jabatan\JabatanCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class JabatanBrowseController extends Controller
{
    use Browse, JabatanCollection {
        JabatanCollection::__construct as private __JabatanCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__JabatanCollectionConstruct();
    }

    public function get(Request $request)
    {
        if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'tree') {
            $Browse = Jabatan::tree();
        } else if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'child') {
            $Browse = Jabatan::child($request->ArrQuery->jabatan_id);
        } else  {

            $eselonBawahanAllData = [];
            $JabatanEselon3 = Jabatan::where('parent_id', !empty(Auth::user()->active_jabatan_id) ? Auth::user()->active_jabatan_id : '0')->get();

            foreach ($JabatanEselon3 as $keyEselon3 => $valueEselon3) {
                $eselonBawahanAllData[] = $valueEselon3->id;
                $JabatanEselon4 = Jabatan::where('parent_id', $valueEselon3->id)->get();
                foreach ($JabatanEselon4 as $keyEselon4 => $valueEselon4) {
                    $eselonBawahanAllData[] = $valueEselon4->id;
                    $staff = Jabatan::where('parent_id', $valueEselon4->id)->get();
                    foreach ($staff as $keyStaff => $valueStaff) {
                        $eselonBawahanAllData[] = $valueStaff->id;
                    }
                }
            }

            $Now = Carbon::now();

            $JabatanParent = [];
            if (isset($request->ArrQuery->criteria) && !empty($request->get('source_jabatan_id')))
            {
                if($request->ArrQuery->criteria == 'nota_dinas')
                {
                    $JabatanParent = Jabatan::find($request->get('source_jabatan_id'));
                }
            }

            $Jabatan = Jabatan::where(function ($query) use($request, $JabatanParent, $eselonBawahanAllData) {
                if (isset($request->ArrQuery->id)) {
                    $query->where("$this->JabatanTable.id", $request->ArrQuery->id);
                    $request->ArrQuery->set = 'first';
                }

                if (isset($request->ArrQuery->parent_id)) {
                    $query->where("$this->JabatanTable.parent_id", $request->ArrQuery->parent_id);
                }

                if (isset($request->ArrQuery->id_not)) {
                    $query->where("$this->JabatanTable.id",'!=', $request->ArrQuery->id_not);
                }

                if (isset($request->ArrQuery->like_name_front)) {
                    $query->where("$this->JabatanTable.name", 'like', $request->ArrQuery->like_name_front.'%');
                }

                if (isset($request->ArrQuery->ses_id)) {
                    $query->where("$this->JabatanTable.id", $request->ArrQuery->ses_id.'%');
                }

                if (!empty($request->get('q'))) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->JabatanTable.name", 'like', '%'.$request->get('q').'%');
                        $query->orWhere("$this->UserTable.name", 'like', '%'.$request->get('q').'%');
                        $query->orWhere("$this->UserTable.username", 'like', '%'.$request->get('q').'%');
                    });
                }

                if (!empty($request->ArrQuery->search)) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->JabatanTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                        $query->orWhere("$this->UserTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                        $query->orWhere("$this->UserTable.username", 'like', '%'.$request->ArrQuery->search.'%');
                    });
                }

                if (isset($request->ArrQuery->status)) {
                    $query->where("$this->JabatanTable.status", $request->ArrQuery->status);
                }

                if (isset($request->ArrQuery->parent_id_in)) {
                    $query->whereIn("$this->JabatanTable.parent_id", $request->ArrQuery->parent_id_in);
                }

                if (isset($request->ArrQuery->all_bawahan) && $request->ArrQuery->all_bawahan == 'y') {
                    $query->whereIn("$this->JabatanTable.id", $eselonBawahanAllData);
                }

                if (MyAccount()->jabatan_id == '4' && MyAccount()->website_id) {
                    $query->whereIn("$this->JabatanTable.id", [1]);
                }

                // if (isset($request->ArrQuery->criteria) && !empty($request->get('source_jabatan_id')))
                // {
                //     if($request->ArrQuery->criteria == 'surat')
                //     {
                //         $query->where("$this->JabatanTable.parent_id", $request->get('source_jabatan_id'));
                //     }
                //     else if($request->ArrQuery->criteria == 'nota_dinas')
                //     {
                //         $query->where(function ($query) use($request, $JabatanParent) {
                //             $query->where("$this->JabatanTable.id", $JabatanParent->parent_id);
                //             $query->orWhere("$this->JabatanTable.parent_id", $JabatanParent->parent_id);
                //         });
                //     }
                // }
           })
           ->select(
                // Jabatan
                "$this->JabatanTable.id as id",
                "$this->JabatanTable.id as user.id",
                "$this->JabatanTable.name as user.name",
                "$this->JabatanTable.parent_id as user.parent_id",
                "$this->JabatanTable.is_staff as user.is_staff",
                "$this->UserTable.name as user.pejabat",
                "$this->UserTable.username as user.nip",
                "$this->UserTable.id as user.user_id",

                "$this->JabatanTable.updated_at as user.updated_at",
                "$this->JabatanTable.created_at as user.created_at",
                "$this->JabatanTable.deleted_at as user.deleted_at"
           )
           ->leftJoin($this->UserTable, "$this->UserTable.jabatan_id", "$this->JabatanTable.id");

           if (!isset($request->ArrQuery->without_with)) {
               $Jabatan->with('parent')
               ->with('parents');

               if (isset($request->ArrQuery->for) && $request->ArrQuery->for == 'staff') {
                   $Jabatan->groupBy("$this->UserTable.id");
               }else{
                   $Jabatan->with('user')->groupBy("$this->JabatanTable.id");
               }
           }

           $Browse = $this->Browse($request, $Jabatan, function ($data) use($request) {
               $data = $this->Manipulate($data);
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                   return $data->map(function($Jabatan) {
                       return [ 'value' => $Jabatan->id, 'label' => $Jabatan->name.'('.$Jabatan->pejabat.'/'.$Jabatan->nip.')' ];
                   });
               } else if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select2')) {
                   return $data->map(function($Jabatan) {
                       return [ 'value' => $Jabatan->id, 'label' => $Jabatan->name.'('.$Jabatan->pejabat.'/'.$Jabatan->nip.')' ];
                   });
               } else {
                   $data = $this->GetJabatanDetails($data);
               }
               return $data;
           });

            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'selection')) {
                $data_selection = [];

                $JabatanMe = Jabatan::where('id', $request->Me->account->jabatan_id)->first();
                $data_selection[] = $JabatanMe->toArray();

                if(!empty($Browse['records']->parent->user->jabatan)) {
                    $data_selection = $this->getSelection($Browse['records']->parent->user->jabatan->toArray(), $data_selection);
                }else{
                    $data_selection = $this->getSelection($Browse['records']->user->jabatan->parents->toArray(), $data_selection);
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
