
<table style="width: 100%;">
    <tr>
      <td style="width: 20%;text-align: left;">
          <img src="assets/img/logo-kemenkes.png" height="50px">
      </td>
      <td style="width: 60%;">
        <div style="font-size:14px; text-align:center;">
            KEMENTERIAN KESEHATAN RI<br>
            DIREKTORAT JENDRAL PELAYANAN KESEHATAN<br>
            RS PON PROF.DR.dr. MAHAR MARDJONO JAKARTA<br><br>
        </div>
      </td>
      <td style="width: 20%;text-align: right;">
          <img src="assets/img/logo-rspon.png" height="50px">
      </td>
    </tr>
</table>

<div style="font-size:14px; text-align:center;">
    FORM PENILAIAN PRESTASI KERJA
    <br><br>
</div>


<table class="" style="width: 100%;margin-bottom: 10px;">
    <tr>
        <td style="width:25%;text-align:right;">
            Bulan &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td style="width:25%;text-align:left;">
            : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {{monthIndo($data->bulan)}}
        </td>
        <td style="width:25%;text-align:right;">
            Tahun &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
        <td style="width:25%;text-align:left;">
            : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            {{$data->tahun}}
        </td>
    </tr>
</table>

<table class="table table-bordered table-sm" style="width: 100%;">

    <tr>
        <th class="text-center" colspan="8">
            IDENTITAS PEGAWAI
        </th>
    </tr>



    <tr>
        <td colspan="2">
            Nama :
        </td>
        <td colspan=3>
            {{ $data->user->name }}
        </td>
        <td>
            Unit Kerja :
        </td>
        <td colspan=2>
            {{ !empty($data->unit_kerja->name) ? $data->unit_kerja->name : '' }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Nip :
        </td>
        <td colspan=3>
            {{ $data->user->nip }}
        </td>
        <td>
            Jabatan :
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
        <th class="text-center" rowspan="2" style="width: 0.2cm;">
            NO
        </th>
        <th class="text-center"  rowspan="2" style="width: 4cm;">
            INDIKATOR
        </th>
        <th class="text-center" colspan="2">
            BOBOT
        </th>
        <th class="text-center" rowspan="2" style="width: 1.5cm;">
            TARGET
        </th>
        <th class="text-center" rowspan="2" style="width: 1.5cm;">
            REALISASI
        </th>
        <th class="text-center" rowspan="2" style="width: 1.5cm;">
            CAPAIAN
        </th>
        <th class="text-center" rowspan="2" style="width: 1.5cm;">
            NILAI KINERJA
        </th>
    </tr>

    <tr>
        <th class="text-center" style="width: 1.5cm;">
            PIMP
        </th>
        <th class="text-center" style="width: 1.5cm;">
            STAFF
        </th>
    </tr>

    <?php $total_nilai_perilaku = 0; ?>
    @foreach ($data->penilaian_perilaku_kerja as $key => $val)
    <?php $total_nilai_perilaku += $val->nilai_kinerja; ?>
    @if ($data->jabatan->is_staff && !empty($val->indikator_tetap->name) && $val->indikator_tetap->name == 'Kepemimpinan')

    @else
    <tr>
        <td class="text-center">
            {{$key + 1}}
        </td>
        <td>
            {{!empty($val->indikator_tetap->name) ? $val->indikator_tetap->name : ''}}
        </td>
        <td class="text-center">
            {{ $val->indikator_tetap->bobot_pimpinan }}
        </td>
        <td class="text-center">
            {{ !empty($val->indikator_tetap->bobot_staff) ? $val->indikator_tetap->bobot_staff : '0.00' }}
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
    @endif
    @endforeach

    <tr>
        <td class="text-center" colspan="7">
            Jumlah nilai indikator perilaku
        </td>
        <td class="text-center">
          {{$total_nilai_perilaku}}
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
            {{$val->bobot}}
        </td>
        <td align="center">
            {{$val->target}}
        </td>
        <td align="center">
            {{ $val->realisasi }}
        </td>
        <td align="center">
            {{ $val->capaian }}
        </td>
        <td align="center">
            {{ $val->nilai_kinerja }}
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


    <?php $total_nilai_kualitas = 0; ?>
    @foreach ($data->penilaian_kualitas as $key => $val)
    <?php $total_nilai_kualitas += $val->nilai_kinerja; ?>
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
          {{$total_nilai_kualitas}}
        </td>
    </tr>

    <?php $total_nilai_kinerja_utama +=  $total_nilai_kualitas; ?>





    <tr>
        <td class="text-center" colspan="7">
            JUMLAH CAPAIAN KINERJA UTAMA
        </td>
        <td class="text-center">
          {{ $total_nilai_kinerja_utama }}
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

    <?php $total_nilai_tambahan = 0; ?>


    @foreach ($data->penilaian_tambahan as $key => $val)
    <?php $total_nilai_tambahan += $val->nilai_kinerja; ?>
    <tr>
        <td class="text-center">
            {{ $key+1 }}
        </td>
        <td align="center" colspan="2">
            {{ $val->indikator_kinerja_text }}
        </td>
        <td align="center">
            {{ $val->bobot }}
        </td>
        <td align="center">
            {{ $val->target }}
        </td>
        <td align="center">
            {{ $val->realisasi }}
        </td>
        <td align="center">
            {{ $val->capaian }}
        </td>
        <td align="center">
            {{ $val->nilai_kinerja }}
        </td>
    </tr>
    @endforeach


    <tr>
        <td class="text-center" colspan="7">
            Capaian Kinerja Tambahan
        </td>
        <td class="text-center">
          {{$total_nilai_tambahan}}
        </td>
    </tr>

    <tr>
        <th class="text-center" colspan="8">
            TOTAL NILAI KINERJA INDIVIDU (PERILAKU + KINERJA UTAMA + KINERJA TAMBAHAN)
        </th>
    </tr>
    <tr>
        <td class="text-center" colspan="7">
            INDEKS KINERJA INDIVIDU (IKI)
        </td>
        <td class="text-center">
          {{ $total_nilai_kinerja_utama + $total_nilai_perilaku + $total_nilai_tambahan }}
        </td>

    </tr>


    @if ($show_iku)
    <tr>
        <td class="text-center" colspan="8">
            <br/>
        </td>
    </tr>


    <tr>
        <th class="text-center" colspan="8">
            INDEKS KINERJA UNIT (IKU)
        </th>
    </tr>

    <tr>
        <th class="text-center" colspan="3">
        </th>
        <th class="text-center">
            TARGET
        </th>
        <th class="text-center">
            REALISASI
        </th>
        <th class="text-center" colspan="2">
            CAPAIAN UNIT
        </th>
        <th class="text-center">
            IKU
        </th>
    </tr>

    <tr>
        <td colspan="3" class="text-center">
          Capaian Kinerja Unit (IKU)
        </td>
        <td>
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
        <td colspan="2">
          &nbsp;
        </td>
        <td>
          &nbsp;
        </td>
    </tr>

    <tr>
        <td colspan="8">
            Catatatn Khusus (Incidental Record) dari Atasan :
            <br><br><br>
        </td>
    </tr>
    @endif





</table>
<br/><br/>
<table class="table" style="width: 100%; page-break-inside: avoid;">
    <tr>
      <th colspan="3" class="text-center">
          PERSETUJUAN PENILAIAN
      </th>
    </tr>
    <tr>
      <td class="text-center" style="width: 33%;">Pegawai Yang Dinilai</td>
      <td class="text-center" style="width: 33%;">Menyetujui Atasan Langsung</td>
      <td class="text-center" style="width: 33%;">Mengetahui Atasan Pejabat Penilai</td>
    </tr>




    <tr>
      <td>
          <?php
            $approval_1 = false;
            $approval_2 = false;
            $approval_3 = false;
            foreach ($penilaian_approval as $key => $val) {
              if (!empty($data->user->id) && $data->user->id == $val->user_id) {
                $approval_1 = $val;
              }
              if (!empty($user_penilai->id) && $user_penilai->id == $val->user_id) {
                  $approval_2 = $val;
              }
              if (!empty($user_atasan_penilai->id) && $user_atasan_penilai->id == $val->user_id) {
                  $approval_3 = $val;
              }
            }
          ?>
          @if ($approval_1)
            {!! barcode_ttd($approval_1) !!}
          @endif
      </td>
      <td>
          @if ($approval_2)
            {!! barcode_ttd($approval_2) !!}
          @endif
      </td>
      <td>
          @if ($approval_3)
            {!! barcode_ttd($approval_3) !!}
          @endif
      </td>
    </tr>

</table>

<?php date_default_timezone_set("Asia/Jakarta"); ?>

<footer>
  <span style="">Generated by "simpeg rspon" at ({{ date('Y-m-d H:i:s') }})</span>
</footer>



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

   .noborder td {
      border: none;
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
