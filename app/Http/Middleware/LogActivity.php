<?php

namespace App\Http\Middleware;

use App\Models\Log;

use Closure;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\BaseMiddleware;

use Illuminate\Support\Facades\Auth;

class LogActivity extends BaseMiddleware
{
    private function Initiate()
    {

    }

    private function Validation()
    {
        return true;
    }

    public function handle($request, Closure $next, $Activity = null)
    {


        $activity = explode('.', $Activity);

        $req = $request->input();

        $datas = [];
        foreach ($req as $key => $value) {
            if ($key != 'Me') $datas[$key] = $value;
        }

        $response = '';
        $access = $next($this->_Request);



        try {
            $response = $access->getContent();
        } catch (\Exception $e) {
        }



        $id = '';
        try {
            if(!empty($response)) {
                if (!empty($response))
                $response_data = json_decode($response);
                if(!empty($response_data->data->id)) {
                  $id = $response_data->data->id;
                }
            }
        } catch (\Exception $e) {
        }

        $request_uri = '';

        if (!empty($_SERVER['REQUEST_URI'])) {
            $request_uri =  $_SERVER['REQUEST_URI'];
        }

        $Log = new Log();
        if (!empty(Auth::user()['id'])) $Log->user_id = Auth::user()['id'];
        $Log->modul = $activity[0];
        $Log->activity = $activity[1];
        $Log->ip_client = $request->ip();
        $Log->browser = !empty($request->header('User-Agent')) ? $request->header('User-Agent') : '';
        $Log->data = json_encode($datas);
        if ($activity[1] == 'View') {
          $Log->data = '';
        }
        $Log->uri = $request_uri;
        $Log->method = $_SERVER['REQUEST_METHOD'];
        $Log->primary_id = $id;

        if ($Log->modul == 'Storage' && $Log->activity=='Fetch') {

        } else {
          if ($activity[1] == 'View') {
            $Log->response = '';
          } else {
            $Log->response = $response;
          }
        }
        $Log->save();



        $this->Initiate();
        if ($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $access;
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
