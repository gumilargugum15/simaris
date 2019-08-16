<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<table id="lapriskbisnis" class="table table-bordered table-striped">
<tr>
    <td width="30%">unit Kerja : {{$unit->nama}}</td>
    <td align="center" rowspan="2" valign="center"><b>Risiko Unit Kerja</b></td>
</tr>
<tr><td>Periode : {{$periode}}</td></tr>
</table>
<table>
<tr>
    <td width="30%" colspan="2">TUJUAN</td><td width="30%" colspan="6">DENFITIKASI RISIKO</td><td width="30%" colspan="5">PENILAIAN RISIKO</td><td width="30%" colspan="3">PENETAPAN RESPON RISIKO</td><td width="30%" colspan="2">TINDAK LANJUT</td>
</tr>
<tr>
    <td>NO</td><td>KPI</td><td>KLASIFIKASI</td><td>NAMA RISIKO</td><td>SUMBER RISIKO</td><td>AKIBAT</td><td>INDIKATOR</td><td>NILAI AMBANG</td>
    <td>PELUANG</td><td>LEVEL</td><td>DAMPAK</td><td>LEVEL</td><td>TINGKAT RISIKO</td><td>MITIGASI</td><td>BIAYA</td><td>TARGET</td>
    <td>PIC</td><td>STATUS</td>
</tr>
@php
$no=0;
@endphp
@foreach($riskdetail as $key=>$value)

@php
$no++;
$count = count($value->risikobisnisdetail);
@endphp
<tr>
    <td rowspan="{{$count}}">{{$no}}</td>
    <td rowspan="{{$count}}">{{$value->nama}}</td>
    @foreach($value->risikobisnisdetail as $keys=>$values)
        {{-- <td>{{$values->klas->nama}}</td><td>{{$values->risiko}}{{$keys}}</td> --}}
        @if($keys == 0)
                <td>{{$values->klas->nama}}</td><td>{{$values->risiko}}</td><td>
                        @foreach($values->sumber as $keysumber=>$valuesumber)
                        <li>{{$valuesumber->namasumber}}</li>
                        @endforeach
                </td><td>{{$values->akibat}}</td><td>{{$values->indikator}}</td><td>{{$values->nilaiambang}}</td><td>{{$values->peluang->kriteria}}</td><td>{{$values->peluang->level}}</td><td>{{$values->kriteria[0]->nama}}</td><td>{{$values->dampak->level}}</td><td>{{$values->matrik[0]->tingkat}}</td>
                <td>
                    @foreach($values->sumber as $keysumber=>$valuesumber)
                        <li>{{$valuesumber->mitigasi}}</li>
                    @endforeach
                </td>
                <td>
                    @foreach($values->sumber as $keysumber=>$valuesumber)
                        <li>{{$valuesumber->biaya}}</li>
                    @endforeach
                </td>
                <td>
                    @foreach($values->sumber as $keysumber=>$valuesumber)
                        <li>{{$valuesumber->start_date}} s/d {{$valuesumber->end_date}}</li>
                    @endforeach
                </td>
                <td>
                    @foreach($values->sumber as $keysumber=>$valuesumber)
                        <li>{{$valuesumber->pic}}</li>
                    @endforeach
                </td>
                <td>
                    @foreach($values->sumber as $keysumber=>$valuesumber)
                        <li>{{$valuesumber->statussumber}}</li>
                    @endforeach
                </td>
            </tr>
        @else 
            <tr><td>{{$values->klas->nama}}</td><td>{{$values->risiko}}</td><td>
                    @foreach($values->sumber as $keysumber=>$valuesumber)
                    <li>{{$valuesumber->namasumber}}</li>
                    @endforeach
            </td><td>{{$values->akibat}}</td><td>{{$values->indikator}}</td><td>{{$values->nilaiambang}}</td><td>{{$values->peluang->kriteria}}</td><td>{{$values->peluang->level}}</td><td>{{$values->kriteria[0]->nama}}</td><td>{{$values->dampak->level}}</td><td>{{$values->matrik[0]->tingkat}}</td>
            <td>
                @foreach($values->sumber as $keysumber=>$valuesumber)
                    <li>{{$valuesumber->mitigasi}}</li>
                @endforeach
            </td>
            <td>
                @foreach($values->sumber as $keysumber=>$valuesumber)
                    <li>{{$valuesumber->biaya}}</li>
                @endforeach
            </td>
            <td>
                @foreach($values->sumber as $keysumber=>$valuesumber)
                    <li>{{$valuesumber->start_date}} s/d {{$valuesumber->end_date}}</li>
                @endforeach
            </td>
            <td>
                @foreach($values->sumber as $keysumber=>$valuesumber)
                    <li>{{$valuesumber->pic}}</li>
                @endforeach
            </td>
            <td>
                @foreach($values->sumber as $keysumber=>$valuesumber)
                    <li>{{$valuesumber->statussumber}}</li>
                @endforeach
            </td>
        </tr>
        @endif
    @endforeach 

@endforeach
</table>
</body>
</html>