<?php

namespace App\Http\Controllers\ComplaintReply;

use App\Models\ComplaintReply;

use App\Traits\Browse;
use App\Traits\ComplaintReply\ComplaintReplyCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class ComplaintReplyBrowseController extends Controller
{
    use Browse, ComplaintReplyCollection {
        ComplaintReplyCollection::__construct as private __ComplaintReplyCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__ComplaintReplyCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $ComplaintReply = ComplaintReply::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->ComplaintReplyTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->ComplaintReplyTable.name", 'like', '%'.$request->get('name').'%');
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
            // ComplaintReply
            "$this->ComplaintReplyTable.id as complaint_reply.id",
            "$this->ComplaintReplyTable.complaint_id as complaint_reply.complaint_id",
            "$this->ComplaintReplyTable.delegate_by_user_id as complaint_reply.delegate_by_user_id",
            "$this->ComplaintReplyTable.destination_unit_kerja_id as complaint_reply.destination_unit_kerja_id",
            "$this->ComplaintReplyTable.delegate_notes as complaint_reply.delegate_notes",
            "$this->ComplaintReplyTable.delegate_unit_kerja_id as complaint_reply.delegate_unit_kerja_id",
            "$this->ComplaintReplyTable.delegate_at as complaint_reply.delegate_at",
            "$this->ComplaintReplyTable.created_at as complaint_reply.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $ComplaintReply->orderBy("$this->ComplaintReplyTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $ComplaintReply->orderBy("$this->ComplaintReplyTable.created_at", $request->get('sort_type'));
            } else {
              $ComplaintReply->orderBy("$this->ComplaintReplyTable.created_at", 'desc');
            }
        } else {
            $ComplaintReply->orderBy("$this->ComplaintReplyTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $ComplaintReply, function ($data) use($request) {
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
                $this->Group($item, $key, 'complaint_reply.', $item);
            }
            return $item;
        });
    }
}
