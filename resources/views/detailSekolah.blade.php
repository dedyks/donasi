@extends('sekolah.master')
<!-- @extends('layout.dashboard') -->
@section('title')
  <title>Detail Sekolah</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-editable/datatables.css')}}">
@endsection

@section('content')
  <div class="content-page">
      <div class="content">
          <div class="container">
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="page-title">Detail Sekolah</h4>
                  <ol class="breadcrumb">
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                      <a href="{{ url('/dashboard/sekolah/model') }}">Sekolah</a>
                    </li>
                    <li class="active">
                      Detail
                    </li>
                  </ol>
                </div>
              </div>

              <div class="panel panel-color panel-custom">
                <div class="panel-heading">
                  <h3 class="panel-title">Profil Sekolah</h3>
                </div>
                <div class="panel-body">
                  <div class="col-sm-3">
                    <img src="{{ asset('assets/images/gerakan-sekolah-menyenangkan.jpg') }}" alt="image" class="img-responsive img-rounded" width="200" style="margin: auto">
                  </div>
                  <div class="col-sm-3">
                    <h5><b>Nama:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="sekolah">
                        Nama sekolah
                    </p>
                    <h5><b>Bentuk:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="bentuk">
                        Bentuk sekolah
                    </p>
                    <h5><b>Status:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="status">
                        Status sekolah
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <h5><b>NPSN:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="npsn">
                        NPSN
                    </p>
                    <h5><b>Alamat:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="alamat_jalan">
                        Alamat sekolah
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <h5><b>Kabupaten/Kota:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="kabupaten_kota">
                        Kabupaten/Kota
                    </p>
                    <h5><b>Provinsi:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="propinsi">
                        Provinsi
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-color panel-custom">
                <div class="panel-heading">
                  <h3 class="panel-title">User di Sekolah Ini</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                      <div class="col-sm-6">
                      </div>
                  </div>
                  <table class="table table-striped" id="sUserTable">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
          </div>
      </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function(){
      var x = getCookie('token_login_user_gsm');

      var id = new URLSearchParams(document.location.search.substring(1));
      var id_sekolah = id.get("id");
      var appurl = localStorage.getItem("url_elearning_gsm")
      $("#sUserTable").DataTable();
      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/sekolah/"+id_sekolah,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status)

        document.getElementById('sekolah').innerHTML = data.data.sekolah;
        document.getElementById('bentuk').innerHTML = data.data.bentuk;
        if (data.data.status == 'N')
          document.getElementById('status').innerHTML = 'Negeri';
        else
          document.getElementById('status').innerHTML = 'Swasta';
        document.getElementById('npsn').innerHTML = data.data.npsn;
        document.getElementById('alamat_jalan').innerHTML = data.data.alamat_jalan;
        document.getElementById('kabupaten_kota').innerHTML = data.data.kabupaten_kota;
        document.getElementById('propinsi').innerHTML = data.data.propinsi;

        myJsonData = data;
        populateDataTable(myJsonData);
      })
      .fail(function(data, status){
        console.log(status);
        var err_message = data.responseText;
        var fix_message = err_message.length > 100 ? err_message.substring(0, 100 - 3) + "..." : err_message;
        swal({
          title: "Maaf",
          text: "Pastikan koneksi internet anda lancar. \n\n Message: "+fix_message,
          type: "error",
          allowOutsideClick: true
        })
      })

      function populateDataTable(data) {
        $("#sUserTable").DataTable().clear();
        var length = data.data.user.length;
        for (var i = 0; i < length; i++) {
          var a=data.data.user[i].name;
          if ('detail' in data.data.user[i]) {
            if ('position' in data.data.user[i].detail) {
              var b=data.data.user[i].detail.position;
            } else {
              var b="-";
            }
          } else {
            var b="-";
          }
          if ('role' in data.data.user[i]){
            var c=data.data.user[i].role;
          } else {
            var c="user";
          }
          var d='-';
          var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='{{ url("/dashboard") }}/user/detail?id="+data.data.user[i]._id+"'> <i class='ti-new-window'></i> Detail</a>&nbsp&nbsp&nbsp";
          $('#sUserTable').dataTable().fnAddData([
            a,
            b,
            c,
            d,
            action
          ]);
        }
      }
    })
  </script>

  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>

@endsection
