



<div style="font-size:14px; text-align:center;">
    KEMENTERIAN KESEHATAN RI<br>
    DIREKTORAT JENDRAL PELAYANAN KESEHATAN<br>
    RS PON PROF.DR.dr. MAHAR MARDJONO JAKARTA<br><br>
</div>

<div style="font-size:14px; text-align:center;">
    FORM PENILAIAN PRESTASI KERJA
    <br><br>
</div>


<table class="" style="width: 100%;margin-bottom: 10px;">
    <tr>
        <td style="width:15%;text-align:center;">
            Bulan
        </td>
        <td style="width:35%;text-align:left;">
            : {{monthIndo($data->bulan)}}
        </td>
        <td style="width:15%;text-align:center;">
            Tahun
        </td>
        <td style="width:35%;text-align:left;">
            : {{$data->tahun}}
        </td>
    </tr>
</table>

<table class="table table-bordered table-sm" style="width: 100%;">

    <tr>
        <th class="text-center" colspan="8">
            Identitas Pegawai
        </th>
    </tr>


    <tr>
        <td colspan="2">
            Nama
        </td>
        <td colspan=3>
            {{ $data->user->name }}
        </td>
        <td>
            Unit Kerja
        </td>
        <td colspan=2>
            {{ !empty($data->unit_kerja->name) ? $data->unit_kerja->name : '' }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Nip
        </td>
        <td colspan=3>
            {{ $data->user->nip }}
        </td>
        <td>
            Jabatan
        </td>
        <td colspan=2>
            @if (!empty($data->jabatan->is_staff) && $data->jabatan->is_staff)
            {{ !empty($data->jabatan_fungsional->name) ? $data->jabatan_fungsional->name : '' }}
            @else
            {{ !empty($data->jabatan->name) ? $data->jabatan->name : '' }}
            @endif
        </td>
    </tr>


    <tr>
        <th class="text-center" colspan="8">
          <br>
        </th>
    </tr>





    <tr>
        <th class="text-center" colspan="8">
            INDIKATOR PERILAKU KERJA (30%)
        </th>
    </tr>

    <tr>
        <th class="text-center" rowspan="2">
            NO
        </th>
        <th class="text-center"  rowspan="2">
            INDIKATOR
        </th>
        <th class="text-center" colspan="2">
            BOBOT
        </th>
        <th class="text-center" rowspan="2">
            TARGET
        </th>
        <th class="text-center" rowspan="2">
            REALISASI
        </th>
        <th class="text-center" rowspan="2">
            CAPAIAN
        </th>
        <th class="text-center" rowspan="2">
            NILAI KINERJA
        </th>
    </tr>

    <tr>
        <th class="text-center">
            PIMP
        </th>
        <th class="text-center">
            STAFF
        </th>
    </tr>

    <?php $total_nilai_kinerja = 0; ?>
    @foreach ($data->penilaian_perilaku_kerja as $key => $val)
    <?php $total_nilai_kinerja += $val->nilai_kinerja; ?>
    <tr>
        <td class="text-center">
            {{$key + 1}}
        </td>
        <td>
            {{!empty($val->indikator_tetap->name) ? $val->indikator_tetap->name : ''}}
        </td>
        <td class="text-center">
            00
        </td>
        <td class="text-center">
            00
        </td>
        <td class="text-center">
            {{ $val->target }}
        </td>
        <td class="text-center">
            {{ $val->realisasi }}
        </td>
        <td class="text-center">
            {{ $val->capaian }}
        </td>
        <td class="text-center">
            {{ $val->nilai_kinerja }}
        </td>
    </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="7">
            Jumlah nilai indikator perilaku
        </td>
        <td class="text-center">
          {{$total_nilai_kinerja}}
        </td>
    </tr>

    <tr>
        <th class="text-center" colspan="8">
            <br />
        </th>
    </tr>





    <tr>
        <th class="text-center" colspan="8">
            INDIKATOR SASARAN KINERJA (70%)
        </th>
    </tr>

    @if ($jabatan->is_staff == 1)
    <tr>
        <th class="text-center" colspan="8">
            KINERJA UTAMA
        </th>
    </tr>

    <tr>
        <th class="text-center" colspan="8">
            INDIKATOR KUANTITAS KERJA (40%)
        </th>
    </tr>
    @endif

    <tr>
        <th class="text-center">
            NO
        </th>
        <th class="text-center" colspan="2">
            URAIAN KINERJA UTAMA
        </th>
        <th class="text-center">
            BOBOT
        </th>
        <th class="text-center">
            TARGET
        </th>
        <th class="text-center">
            REALISASI
        </th>

        <th class="text-center">
            CAPAIAN
        </th>
        <th class="text-center">
            NILAI KINERJA
        </th>
    </tr>
    <tr>
        <th class="text-center fs-8">
            1
        </th>
        <th class="text-center fs-8" colspan="2">
            2
        </th>
        <th class="text-center fs-8">
            3
        </th>
        <th class="text-center fs-8">
            4
        </th>
        <th class="text-center fs-8">
            5
        </th>
        <th class="text-center fs-8">
            6 = 5/4
        </th>
        <th class="text-center fs-8">
            7 = 6*3
        </th>
    </tr>
    <?php $total_nilai_kinerja = 0; ?>
    @foreach ($data->penilaian_prestasi_kerja_item as $key => $val)
    <?php $total_nilai_kinerja += $val->nilai_kinerja; ?>
    <tr>
        <td class="text-center">
            {{$key + 1}}
        </td>
        <td colspan="2">
            {{!empty($val->indikator_kinerja->name) ? $val->indikator_kinerja->name : ''}}
        </td>
        <td align="center">
            @if ($jabatan->is_staff == 1)
              <input type="text" name="bobot" class="form-control" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="text-align:center;">
            @else
              {{$val->bobot}}
            @endif
        </td>
        <td align="center">
            @if ($jabatan->is_staff == 1)
              <input type="text" name="target" class="form-control" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="text-align:center;">
            @else
              {{$val->target}}
            @endif
        </td>
        <td align="center">
            @if ($jabatan->is_staff == 1)
              <input type="text" class="form-control" value="{{ $val->realisasi }}" data-id="{{ $val->id }}" style="text-align:center;" disabled>
            @else
              {{ $val->realisasi }}
            @endif
        </td>
        <td align="center">
            @if ($jabatan->is_staff == 1)
              <input type="text" name="capaian" id="capaian_{{$val->id}}" class="form-control" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="text-align:center;">
            @else
              {{ $val->capaian }}
            @endif
        </td>
        <td align="center">
            @if ($jabatan->is_staff == 1)
              <input type="text" name="nilai_kinerja" id="nilai_kinerja_{{$val->id}}" class="form-control" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="text-align:center;">
            @else
              {{ $val->nilai_kinerja }}
            @endif
        </td>

    </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="7">
            Capaian kinerja utama Indikator Kuantitas
        </td>
        <td class="text-center">
          {{$total_nilai_kinerja}}
        </td>
    </tr>
    <?php $total_nilai_kinerja_utama =  $total_nilai_kinerja; ?>


    @if ($jabatan->is_staff == 1)

    <tr>
        <th class="text-center" colspan="8">
            <br />
        </th>
    </tr>


    <tr>
        <th class="text-center" colspan="8">
            Indikator Kualitas Kerja (30%)
        </th>
    </tr>

    <tr>
        <th class="text-center">
            No
        </th>
        <th class="text-center" colspan="2">
            Indikator
        </th>
        <th class="text-center">
            Bobot
        </th>
        <th class="text-center">
            Target
        </th>
        <th class="text-center">
            Realisasi
        </th>
        <th class="text-center">
            Capaian
        </th>
        <th class="text-center">
            Nilai Kinerja
        </th>
    </tr>


    @foreach ($data->penilaian_kualitas as $key => $val)
    <tr>
        <td class="text-center">
            {{$key + 1}}
        </td>
        <td colspan="2">
            {{!empty($val->indikator_tetap->name) ? $val->indikator_tetap->name : ''}}
        </td>
        <td class="text-center">
            {{ $val->bobot }}
        </td>
        <td class="text-center">
            {{ $val->target }}
        </td>
        <td class="text-center">
            {{ $val->realisasi }}
        </td>
        <td class="text-center">
            {{ $val->capaian }}
        </td>
        <td class="text-center">
            {{ $val->nilai_kinerja }}
        </td>
    </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="7">
            Capaian kinerja utama Indikator Kualitas
        </td>
        <td class="text-center">
          {{$total_nilai_kinerja}}
        </td>
    </tr>
    <?php $total_nilai_kinerja_utama +=  $total_nilai_kinerja; ?>


    @endif

    <tr>
        <td class="text-center" colspan="7">
            JUMLAH CAPAIAN KINERJA UTAMA
        </td>
        <td class="text-center">
          {{$total_nilai_kinerja_utama}}
        </td>
    </tr>

    <tr>
        <th class="text-center" colspan="8">
            <br />
        </th>
    </tr>











    <tr>
        <th class="text-center" colspan="8">
            KINERJA TAMBAHAN
        </th>
    </tr>

    <tr>
        <th class="text-center" style="width: 40px;">
            NO
        </th>
        <th class="text-center" colspan="2">
            URAIAN KINERJA UTAMA
        </th>
        <th class="text-center">
            BOBOT
        </th>
        <th class="text-center">
            TARGET
        </th>
        <th class="text-center">
            REALISASI
        </th>
        <th class="text-center">
            CAPAIAN
        </th>
        <th class="text-center">
            NILAI KINERJA
        </th>
    </tr>

    <?php $total_nilai_kinerja = 0; ?>
    @foreach ($data->penilaian_tambahan as $key => $val)
    <?php $total_nilai_kinerja += $val->nilai_kinerja; ?>
    <tr>
        <td class="text-center">
            {{ $key+1 }}
        </td>
        <td align="center" colspan="2">
            <input type="text" name="indikator_kinerja_text" class="form-control" value="{{ $val->indikator_kinerja_text }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}">
        </td>
        <td align="center">
            <input type="text" name="bobot" class="form-control text-center" value="{{ $val->bobot }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="">
        </td>
        <td align="center">
            <input type="text" name="target" class="form-control text-center" value="{{ $val->target }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="">
        </td>
        <td align="center">
            <input type="text" name="realisasi" class="form-control text-center" value="{{ $val->realisasi }}"   data-id="{{ $val->id }}" style="">
        </td>
        <td align="center">
            <input type="text" name="capaian" class="form-control text-center" value="{{ $val->capaian }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="">
        </td>
        <td align="center">
            <input type="text" name="nilai_kinerja" class="form-control text-center" value="{{ $val->nilai_kinerja }}" onChange="saveSKP(this)"  data-id="{{ $val->id }}" style="">
        </td>

    </tr>
    @endforeach

    <tr>
        <td class="text-center" colspan="7">
            Jumlah nilai kegiatan tambahan
        </td>
        <td class="text-center">
          {{$total_nilai_kinerja}}
        </td>

    </tr>
</table>










<style type="text/css">
   * {
   font-family: font-family: Arial, Helvetica, sans-serif !important;
   }
   * {
   font-size: 10px;
   }
   .table {
   border-collapse: collapse;
   }
   .table td, .table th {
   border: solid thin;
   padding: 2px;
   }
   .text-right {
   text-align: right;
   }
   .text-center {
   text-align: center;
   }
   .text-bold {
   font-weight: bold
   }
   td {
   vertical-align: top;
   }

   .daftar-obat td, .daftar-obat th {
    font-size: 8pt !important;
   }

ol.huruf_tipe1 {
  counter-reset: my-awesome-counter-1;
  list-style: none;
}
.huruf_tipe1 > li {
  counter-increment: my-awesome-counter-1;
  position: relative;
}
.huruf_tipe1 > li::before {
  content: "(" counter(my-awesome-counter-1, lower-alpha) ") ";
  position: absolute;
  line-height: var(--size);
  height: var(--size);
  top: 3px;

  left: -29;
  text-align: left;
}


ol.huruf_tipe2 {
  counter-reset: my-awesome-counter-2;
  list-style: none;
}
.huruf_tipe2 > li {
  counter-increment: my-awesome-counter-2;
  position: relative;
}
.huruf_tipe2 > li::before {
  content: counter(my-awesome-counter-2, lower-alpha) ". ";
  position: absolute;
  line-height: var(--size);
  height: var(--size);
  top: 3px;

  left: -29;
  text-align: left;
}

ol.huruf_tipe3 {
  counter-reset: my-awesome-counter-3;
  list-style: none;
}
.huruf_tipe3 > li {
  counter-increment: my-awesome-counter-3;
  position: relative;
}
.huruf_tipe3 > li::before {
  content: counter(my-awesome-counter-3, lower-alpha);
  position: absolute;
  line-height: var(--size);
  height: var(--size);
  top: 3px;

  left: -29;
  text-align: left;
}

ol.angka_tipe1 {
  counter-reset: my-awesome-counter-4;
  list-style: none;
}
.angka_tipe1 > li {
  counter-increment: my-awesome-counter-4;
  position: relative;
}
.angka_tipe1 > li::before {
  content: counter(my-awesome-counter-4) '. ';
  position: absolute;
  line-height: var(--size);
  height: var(--size);
  top: 3px;

  left: -29;
  text-align: left;
}


ol.angka_tipe2 {
  counter-reset: my-awesome-counter-5;
  list-style: none;
}
.angka_tipe2 > li {
  counter-increment: my-awesome-counter-5;
  position: relative;
}
.angka_tipe2 > li::before {
  content: counter(my-awesome-counter-5) ")";
  position: absolute;
  line-height: var(--size);
  height: var(--size);
  top: 3px;

  left: -29;
  text-align: left;
}




footer { position: fixed; bottom: 0px; }
</style>
