<?php

namespace App\Http\Controllers\Complaint;

use App\Models\Complaint;

use App\Traits\Browse;
use App\Traits\Complaint\ComplaintCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class ComplaintBrowseController extends Controller
{
    use Browse, ComplaintCollection {
        ComplaintCollection::__construct as private __ComplaintCollectionConstruct;
    }

    protected $search = [
        'title'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__ComplaintCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $Complaint = Complaint::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->ComplaintTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->ComplaintTable.title", 'like', '%'.$request->get('title').'%');
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
            // Complaint
            "$this->ComplaintTable.id as complaint.id",
            "$this->ComplaintTable.from_user_id as complaint.from_user_id",
            "$this->ComplaintTable.from_unit_kerja_id as complaint.from_unit_kerja_id",
            "$this->ComplaintTable.title as complaint.title",
            "$this->ComplaintTable.description as complaint.description",
            "$this->ComplaintTable.urgency_type as complaint.urgency_type",
            "$this->ComplaintTable.status as complaint.status",
            "$this->ComplaintTable.process_at as complaint.process_at",
            "$this->ComplaintTable.finish_at as complaint.finish_at",
            "$this->ComplaintTable.created_at as complaint.created_at"
        )
        ->with('from_user')
        ->with('from_unit_kerja')
        ->with('foto_complaint')
        ->with('complaint_to')
        ;

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'title') $Complaint->orderBy("$this->ComplaintTable.title", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $Complaint->orderBy("$this->ComplaintTable.created_at", $request->get('sort_type'));
            } else {
              $Complaint->orderBy("$this->ComplaintTable.created_at", 'desc');
            }
        } else {
            $Complaint->orderBy("$this->ComplaintTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $Complaint, function ($data) use($request) {
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
                $this->Group($item, $key, 'complaint.', $item);
            }
            return $item;
        });
    }
}
