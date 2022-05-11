<?php

namespace App\Http\Controllers\ComplaintTo;

use App\Models\ComplaintTo;

use App\Traits\Browse;
use App\Traits\ComplaintTo\ComplaintToCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class ComplaintToBrowseController extends Controller
{
    use Browse, ComplaintToCollection {
        ComplaintToCollection::__construct as private __ComplaintToCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__ComplaintToCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $ComplaintTo = ComplaintTo::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->ComplaintToTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->ComplaintToTable.name", 'like', '%'.$request->get('name').'%');
                });
            }

            if (!empty($request->ArrQuery->search)) {
                $searched = explode(' ',$request->ArrQuery->search);
                foreach ($searched as $key => $value) {
                    $query->where(function ($query) use($request, $value) {
                        $search = '%' . $value . '%';
                        foreach ($this->search as $keySearch => $valueSearch) {
                            $query->orWhere($valueSearch, 'like', $search);
                        }
                    });
                }
            }
        })
        ->select(
            // ComplaintTo
            "$this->ComplaintToTable.id as complaint_to.id",
            "$this->ComplaintToTable.complaint_id as complaint_to.complaint_id",
            "$this->ComplaintToTable.delegate_by_user_id as complaint_to.delegate_by_user_id",
            "$this->ComplaintToTable.destination_unit_kerja_id as complaint_to.destination_unit_kerja_id",
            "$this->ComplaintToTable.delegate_notes as complaint_to.delegate_notes",
            "$this->ComplaintToTable.delegate_unit_kerja_id as complaint_to.delegate_unit_kerja_id",
            "$this->ComplaintToTable.delegate_at as complaint_to.delegate_at",
            "$this->ComplaintToTable.created_at as complaint_to.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $ComplaintTo->orderBy("$this->ComplaintToTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $ComplaintTo->orderBy("$this->ComplaintToTable.created_at", $request->get('sort_type'));
            } else {
              $ComplaintTo->orderBy("$this->ComplaintToTable.created_at", 'desc');
            }
        } else {
            $ComplaintTo->orderBy("$this->ComplaintToTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $ComplaintTo, function ($data) use($request) {
            $data = $this->Manipulate($data);
            return $data;
       });
       Json::set('data', $Browse);
       return response()->json(Json::get(), 200);
    }

    private function Manipulate($records)
    {
        return $records->map(function ($item) {
            foreach ($item->getAttributes() as $key => $value) {
                $this->Group($item, $key, 'complaint_to.', $item);
            }
            return $item;
        });
    }
}
