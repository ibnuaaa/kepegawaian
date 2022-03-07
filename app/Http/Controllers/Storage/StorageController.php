<?php

namespace App\Http\Controllers\Storage;

use App\Models\Storage as StorageDB;
use App\Models\User;
use App\Models\KontrakPayungItem;
use App\Models\Material;

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

use Ajaxray\PHPWatermark\Watermark;


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


        $this->PlaceWatermark($FileName, "PDF INI HANYA SAMPLE", 0, 0, 100,TRUE);




        // cetak('D:/Web/XAMPP73/htdocs/kepegawaian-rspon/storage/app/'.$FileName);
        // die();


        // $watermark = new Watermark('D:/Web/XAMPP73/htdocs/kepegawaian-rspon/storage/app/0O3Er7059t5M7tu4gqnBY4RtEcj1uFxXAixQW3pgCLD5fpaDhooFegdSomZaHgHo.pdf');

        // cetak($watermark);
        // die();

        // $watermark = $watermark->withText('ajaxray.com');

        // $watermark->write('D:/Web/XAMPP73/htdocs/kepegawaian-rspon/storage/app/bbb.pdf');

        // $watermark->withText('ajaxray.com')->setFontSize(48)->setRotate(30)
        //      ->setOpacity(.4)
        //      ->write('D:/Web/XAMPP73/htdocs/kepegawaian-rspon/storage/app/bbb.pdf');
        //
        //
        // cetak($watermark);
        // die();
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
          'foto_profile', 'foto_ktp', 'foto_npwp', 'foto_ijazah', 'foto_sertifikat','foto_kk','foto_bpjs',
          'foto_profile_request', 'foto_ktp_request', 'foto_npwp_request', 'foto_ijazah_request', 'foto_sertifikat_request','foto_kk_request','foto_bpjs_request',
          'document_unit'
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



    public function PlaceWatermark($file, $text, $xxx, $yyy, $op, $outdir) {
        // require_once('fpdf.php');
        // require_once('fpdi.php');
        $name = uniqid();
        $font_size = 25;
        $ts=explode("\n",$text);
        $width=0;
        foreach ($ts as $k=>$string) {
            $width=max($width,strlen($string));
        }
        $width  = imagefontwidth($font_size)*$width;
        $height = imagefontheight($font_size)*count($ts);
        $el=imagefontheight($font_size);
        $em=imagefontwidth($font_size);
        $img = imagecreatetruecolor($width,$height);
        // Background color
        $bg = imagecolorallocate($img, 255, 255, 255);
        imagefilledrectangle($img, 0, 0,$width ,$height , $bg);
        // Font color
        $color = imagecolorallocate($img, 0, 0, 0);
        foreach ($ts as $k=>$string) {
            $len = strlen($string);
            $ypos = 0;
            for($i=0;$i<$len;$i++){
                $xpos = $i * $em;
                $ypos = $k * $el;
                imagechar($img, $font_size, $xpos, $ypos, $string, $color);
                $string = substr($string, 1);
            }
        }

        // echo "aa";
        // die();

        imagecolortransparent($img, $bg);
        $blank = imagecreatetruecolor($width, $height);
        $tbg = imagecolorallocate($blank, 255, 255, 255);
        imagefilledrectangle($blank, 0, 0,$width ,$height , $tbg);
        imagecolortransparent($blank, $tbg);
        if ( ($op < 0) OR ($op >100) ){
            $op = 100;
        }
        imagecopymerge($blank, $img, 0, 0, 0, 0, $width, $height, $op);
        imagepng($blank,$name.".png");
        // Created Watermark Image
        $pdf = new \setasign\Fpdi\Fpdi();
        // if (file_exists("./".$file)){

            // cetak(file_exists($file));
            // die();

            $pagecount = $pdf->setSourceFile('D:/Web/XAMPP73/htdocs/kepegawaian-rspon/storage/app/'.$file);

            // cetak($pagecount);
            // die();

        // } else {
        //     return FALSE;
        // }
        for ($i=0; $i < $pagecount; $i++) {
            $tpl = $pdf->importPage($i+1);
            $size = $pdf->getTemplateSize($tpl);
            $pdf->addPage();
            $pdf->useTemplate($tpl, null, null, $size['width'], $size['height'], TRUE);
            $pdf->Image($name.'.png', $xxx, $yyy, 0, 0, 'png');
        }

        // //Put the watermark
        // die();


        // if ($outdir === TRUE){

            unlink("D:/Web/XAMPP73/htdocs/kepegawaian-rspon/storage/app/".$file);

            return $pdf->Output("D:/Web/XAMPP73/htdocs/kepegawaian-rspon/storage/app/".$file, "F");
        // } else {
            // return $pdf;
        // }
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

        $spreadsheet = $reader->load('../storage/app/' . $Folder . '/' . $FileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        KontrakPayungItem::where('kontrak_payung_id', $ObjectId)->delete();

        for($i = 1;$i < count($sheetData);$i++)
        {

            $Material = Material::where('code',$sheetData[$i][0])->first();
            if ($Material) $material_id = $Material->id;

            $KontrakPayungItem = new KontrakPayungItem();
            $KontrakPayungItem->kontrak_payung_id = $ObjectId;
            $KontrakPayungItem->material_id = $material_id;
            $KontrakPayungItem->obj_id = $sheetData[$i][0];
            $KontrakPayungItem->nama_obat = $sheetData[$i][1];
            $KontrakPayungItem->kuantitas = $sheetData[$i][2];
            $KontrakPayungItem->satuan = $sheetData[$i][3];
            $KontrakPayungItem->hna = $sheetData[$i][4];
            $KontrakPayungItem->diskon = $sheetData[$i][5];
            $KontrakPayungItem->hna_diskon = $sheetData[$i][6];
            $KontrakPayungItem->hna_diskon_ppn = $sheetData[$i][7];
            $KontrakPayungItem->save();
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
