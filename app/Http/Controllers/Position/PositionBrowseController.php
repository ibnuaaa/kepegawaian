<?php

namespace App\Http\Controllers\Position;

use App\Models\Position;

use App\Traits\Browse;
use App\Traits\Position\PositionCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class PositionBrowseController extends Controller
{
    use Browse, PositionCollection {
        PositionCollection::__construct as private __PositionCollectionConstruct;
    }

    protected $search = [];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__PositionCollectionConstruct();
    }

    public function get(Request $request)
    {
        if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'tree') {
            $Browse = Position::tree();
        } else if (isset($request->ArrQuery->view) && $request->ArrQuery->view === 'child') {
            $Browse = Position::child($request->ArrQuery->position_id);
        } else  {

            $eselonBawahanAllData = [];
            $PositionEselon3 = Position::where('parent_id', !empty(Auth::user()->active_position_id) ? Auth::user()->active_position_id : '0')->get();

            foreach ($PositionEselon3 as $keyEselon3 => $valueEselon3) {
                $eselonBawahanAllData[] = $valueEselon3->id;
                $PositionEselon4 = Position::where('parent_id', $valueEselon3->id)->get();
                foreach ($PositionEselon4 as $keyEselon4 => $valueEselon4) {
                    $eselonBawahanAllData[] = $valueEselon4->id;
                    $staff = Position::where('parent_id', $valueEselon4->id)->get();
                    foreach ($staff as $keyStaff => $valueStaff) {
                        $eselonBawahanAllData[] = $valueStaff->id;
                    }
                }
            }

            $Now = Carbon::now();

            $PositionParent = [];
            if (isset($request->ArrQuery->criteria) && !empty($request->get('source_position_id')))
            {
                if($request->ArrQuery->criteria == 'nota_dinas')
                {
                    $PositionParent = Position::find($request->get('source_position_id'));
                }
            }

            $Position = Position::where(function ($query) use($request, $PositionParent, $eselonBawahanAllData) {
                if (isset($request->ArrQuery->id)) {
                    $query->where("$this->PositionTable.id", $request->ArrQuery->id);
                    $request->ArrQuery->set = 'first';
                }

                if (isset($request->ArrQuery->parent_id)) {
                    $query->where("$this->PositionTable.parent_id", $request->ArrQuery->parent_id);
                }

                if (isset($request->ArrQuery->id_not)) {
                    $query->where("$this->PositionTable.id",'!=', $request->ArrQuery->id_not);
                }

                if (isset($request->ArrQuery->like_name_front)) {
                    $query->where("$this->PositionTable.name", 'like', $request->ArrQuery->like_name_front.'%');
                }

                if (isset($request->ArrQuery->ses_id)) {
                    $query->where("$this->PositionTable.id", $request->ArrQuery->ses_id.'%');
                }

                if (!empty($request->get('q'))) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->PositionTable.name", 'like', '%'.$request->get('q').'%');
                        $query->orWhere("$this->UserTable.name", 'like', '%'.$request->get('q').'%');
                        $query->orWhere("$this->UserTable.username", 'like', '%'.$request->get('q').'%');
                    });
                }

                if (!empty($request->ArrQuery->search)) {
                    $query->where(function ($query) use($request) {
                        $query->where("$this->PositionTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                        $query->orWhere("$this->UserTable.name", 'like', '%'.$request->ArrQuery->search.'%');
                        $query->orWhere("$this->UserTable.username", 'like', '%'.$request->ArrQuery->search.'%');
                    });
                }

                if (isset($request->ArrQuery->status)) {
                    $query->where("$this->PositionTable.status", $request->ArrQuery->status);
                }

                if (isset($request->ArrQuery->parent_id_in)) {
                    $query->whereIn("$this->PositionTable.parent_id", $request->ArrQuery->parent_id_in);
                }

                if (isset($request->ArrQuery->all_bawahan) && $request->ArrQuery->all_bawahan == 'y') {
                    $query->whereIn("$this->PositionTable.id", $eselonBawahanAllData);
                }

                if (MyAccount()->position_id == '4' && MyAccount()->website_id) {
                    $query->whereIn("$this->PositionTable.id", [1]);
                }

                // if (isset($request->ArrQuery->criteria) && !empty($request->get('source_position_id')))
                // {
                //     if($request->ArrQuery->criteria == 'surat')
                //     {
                //         $query->where("$this->PositionTable.parent_id", $request->get('source_position_id'));
                //     }
                //     else if($request->ArrQuery->criteria == 'nota_dinas')
                //     {
                //         $query->where(function ($query) use($request, $PositionParent) {
                //             $query->where("$this->PositionTable.id", $PositionParent->parent_id);
                //             $query->orWhere("$this->PositionTable.parent_id", $PositionParent->parent_id);
                //         });
                //     }
                // }
           })
           ->select(
                // Position
                "$this->PositionTable.id as id",
                "$this->PositionTable.id as user.id",
                "$this->PositionTable.name as user.name",
                "$this->PositionTable.parent_id as user.parent_id",
                "$this->PositionTable.status as user.status",
                "$this->UserTable.name as user.pejabat",
                "$this->UserTable.username as user.nip",
                "$this->UserTable.id as user.user_id",

                "$this->PositionTable.updated_at as user.updated_at",
                "$this->PositionTable.created_at as user.created_at",
                "$this->PositionTable.deleted_at as user.deleted_at"
           )
           ->leftJoin($this->UserTable, "$this->UserTable.position_id", "$this->PositionTable.id");

           if (!isset($request->ArrQuery->without_with)) {
               $Position->with('parent')
               ->with('parents');
           }

           $Browse = $this->Browse($request, $Position, function ($data) use($request) {
               $data = $this->Manipulate($data);
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                   return $data->map(function($Position) {
                       return [ 'value' => $Position->id, 'label' => $Position->name.'('.$Position->pejabat.'/'.$Position->nip.')' ];
                   });
               } else if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select2')) {
                   return $data->map(function($Position) {
                       return [ 'value' => $Position->id, 'label' => $Position->name.'('.$Position->pejabat.'/'.$Position->nip.')' ];
                   });
               } else {
                   $data = $this->GetPositionDetails($data);
               }
               return $data;
           });

            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'selection')) {
                $data_selection = [];

                $PositionMe = Position::where('id', $request->Me->account->position_id)->first();
                $data_selection[] = $PositionMe->toArray();

                if(!empty($Browse['records']->parent->user->position)) {
                    $data_selection = $this->getSelection($Browse['records']->parent->user->position->toArray(), $data_selection);
                }else{
                    $data_selection = $this->getSelection($Browse['records']->user->position->parents->toArray(), $data_selection);
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
