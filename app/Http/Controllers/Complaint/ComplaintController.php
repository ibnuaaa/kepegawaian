<?php

namespace App\Http\Controllers\Complaint;

use App\Models\Complaint;
use App\Models\ComplaintUserResolve;
use App\Models\ComplaintTo;
use App\Models\ComplaintReply;


use App\Traits\Browse;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ComplaintController extends Controller
{
    use Browse;

    protected $search = [
        'id',
        'code',
        'name'
    ];
    public function get(Request $request)
    {
        $Complaint = Complaint::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->information()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                  $query->where('code', 'like', $search);
                  $query->orWhere('name', 'like', $search);
               } else {
                   $query->where(function ($query) use($search) {
                       foreach ($this->search as $key => $value) {
                           $query->orWhere($value, 'like', $search);
                       }
                   });
               }
           }
        });
        $Browse = $this->Browse($request, $Complaint, function ($data) use($request) {
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Complaint->save();

        $ComplaintTo = new ComplaintTo();
        $ComplaintTo->complaint_id = $Model->Complaint->id;
        $ComplaintTo->save();

        Json::set('data', $this->SyncData($request, $Model->Complaint->id));
        return response()->json(Json::get(), 201);
    }

    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];


        if ($request->input('status')) {

            $ComplaintReply = new ComplaintReply();


            if ($Model->Complaint->status && $Model->Complaint->status == 2) {

              $Model->Complaint->sent_at = date('Y-m-d H:i:s');
              $Model->Complaint->sent_user_id = MyAccount()->id;

              $ComplaintReply->message = MyAccount()->name . ' telah mengirim komplain';

            }

            if ($Model->Complaint->status && $Model->Complaint->status == 3) {

              // check

              $Model->Complaint->process_at = date('Y-m-d H:i:s');

              $ComplaintUserResolve = ComplaintUserResolve::where('complaint_id', $Model->Complaint->id)
                ->where('user_id', MyAccount()->id)->first();

              if (!$ComplaintUserResolve) {
                  $ComplaintUserResolve = new ComplaintUserResolve();
                  $ComplaintUserResolve->complaint_id = $Model->Complaint->id;
                  $ComplaintUserResolve->user_id = MyAccount()->id;
                  $ComplaintUserResolve->save();
              }


              $ComplaintReply->message = MyAccount()->name . ' sedang memproses komplain';

            }


            if ($Model->Complaint->status && $Model->Complaint->status == 4) {

              $Model->Complaint->finish_at = date('Y-m-d H:i:s');
              $Model->Complaint->finish_user_id = MyAccount()->id;

              $ComplaintReply->message = MyAccount()->name . ' menyatakan selesai / finish pada komplain ini';

            }

            if ($Model->Complaint->status && $Model->Complaint->status == 5) {



              $ComplaintReply->message = MyAccount()->name . ' menyatakan revisi pada komplain ini';
            }

            if ($Model->Complaint->status && $Model->Complaint->status == 7) {

              $Model->Complaint->solved_at = date('Y-m-d H:i:s');
              $Model->Complaint->solved_user_id = MyAccount()->id;

              $ComplaintReply->message = MyAccount()->name . ' menyatakan solved pada komplain ini';
            }

            $ComplaintReply->flag = 1;


            $ComplaintReply->complaint_id = $Model->Complaint->id;
            $ComplaintReply->user_id = MyAccount()->id;
            $ComplaintReply->save();

        }


        $Model->Complaint->save();

        Json::set('data', $this->SyncData($request, $Model->Complaint->id));
        return response()->json(Json::get(), 202);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Complaint->delete();
        return response()->json(Json::get(), 202);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $data = $this->get($QueryRoute);
        return $data->original['data']['records'];
    }
}
