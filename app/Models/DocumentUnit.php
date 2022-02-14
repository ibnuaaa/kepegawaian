<?php

namespace App\Models;

use Webpatser\Uuid\Uuid;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentUnit extends Model
{
    use SoftDeletes;
    protected $table = 'document_unit';

    public function document_unit()
    {
        return $this->hasMany(Document::class, 'object_id', 'document_unit.id')
                    ->where('object', 'document_unit')
                    ->with('storage');
    }
}
