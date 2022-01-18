<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Position;
use App\Models\UserCoupon;

use App\Traits\Browse;
use App\Traits\Artillery;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Support\Response\Json;
use Illuminate\Support\Facades\Hash;
use App\Support\Generate\Hash as KeyGenerator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserCoupon\UserCouponBrowseController;

use App\Traits\User\UserCollection;

class UserController extends Controller
{
    use Artillery;
    use Browse, UserCollection {
        UserCollection::__construct as private __UserCollectionConstruct;
    }

    protected $search = [
        'id',
        'username',
        'email',
        'updated_at',
        'created_at'
    ];
    public function get(Request $request)
    {
        $User = User::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                if ($request->ArrQuery->id === 'my') {
                    $query->where('id', $request->user()->id);
                } else {
                    $query->where('id', $request->ArrQuery->id);
                }
            }
            if (isset($request->ArrQuery->username)) {
                if ($request->ArrQuery->username === 'my') {
                    $query->where('username', $request->user()->username);
                } else {
                    $query->where('username', $request->ArrQuery->username);
                }
            }
            if (isset($request->ArrQuery->search)) {
               $search = '%' . $request->ArrQuery->search . '%';
               if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                  $query->where('username', 'like', $search);
                  $query->orWhere('email', 'like', $search);
               } else {
                   $query->where(function ($query) use($search) {
                       foreach ($this->search as $key => $value) {
                           $query->orWhere($value, 'like', $search);
                       }
                   });
               }
           }
        });
        $Browse = $this->Browse($request, $User, function ($data) use($request) {
            if (isset($request->ArrQuery->for) && ($request->ArrQuery->for === 'select')) {
                return $data->map(function($User) {
                    return [ 'value' => $User->id, 'label' => $User->name ];
                });
            } else {
                $data->map(function($User) {
                    if (isset($User->point->balance)) {
                        $User->point->balance = (double)$User->point->balance;
                    }
                    return $User;
                });
            }
            return $data;
        });
        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Insert(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->password = Hash::make($Model->User->password);
        $Model->User->save();

        Json::set('data', $this->SyncData($request, $Model->User->id));
        return response()->json(Json::get(), 201);
    }


    public function Update(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->save();

        Json::set('data', $this->SyncData($request, $Model->User->id));
        return response()->json(Json::get(), 202);
    }


    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->delete();
        return response()->json(Json::get(), 202);
    }

    public function ChangePassword(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->password = app('hash')->make($request->input('new_password'));
        $Model->User->save();

        Json::set('data', $this->SyncData($request, $Model->User->id));
        return response()->json(Json::get(), 202);
    }

    public function ChangeStatus(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->User->save();

        Json::set('data', $this->SyncData($request, $Model->User->id));
        return response()->json(Json::get(), 202);
    }

    public function ResetPassword(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        $data['new_pass'] = $Model->User->password;

        $Model->User->password = Hash::make($Model->User->password);
        $Model->User->save();

        Json::set('data', $data);
        return response()->json(Json::get(), 202);
    }

    public function DeveloperToken(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        Json::set('data', [
            'token_type' => 'Bearer',
            'access_token' => $Model->User->createToken('ServiceAccessToken', ['blast'])->accessToken
        ]);
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
