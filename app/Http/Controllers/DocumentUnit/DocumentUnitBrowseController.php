<?php

namespace App\Http\Controllers\DocumentUnit;

use App\Models\DocumentUnit;

use App\Traits\Browse;
use App\Traits\DocumentUnit\DocumentUnitCollection;

use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DB;

class DocumentUnitBrowseController extends Controller
{
    use Browse, DocumentUnitCollection {
        DocumentUnitCollection::__construct as private __DocumentUnitCollectionConstruct;
    }

    protected $search = [
        'name'
    ];

    public function __construct(Request $request)
    {
        if ($request) {
            $this->_Request = $request;
        }
        $this->__DocumentUnitCollectionConstruct();
    }

    public function get(Request $request)
    {
        $Now = Carbon::now();
        if (!isset($request->OriginalArrQuery->take)) {
            $request->ArrQuery->take = 5000;
        }

        $DocumentUnit = DocumentUnit::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where("$this->DocumentUnitTable.id", $request->ArrQuery->id);
            }

            if (!empty($request->get('q'))) {
                $query->where(function ($query) use($request) {
                    $query->where("$this->DocumentUnitTable.name", 'like', '%'.$request->get('name').'%');
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
            // DocumentUnit
            "$this->DocumentUnitTable.id as document_unit.id",
            "$this->DocumentUnitTable.name as document_unit.name",
            "$this->DocumentUnitTable.description as document_unit.description",
            "$this->DocumentUnitTable.unit_kerja_id as document_unit.unit_kerja_id",
            "$this->DocumentUnitTable.tanggal_terbit_dokumen as document_unit.tanggal_terbit_dokumen",
            "$this->DocumentUnitTable.no_dokumen as document_unit.no_dokumen",
            "$this->DocumentUnitTable.jenis_dokumen_id as document_unit.jenis_dokumen_id",
            "$this->DocumentUnitTable.perspektif_id as document_unit.perspektif_id",
            "$this->DocumentUnitTable.created_at as document_unit.created_at"
        )->with('document_unit');

        if(!empty($request->get('sort'))) {
            if(!empty($request->get('sort_type'))) {
              if ($request->get('sort') == 'name') $DocumentUnit->orderBy("$this->DocumentUnitTable.name", $request->get('sort_type'));
              if ($request->get('sort') == 'created_at') $DocumentUnit->orderBy("$this->DocumentUnitTable.created_at", $request->get('sort_type'));
            } else {
              $DocumentUnit->orderBy("$this->DocumentUnitTable.created_at", 'desc');
            }
        } else {
            $DocumentUnit->orderBy("$this->DocumentUnitTable.created_at", 'desc');
        }


       $Browse = $this->Browse($request, $DocumentUnit, function ($data) use($request) {
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
                $this->Group($item, $key, 'document_unit.', $item);
            }
            return $item;
        });
    }
}
