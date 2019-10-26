<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
              <li class="text-muted menu-title">Main Menu</li>
              <li><a href="{{url('/dashboard/home')}}"><i class=" ti-layout-media-center-alt"></i><span>Home</span></a></li>
              <li><a href="{{ url('/dashboard/modul/add') }}"><i class="ti-book"></i><span>Buat Modul</span></a></li>
              <!-- <li><a href="{{ url('/dashboard/quiz') }}"><i class="ti-medall"></i><span>Evaluasi Tantangan</span></a></li> -->
              <li><a href="{{ url('/dashboard/rapor') }}"><i class=" ti-bookmark-alt "></i><span>Buat Format Rapor</span></a></li>
              <li><a href="{{ url('/dashboard/kupon/add')}}"><i class="ti-ticket"></i><span>Buat Kupon Perubahan</span></a></li>

              <li class="text-muted menu-title">List</li>
              <li><a href="{{ url('/dashboard/user') }}"><i class="ti-user"></i><span>List User</span></a></li>
              <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="ti-layout-media-overlay"></i><span class="menu-arrow"></span><span>List Sekolah</span></span></a>
                  <ul class="list-unstyled">
                      <li><a href="{{ url('/dashboard/sekolah/model') }}">Sekolah Model GSM</a></li>
                      <li><a href="{{ url('/dashboard/sekolah/emodel') }}">Sekolah e-Model GSM</a></li>
                      <li><a href="{{ url('/dashboard/sekolah/jejaring') }}">Sekolah Jejaring GSM</a></li>
                      <li><a href="{{ url('/dashboard/sekolah/indonesia') }}">Sekolah Indonesia</a></li>
                  </ul>
              </li>
              <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="ti-book"></i><span class="menu-arrow"></span><span>List Modul</span></a>
                  <ul class="list-unstyled">
                      <li><a href="{{ url('/dashboard/modul/basic') }}">Level Basic</a></li>
                      <li><a href="{{ url('/dashboard/modul/advanced') }}">Level Advanced</a></li>
                  </ul>
              </li>
              <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="ti-agenda"></i><span class="menu-arrow"></span><span>List Rapor</span></a>
                  <ul class="list-unstyled">
                      <li><a href="{{ url('/dashboard/raporbyassessor/listassessor') }}">Rapor User</a></li>
                      <li><a href="{{ url('/dashboard/rapor/sekolah') }}">Rapor Sekolah</a></li>
                  </ul>
              </li>
              <li class="has_sub">
                  <a href="javascript:void(0);" class="waves-effect"><i class="ti-email"></i><span class="menu-arrow"></span><span>List Permintaan</span></a>
                  <ul class="list-unstyled">
                      <li><a href="{{ url('/dashboard/request/assessor') }}">Permintaan Mentor</a></li>
                      <li><a href="{{ url('/dashboard/request/sekolah') }}">Permintaan Sekolah Model</a></li>
                  </ul>
              </li>
              <li><a href="{{ url('/dashboard/kupon') }}"><i class="ti-ticket"></i><span>List Kupon Perubahan</span></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
