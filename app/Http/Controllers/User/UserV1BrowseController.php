<?php

namespace App\Http\Controllers\User;

use App\Models\User;

use App\Traits\Browse;
use App\Traits\User\UserCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class UserV1BrowseController extends Controller
{
    use Browse, UserCollection {
        UserCollection::__construct as private __UserCollectionConstruct;
    }

    protected $search = [
        'name',
        'username',
        'email'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__UserCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $User = User::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where("$this->UserTable.id", $request->user()->id);
                } else {
                    $query->where("$this->UserTable.id", $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->username)) {
                if ($request->ArrQuery->username === 'my') {
                    $query->where("$this->UserTable.player_username", $request->user()->username);
                } else {
                    $query->where("$this->UserTable.player_username", $request->ArrQuery->username);
                }
            }

            if (isset($request->ArrQuery->position_id)) {
                $query->where("$this->UserTable.position_id", $request->ArrQuery->position_id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->Where("$this->UserTable.id", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserTable.name", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserTable.nip", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserTable.email", 'like', '%'.$request->get('q').'%')
                    ->orWhere("$this->UserTable.username", 'like', '%'.$request->get('q').'%')
                    ;
                });
            }
            if (isset($request->ArrQuery->status)) {
                $query->where("$this->UserTable.status", $request->ArrQuery->status);
            }

            if (isset($request->ArrQuery->user_ids)) {
                $query->whereIn("$this->UserTable.id", $request->ArrQuery->user_ids);
            }

            //mail_destination
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'send_mail')) {
                $query->whereNotIn("$this->UserTable.id", [Auth::user()->id]);
            }

            if (isset($request->ArrQuery->nip)) {
                $query->where("$this->UserTable.nip", $request->ArrQuery->nip);
            }

            if (isset($request->ArrQuery->position_ids)) {
                $query->whereIn("$this->UserTable.position_id", $request->ArrQuery->position_ids);
            }

            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               $query->where(function ($query) use($search) {
                    foreach ($this->search as $key => $value) {
                        if($value == 'name') $query->orWhere($this->UserTable.".".$value, 'like', $search);
                        else $query->orWhere($value, 'like', $search);

                    }
               });
            }
       })

       ->select(
            "$this->UserTable.id as user.id",
            "$this->UserTable.name as user.name",
            "$this->UserTable.nip as user.nip",
            "$this->UserTable.email as user.email",
            "$this->UserTable.hp as user.hp",
            "$this->UserTable.golongan_id as golongan_id",
            "$this->UserTable.jabatan_id as jabatan_id",
            "$this->UserTable.jabatan_fungsional_id as jabatan_fungsional_id",
            "$this->UserTable.unit_kerja_id as unit_kerja_id",
            "$this->UserTable.created_at as user.join_date"
       )
       ->with('detail_unit_kerja')
       ->with('detail_jabatan_fungsional')
       ->with('detail_jabatan')
       ->with('detail_golongan')       
       ;


        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
                if ($request->get('sort') == 'id') $User->orderBy("$this->UserTable.id", $request->get('sort_type'));
                else if ($request->get('sort') == 'name') $User->orderBy("$this->UserTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'nip') $User->orderBy("$this->UserTable.username", $request->get('sort_type'));
                else if($request->get('sort') == 'jabatan') $User->orderBy("$this->PositionTable.name", $request->get('sort_type'));
                else if($request->get('sort') == 'terbuat_pada') $User->orderBy("$this->UserTable.created_at", $request->get('sort_type'));
            }
        } else {
            $User->orderBy("$this->UserTable.created_at", 'desc');
        }

        // echo $User->toSql();
        // die();

       $Browse = $this->Browse($request, $User, function ($data) use($request) {
           $data = $this->Manipulate($data);
           if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
               return $data->map(function($User) {
                   return [ 'value' => $User->id, 'label' => $User->name ];
               });
           } else {
               $data = $this->GetUserDetails($data);
           }
           return $data;
       });
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
