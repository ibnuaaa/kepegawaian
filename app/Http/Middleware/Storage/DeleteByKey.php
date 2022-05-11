<?php

namespace App\Http\Middleware\Storage;

use DB;
use Closure;
use Validator;
use App\Http\Middleware\BaseMiddleware;

use App\Models\Storage;
use App\Models\Document;

class DeleteByKey extends BaseMiddleware
{
    protected $file = null;

    private function Initiate()
    {
        $Storage = Storage::where('key', $this->Uuid)->get();

        if ($Storage) {
          foreach ($Storage as $key => $value) {
            $this->Model->Document = Document::where('storage_id',$value->id)->first();
            if($this->Model->Document) $this->Model->Document->delete();
          }
        }

    }

    private function Validation()
    {
        return true;
    }

    public function handle($request, Closure $next)
    {
        $this->Initiate();
        if($this->Validation()) {
            $this->Payload->put('Model', $this->Model);
            $this->_Request->merge(['Payload' => $this->Payload]);
            return $next($this->_Request);
        } else {
            return response()->json($this->Json::get(), $this->HttpCode);
        }
    }
}
