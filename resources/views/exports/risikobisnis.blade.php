<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- {{ HTML::style('table.css') }} --}}
   
</head>
<body>
@php
echo $tabel;
@endphp
{{-- <table id="lapriskbisnis" class="table table-bordered table-striped">
    <tr>
        <th>Unit kerja : {{$unit->nama}}</th>
        <th align="center" rowspan="2" valign="center"><b>Risiko Unit Kerja</b></th>
        <th>Tingkat Risiko:</th>
    </tr>
    <tr>
        <th>Periode : {{$periode->nama}} Tahun {{$periode->tahun}}</th>
    </tr>
</table> --}}
{{-- <table border="1">
    <tr>
        <th colspan="2">TUJUAN</th><th  colspan="6">IDENFITIKASI RISIKO</th><th colspan="5">PENILAIAN RISIKO</th><th colspan="3">PENETAPAN RESPON RISIKO</th><th colspan="2">TINDAK LANJUT</th>
    </tr>
    <tr align="center">
        <th>NO</th><th>KPI</th><th>KLASIFIKASI</th><th>NAMA RISIKO</th><th>SUMBER RISIKO</th><th>AKIBAT</th><th>INDIKATOR</th><th>NILAI AMBANG</th>
        <th>PELUANG</th><th>LEVEL</th><th>DAMPAK</th><th>LEVEL</th><th>TINGKAT RISIKO</th>
        <th>MITIGASI</th><th>BIAYA</th><th>TARGET</th>
        <th>PIC</th><th>STATUS</th>
    </tr>
    @foreach($detailrisk as $data) 
    @php
    $no=0;
    $no++;
    @endphp
    @if($data->jmlsumber > 1)
    <tr>
    <td rowspan="{{$data->jmlsumber}}" align="center">{{$no}}</td><td rowspan="{{$data->jmlsumber}}" valign="top">{{$data->namakpi}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->namaklas}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->risiko}}</td>
    @foreach($data->sumber as $key=>$dsumber) 
      @if($key=='0') 
      <td>{{$dsumber->namasumber}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->akibat}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->indikator}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->nilaiambang}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->peluang}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->levelpeluang}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->dampak}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->leveldampak}}</td><td rowspan="{{$data->jmlsumber}}">{{$data->tingkat}}</td><td>{{$dsumber->mitigasi}}</td><td>{{$dsumber->biaya}}</td><td>{{$dsumber->start_date}} s/d {{$dsumber->start_date}}</td><td>{{$dsumber->pic}}</td><td>{{$dsumber->statussumber}}</td></tr>
      @else 
      <tr><td>{{$dsumber->namasumber}}</td><td>{{$dsumber->mitigasi}}</td><td>{{$dsumber->biaya}}</td><td>{{$dsumber->start_date}} s/d {{$dsumber->start_date}}</td><td>{{$dsumber->pic}}</td><td>{{$dsumber->statussumber}}</td></tr>
      @endif
    @endforeach
    @else 
    <tr>
      <td align="center">{{$no}}</td><td>{{$data->namakpi}}</td><td>{{$data->namaklas}}</td><td>{{$data->risiko}}</td>
      @foreach($data->sumber as $key=>$dsumber) 
      <td>{{$dsumber->namasumber}}</td><td>{{$data->akibat}}</td><td>{{$data->indikator}}</td><td>{{$data->nilaiambang}}</td><td>{{$data->peluang}}</td><td>{{$data->levelpeluang}}</td><td>{{$data->dampak}}</td><td>{{$data->leveldampak}}</td><td>{{$data->tingkat}}</td><td>{{$dsumber->mitigasi}}</td><td>{{$dsumber->biaya}}</td><td>{{$dsumber->start_date}} s/d {{$dsumber->start_date}}</td><td>{{$dsumber->pic}}</td><td>{{$dsumber->statussumber}}</td>
      @endforeach
    </tr>
    @endif
    
    @endforeach
    <tr><td colspan="12">-</td></tr>
  </table> --}}
</body>
</html>