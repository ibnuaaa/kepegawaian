<?php

namespace App\Http\Controllers\Golongan;

use App\Models\Golongan;

use App\Traits\Browse;
use App\Traits\Golongan\GolonganCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class GolonganBrowseController extends Controller
{
    use Browse, GolonganCollection {
        GolonganCollection::__construct as private __GolonganCollectionConstruct;
    }

    protected $search = [
      'name',
      'pangkat',
      'golongan'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__GolonganCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $Golongan = Golongan::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->GolonganTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->GolonganTable.name", 'like', '%'.$request->get('name').'%');
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
            // Golongan
            "$this->GolonganTable.id as golongan.id",
            "$this->GolonganTable.name as golongan.name",
            "$this->GolonganTable.pangkat as golongan.pangkat",
            "$this->GolonganTable.golongan as golongan.golongan",
            "$this->GolonganTable.created_at as golongan.created_at"
        );

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'pangkat') $Golongan->orderBy("$this->GolonganTable.pangkat", $request->get('sort_type'));
              if ($request->get('sort') == 'golongan') $Golongan->orderBy("$this->GolonganTable.golongan", $request->get('sort_type'));
              if ($request->get('sort') == 'name') $Golongan->orderBy("$this->GolonganTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $Golongan->orderBy("$this->GolonganTable.created_at", $request->get('sort_type'));
            } else {
              $Golongan->orderBy("$this->GolonganTable.created_at", 'desc');
            }
        } else {
            $Golongan->orderBy("$this->GolonganTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $Golongan, function ($data) use($request) {
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
                $this->Group($item, $key, 'golongan.', $item);
            }
            return $item;
        });
    }
}
