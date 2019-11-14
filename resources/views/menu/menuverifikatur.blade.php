<li class="treeview">
  <a href="#">
    <i class="fa fa-gears (alias)"></i>
    <span>Konfigurasi</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li><a href="{{ url('userkeyperson') }}"><i class="fa fa-circle-o"></i>Otorisasi KPI</a></li>
    
  </ul>
</li>
<li class="treeview">
    <a href="#">
      <i class="fa fa-laptop"></i>
      <span>Master</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{ url('kpi') }}"><i class="fa fa-circle-o"></i>KPI</a></li>
      <li><a href="{{ url('periodebisnis') }}"><i class="fa fa-circle-o"></i>Periode risiko bisnis</a></li>
    </ul>
  </li>
<li class="treeview">
        <a href="#">
          <i class="fa fa-edit"></i> <span>Risiko (Verifikatur)</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('resikobisnisverifikatur') }}"><i class="fa fa-circle-o"></i>Risiko Proses Bisnis</a></li>
          <li><a href="{{ url('risikokrirkap') }}"><i class="fa fa-circle-o"></i>Risiko KRI / RKAP</a></li>
          {{-- <li><a href="{{ url('risikoaset') }}"><i class="fa fa-circle-o"></i>Resiko Asset</a></li>
          <li><a href="{{ url('risikoprojectverifikatur') }}"><i class="fa fa-circle-o"></i>Resiko Project</a></li> --}}
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-table"></i> <span>Laporan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('laprisikobisnis') }}"><i class="fa fa-circle-o"></i>Resiko Proses Bisnis</a></li>
          
          {{-- <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i>Resiko Project</a></li>
          <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i>Resiko Assets</a></li> --}}
        </ul>
      </li>