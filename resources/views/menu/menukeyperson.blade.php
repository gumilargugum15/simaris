
<li class="treeview">
    <a href="#">
      <i class="fa fa-laptop"></i>
      <span>Master</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{ url('kpikeyperson') }}"><i class="fa fa-circle-o"></i>KPI</a></li>
    </ul>
  </li>
<li class="treeview">
<a href="#">
    <i class="fa fa-edit"></i> <span>Risiko (Keyperson)</span>
      <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
    </span>
</a>
<ul class="treeview-menu">
    <li><a href="{{ url('resikobisnis') }}"><i class="fa fa-circle-o"></i>Resiko Proses Bisnis</a></li>
    {{-- <li><a href="{{ url('risikoaset') }}"><i class="fa fa-circle-o"></i>Resiko Asset</a></li>
    <li><a href="{{ url('risikoproject') }}"><i class="fa fa-circle-o"></i>Resiko Project</a></li> --}}
</ul>
</li>