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
          <li><a href="{{ url('users') }}"><i class="fa fa-circle-o"></i>Users</a></li>
          
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
          <li><a href="{{ url('periodebisnis') }}"><i class="fa fa-circle-o"></i>Periode bisnis</a></li>
          {{-- <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i>Klasifikasi</a></li>
          <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i>Peluang</a></li> --}}
          <li><a href="{{ url('unit') }}"><i class="fa fa-circle-o"></i>Unit</a></li>
          {{-- <li><a href="{{ url('project') }}"><i class="fa fa-circle-o"></i>Project</a></li> --}}
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-edit"></i> <span>Risiko (administrator)</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{ url('resikobisnisverifikatur') }}"><i class="fa fa-circle-o"></i>Risiko Proses Bisnis</a></li>
          <li><a href="{{ url('risikokrirkap') }}"><i class="fa fa-circle-o"></i>Risiko KRI / RKAP</a></li>
          {{-- <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i>Resiko Project</a></li>
          <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i>Resiko Asset</a></li> --}}
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
          <li><a href="{{ url('laprisikobisniskpiutama') }}"><i class="fa fa-circle-o"></i>Resiko Proses Bisnis KPI Utama</a></li>
          
        </ul>
      </li>