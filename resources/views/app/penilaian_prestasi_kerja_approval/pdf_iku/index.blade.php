
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
    FORM Approval Penilaian Prestasi Kerja
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
        </td>
        <td colspan=3>
        </td>
        <td>
        </td>
        <td colspan=2>
        </td>
    </tr>


    <tr>
        <th class="text-center" colspan="8">
          <br>
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
    @foreach ($data->penilaian_prestasi_kerja_approval_item as $key => $val)
        <?php $total_nilai_kinerja += $val->nilai_kinerja; ?>
        @if (!empty($val->indikator_kinerja->tipe_indikator)  && $val->indikator_kinerja->tipe_indikator == 'iku')
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
        @endif
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


</table>
<br/><br/>
<table class="table" style="width: 100%;">
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
      <td>&nbsp;<br><br><br><br></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="text-center">{{ $data->user->name }}</td>
      <td class="text-center">{{ !empty($user_penilai->name) ? $user_penilai->name : '' }}</td>
      <td class="text-center">{{ !empty($user_atasan_penilai->name) ? $user_atasan_penilai->name : '' }}</td>
    </tr>
    <tr>
      <td class="text-center">{{ $data->user->nip }}</td>
      <td class="text-center">{{ !empty($user_penilai->nip) ? $user_penilai->nip : '' }}</td>
      <td class="text-center">{{ !empty($user_atasan_penilai->nip) ? $user_atasan_penilai->nip : '' }}</td>
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
