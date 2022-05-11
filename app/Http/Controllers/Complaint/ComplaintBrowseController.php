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


            if (isset($request->ArrQuery->for)) {

                if ($request->ArrQuery->for == 'inbox') {
                  $query->where("$this->ComplaintTable.status", 2);
                  $query->where("b.destination_unit_kerja_id", MyAccount()->unit_kerja_id);
                }

                if ($request->ArrQuery->for == 'drafts') {
                  $query->where("$this->ComplaintTable.status", 1);
                  $query->where("$this->ComplaintTable.from_user_id", MyAccount()->id);
                }

                if ($request->ArrQuery->for == 'starred') {
                  $query->where("$this->ComplaintTable.status", 88);
                }

                if ($request->ArrQuery->for == 'sent') {
                  $query->where("$this->ComplaintTable.status", 2);
                  $query->where("$this->ComplaintTable.from_user_id", MyAccount()->id);
                }

                if ($request->ArrQuery->for == 'trash') {
                  $query->where("$this->ComplaintTable.status", 99);
                  $query->where("$this->ComplaintTable.from_user_id", MyAccount()->id);
                }

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

        if ($request->ArrQuery->for == 'inbox') {
            $Complaint->leftJoin('complaint_to as b', "b.complaint_id", "$this->ComplaintTable.id");
        }

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
