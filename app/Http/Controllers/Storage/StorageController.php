<?php

namespace App\Http\Controllers\Storage;

use App\Models\Storage as StorageDB;
use App\Models\User;
use App\Models\EKinerjaIkiDetail;
use App\Models\EKinerjaIki;
use App\Models\EKinerjaIktDetail;
use App\Models\EKinerjaIkt;


use App\Traits\Browse;

use Cache;
use Closure;
use DateTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Support\Response\Json;
use App\Support\Generate\Hash as GenerateKey;
use Illuminate\Support\Facades\Input;
use App\Models\Images;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;




class StorageController extends Controller
{
    use Browse;
    protected $search = [
        'name'
    ];

    public function Get(Request $request)
    {

        $StorageDB = StorageDB::where(function ($query) use($request) {
            if (isset($request->ArrQuery->id)) {
                $query->where('id', $request->ArrQuery->id);
                $request->ArrQuery->set = 'first';
            }
            if (isset($request->ArrQuery->object)) {
                $query->where('object', $request->ArrQuery->object);
            }
            if (isset($request->ArrQuery->object_id)) {
                $query->where('object_id', (int)$request->ArrQuery->object_id);
            }
            if (isset($request->ArrQuery->search)) {
                $search = '%' . $request->ArrQuery->search . '%';
                $query->where(function ($query) use($search) {
                    foreach ($this->search as $key => $value) {
                        $query->orWhere($value, 'like', $search);
                    }
                });
            }
            if (isset($request->ArrQuery->customer_name)) {
                $query->where('name', 'like', '%' . $request->ArrQuery->customer_name . '%');
            }

            $query->whereNull('deleted_at');
        });

        $Browse = $this->Browse($request, $StorageDB, function ($data) use($request) {
            $UserID = $data->pluck('user_id');
            $User = User::select('id', 'name')->whereIn('id', $UserID)->get()->keyBy('id');
            $data->map(function($item) use($User) {
                $item->owner = $User[$item->user_id];
                $item->download = url('/') . '/storage/' . $item->key;
                if ($item->thumbName) {
                    $item->thumbUrl = url('/') . '/storage/thumb/' . $item->thumbName;
                }
            });
            return $data;
        });

        Json::set('data', $Browse);
        return response()->json(Json::get(), 200);
    }

    public function Fetch(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Document = Document::where('storage_id', $Model->Storage->id)->first();

        // $Path = $Document->object . '_' . $Document->object_id . '/' . $Model->Storage->original_name;
        $Path = $Model->Storage->original_name;
        $File = Storage::disk('local')->get($Path);

        $attachment = "";

        if(!in_array($Model->Storage->extension, array('jpg','png','bmp')))
        {
            $attachment = "attachment;";
        }

        return response($File, 200)
            ->header('Content-Type', $Model->Storage->mimetype)
            ->header('Content-Disposition', $attachment.'filename=' . $Model->Storage->name);
    }

    public function Preview(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Document = Document::where('storage_id', $Model->Storage->id)->first();

        // $Path = $Document->object . '_' . $Document->object_id . '/' . $Model->Storage->original_name;
        $Path = $Model->Storage->original_name;
        $File = Storage::disk('local')->get($Path);

        $attachment = "";

        if(!in_array($Model->Storage->extension, array('jpg','png','bmp')))
        {
            $attachment = "attachment;";
        }

        return response($File, 200)
            ->header('Content-Type', $Model->Storage->mimetype)
            // ->header('Content-Disposition', $attachment.'filename=' . $Model->Storage->name)
            ;
    }

    public function FetchTmp(Request $request)
    {
        $Model = $request->Payload->all()['Model'];

        $File = Storage::disk('temporary')->get($Model->Key);

        $mimetype = Storage::disk('temporary')->mimeType($Model->Key);

        return response($File, 200)
            ->header('Content-Type', $mimetype)
            ->header('Content-Disposition', 'attachment;filename=' . $Model->Key);
    }

    public function Delete(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Model->Document->delete();

        Json::set('data', 'Success Delete');
        return response()->json(Json::get(), 202);
    }

    public function DeleteByKey(Request $request)
    {
        Json::set('data', 'Success Delete');
        return response()->json(Json::get(), 202);
    }

    public function FetchThumb(Request $request)
    {
        $Model = $request->Payload->all()['Model'];
        $Path = $Model->Storage->thumbName;
        $File = Storage::disk('local')->get($Path);
        return response($File, 200)
            ->header('Content-Type', $Model->Storage->metadata['mimetype'])
            ->header('Content-Disposition', 'attachment;filename=' . $Model->Storage->thumbName)
            ->header('Cache-Control', 'public, max-age=2628002');
    }

    public function Save(Request $request)
    {
        $File = $request->Payload->all()['File'];
        $Object = $request->Payload->all()['Object'];
        $ObjectId = $request->Payload->all()['ObjectId'];

        $FileName = $File->key . '.' . $File->extension;
        $SizeFile = Storage::disk('temporary')->size($FileName);
        $MimeType = Storage::disk('temporary')->mimeType($FileName);

        $Storage = new StorageDB();
        $Storage->type = 'file';
        $Storage->name = $File->name;
        $Storage->original_name = $FileName;
        $Storage->key = $File->key;
        $Storage->user_id = $request->user()->id;

        $Storage->extension = $File->extension;
        $Storage->size = $SizeFile;
        $Storage->mimetype = $MimeType;

        $Folder = $Object . '_' . $ObjectId;
        if ($ObjectId && $Object) {
            if (!Storage::disk('local')->has($Folder)) {
                // Storage::disk('local')->makeDirectory($Folder, $mode = 0777, true, true);
            }
        }
        Storage::disk('local')->put(
          // $Folder . '/' . $FileName,
            $FileName,
            Storage::disk('temporary')->get($FileName), 'public'
        );
        // if ($File->thumb) {
        //     Storage::disk('local')->put(
        //         $Folder . '/' . $File->thumb,
        //         Storage::disk('temporary')->get($File->thumb), 'public'
        //     );
        //     $Storage->thumbName = $File->thumb;
        // }
        $Storage->save();

        // INI BUAT FOTO YANG SINGLE, harus dimasukkan ke array di bawah ini
        if (in_array($Object, [
          'foto_profile', 'foto_ktp', 'foto_npwp', 'foto_ijazah', 'foto_sertifikat','foto_kk','foto_akta_nikah','foto_bpjs',
          'foto_profile_request', 'foto_ktp_request', 'foto_npwp_request', 'foto_ijazah_request', 'foto_sertifikat_request','foto_kk_request','foto_akta_nikah_request','foto_bpjs_request',
          'document_unit', 'foto_sip', 'foto_sip_request','foto_transkrip_nilai','foto_transkrip_nilai_request','foto_penilaian_prestasi_kerja', 'foto_perjanjian_kerja', 'foto_perjanjian_kerja_request'
          ])) {
            Document::where('object', $Object)->where('object_id', $ObjectId)->delete();
        }

        $Document = new Document();
        $Document->object_id = $ObjectId;
        $Document->object = $Object;
        $Document->storage_id = $Storage->id;
        $Document->save();

        Json::set('data', $this->SyncData($request, $Storage->id));
        return response()->json(Json::get(), 201);
    }

    public function SaveExcel(Request $request)
    {
        $File = $request->Payload->all()['File'];
        $Object = $request->Payload->all()['Object'];
        $ObjectId = $request->Payload->all()['ObjectId'];

        $FileName = $File->key . '.' . $File->extension;
        $SizeFile = Storage::disk('temporary')->size($FileName);
        $MimeType = Storage::disk('temporary')->mimeType($FileName);

        // $Storage = new StorageDB();
        // $Storage->type = 'file';
        // $Storage->name = $File->name;
        // $Storage->original_name = $FileName;
        // $Storage->key = $File->key;
        // $Storage->user_id = $request->user()->id;

        // $Storage->extension = $File->extension;
        // $Storage->size = $SizeFile;
        // $Storage->mimetype = $MimeType;

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $Folder = $Object . '_' . $ObjectId;
        if ($ObjectId && $Object) {
            if (!Storage::disk('local')->has($Folder)) {
                // Storage::disk('local')->makeDirectory($Folder, $mode = 0777, true, true);
            }
        }
        Storage::disk('local')->put(
            // $Folder . '/' . $FileName,
            $FileName,
            Storage::disk('temporary')->get($FileName), 'public'
        );

        $spreadsheet = $reader->load('../storage/app/' . $FileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $e_kinerja_iki_id = $ObjectId;

        $EKinerjaIkiDetail = EKinerjaIkiDetail::where('e_kinerja_iki_id',$e_kinerja_iki_id)->delete();

        $category = '';
        foreach ($sheetData as $key => $val) {
            if ($key > 0) {
                
                if (!empty($val[0])) $category = $val[0];

                $EKinerjaIkiDetail = new EKinerjaIkiDetail();    
                $EKinerjaIkiDetail->e_kinerja_iki_id = $e_kinerja_iki_id;
                $EKinerjaIkiDetail->category = $category;
                $EKinerjaIkiDetail->no = $val[1];
                $EKinerjaIkiDetail->judul_indikator = $val[2];
                $EKinerjaIkiDetail->bobot = $val[3];
                $EKinerjaIkiDetail->standart = $val[4];
                $EKinerjaIkiDetail->haper = $val[5];
                $EKinerjaIkiDetail->skor = $val[6];
                $EKinerjaIkiDetail->total = $val[7];
                $EKinerjaIkiDetail->save();
            }
        }
        
        
        Json::set('data', 'success');
        return response()->json(Json::get(), 201);
    }

    public function SaveExcelIkt(Request $request)
    {
        $File = $request->Payload->all()['File'];
        $Object = $request->Payload->all()['Object'];
        $ObjectId = $request->Payload->all()['ObjectId'];

        $FileName = $File->key . '.' . $File->extension;
        $SizeFile = Storage::disk('temporary')->size($FileName);
        $MimeType = Storage::disk('temporary')->mimeType($FileName);

        // $Storage = new StorageDB();
        // $Storage->type = 'file';
        // $Storage->name = $File->name;
        // $Storage->original_name = $FileName;
        // $Storage->key = $File->key;
        // $Storage->user_id = $request->user()->id;

        // $Storage->extension = $File->extension;
        // $Storage->size = $SizeFile;
        // $Storage->mimetype = $MimeType;

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

        $Folder = $Object . '_' . $ObjectId;
        if ($ObjectId && $Object) {
            if (!Storage::disk('local')->has($Folder)) {
                // Storage::disk('local')->makeDirectory($Folder, $mode = 0777, true, true);
            }
        }
        Storage::disk('local')->put(
            // $Folder . '/' . $FileName,
            $FileName,
            Storage::disk('temporary')->get($FileName), 'public'
        );

        $spreadsheet = $reader->load('../storage/app/' . $FileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        $e_kinerja_ikt_id = $ObjectId;
        
        $EKinerjaIktDetail = EKinerjaIktDetail::where('e_kinerja_ikt_id',$e_kinerja_ikt_id)->delete();

        $category = '';
        foreach ($sheetData as $key => $val) {
            if ($key > 0) {
                
                // if (!empty($val[0])) $category = $val[0];

                $EKinerjaIkiDetail = new EKinerjaIktDetail();    
                $EKinerjaIkiDetail->e_kinerja_ikt_id = $e_kinerja_ikt_id;
                $EKinerjaIkiDetail->no = $val[0];
                $EKinerjaIkiDetail->judul_indikator = $val[1];
                $EKinerjaIkiDetail->standart = $val[2];
                $EKinerjaIkiDetail->target = $val[3];
                $EKinerjaIkiDetail->realisasi = $val[4];
                $EKinerjaIkiDetail->save();
            }
        }
        
        
        Json::set('data', 'success');
        return response()->json(Json::get(), 201);
    }

    public function SyncData($request, $id)
    {
        $QueryRoute = QueryRoute($request);
        $QueryRoute->ArrQuery->set = 'first';
        $QueryRoute->ArrQuery->id = $id;
        $data = $this->Get($QueryRoute);
        return $data->original['data']['records'];
    }
}
