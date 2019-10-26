@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Detail User</title>
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
                  <h4 class="page-title">Detail User</h4>
                  <ol class="breadcrumb">
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                      <a href="{{ url('/user') }}">User</a>
                    </li>
                    <li class="active">
                      Detail
                    </li>
                  </ol>
                </div>
              </div>

              <div class="panel panel-color panel-custom">
                  <div class="panel-heading">
                    <h3 class="panel-title">Profil User</h3>
                  </div>
                  <div class="panel-body">
                      <div class="col-sm-3">
                        <div id="field_img">

                        </div>
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Nama:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="name">
                            -
                        </p>
                        <h5><b>Jenis kelamin:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="gender">
                            -
                        </p>
                        <h5><b>Tempat Lahir:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="birthplace">
                            -
                        </p>
                        <h5><b>Tanggal Lahir:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="birthdate">
                            -
                        </p>
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Asal Sekolah:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="school">
                            -
                        </p>
                        <h5><b>Jabatan:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="position">
                            -
                        </p>
                        <h5><b>Pernah Ikut Workshop GSM:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="attendedWorkshop">
                            -
                        </p>
                        <h5><b>Role:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="role">
                            -
                        </p>
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Pendidikan Terakhir:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="lastEducation">
                            -
                        </p>
                        <h5><b>Email:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="email">
                            -
                        </p>
                        <h5><b>No. HP (WA):</b></h5>
                        <p class="text-muted m-b-15 font-13" id="phone">
                            -
                        </p>
                      </div>
                  </div>
              </div>
              <div class="panel panel-color panel-custom">
                <div class="panel-heading">
                  <h3 class="panel-title">Aktivitas User</h3>
                </div>
                <div class="panel-body">

                  <table class="table table-striped" id="activityTable">
                      <thead>
                          <tr>
                              <th>Kategori Modul</th>
                              <th>Level Modul</th>
                              <th>Judul Modul</th>
                              <th>Status</th>
                              <th>Tanggal Mulai</th>
                              <th>Tanggal Selesai</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                  </table>
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
                        -
                    </p>
                    <h5><b>Bentuk:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="bentuk">
                        -
                    </p>
                    <h5><b>Status:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="status">
                        -
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <h5><b>NPSN:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="npsn">
                        -
                    </p>
                    <h5><b>Alamat:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="alamat_jalan">
                        -
                    </p>
                    <h5><b>Kecamatan:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="kecamatan">
                        -
                    </p>
                  </div>
                  <div class="col-sm-3">
                    <h5><b>Kabupaten/Kota:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="kabupaten_kota">
                        -
                    </p>
                    <h5><b>Provinsi:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="propinsi">
                        -
                    </p>
                    <h5><b>Label GSM:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="label_gsm">
                        -
                    </p>
                  </div>
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
      var id_user = id.get("id");

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/user/"+id_user,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status)

        document.getElementById('name').innerHTML = data.user.name;
        if (data.user.attendedWorkshop) {
          document.getElementById('attendedWorkshop').innerHTML = "Pernah"
        } else {
          document.getElementById('attendedWorkshop').innerHTML = "Tidak pernah";
        }
        document.getElementById('email').innerHTML = data.user.email;
        document.getElementById('role').innerHTML = data.user.role;
        document.getElementById('school').innerHTML = data.user.schoolgsm.sekolah;

        document.getElementById('sekolah').innerHTML = data.user.schoolgsm.sekolah;
        document.getElementById('npsn').innerHTML = data.user.schoolgsm.npsn;
        document.getElementById('bentuk').innerHTML = data.user.schoolgsm.bentuk;
        if (data.user.schoolgsm.status == 'S') {
          document.getElementById('status').innerHTML = 'Swasta';
        } else {
          document.getElementById('status').innerHTML = 'Negeri';
        }
        document.getElementById('alamat_jalan').innerHTML = data.user.schoolgsm.alamat_jalan;
        document.getElementById('kecamatan').innerHTML = data.user.schoolgsm.kecamatan;
        document.getElementById('kabupaten_kota').innerHTML = data.user.schoolgsm.kabupaten_kota;
        document.getElementById('propinsi').innerHTML = data.user.schoolgsm.propinsi;
        if (data.user.schoolgsm.model_gsm.flag == 'model_gsm')
          document.getElementById('label_gsm').innerHTML = '<span class="label label-success">Sekolah Model GSM</span>';
        else if (data.user.schoolgsm.model_gsm.flag == 'emodel_gsm')
          document.getElementById('label_gsm').innerHTML = '<span class="label label-primary">Sekolah e-Model GSM</span>';
        else
          document.getElementById('label_gsm').innerHTML = '<span class="label label-warning">Sekolah Jejaring GSM</span>';

        if ('detail' in data.user) {
          if ('gender' in data.user.detail) document.getElementById('gender').innerHTML = data.user.detail.gender;
          if ('birthplace' in data.user.detail) document.getElementById('birthplace').innerHTML = data.user.detail.birthplace;
          if ('birthdate' in data.user.detail) document.getElementById('birthdate').innerHTML = data.user.detail.birthdate;
          if ('position' in data.user.detail) document.getElementById('position').innerHTML = data.user.detail.position;
          if ('lastEducation' in data.user.detail) document.getElementById('lastEducation').innerHTML = data.user.detail.lastEducation;
          if ('phone' in data.user.detail) document.getElementById('phone').innerHTML = data.user.detail.phone;
        }

        $('#field_img').append(
          '<img src="{{ url('/') }}/storage/images/500/'+data.user.photo_profile[0].filename+'" alt="image" class="img-responsive img-rounded" width="200" style="margin: auto">'
        );
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

      $("#activityTable").DataTable();
      var appurl = localStorage.getItem("url_elearning_gsm")
      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/quiz/user/"+id_user,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        myJsonData = data;
        populateDataTable(myJsonData);
      })
      .fail(function(data, status){
        console.log(status);
      })

      function populateDataTable(data) {
        $("#activityTable").DataTable().clear();
        var length = data.data.length;
        for (var i = 0; i < length; i++) {
          if ('modul' in data.data[i] && data.data[i].modul !== null){
            var a=data.data[i].modul.aspect;
            var b=data.data[i].modul.grade;
            var c=data.data[i].modul.title;
          }
          var d=data.data[i].flag;
          var e=data.data[i].created_at;
          if (d=='scored'){
            var f=data.data[i].updated_at;
          } else {
            var f='-';
          }
          var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='quiz/detail?id="+data.data[i]._id+"'> <i class='ti-new-window'></i> Detail</a>";
          switch (a) {
            case 'trisentra-pendidikan':
              a = 'Tri Sentra Pendidikan';
              break;
            case 'ekosistem-positif':
              a = 'Penciptaan Ekosistem Positif di Sekolah';
              break;
            case 'pembelajaran-riset':
              a = 'Pembelajaran Berbasis Riset';
              break;
            case 'pengembangan-karakter':
              a = 'Pengembangan Karakter';
              break;
          }
          switch (b) {
            case 'basic':
              b = 'Basic';
              break;
            case 'advanced':
              b = 'Advanced';
              break;
          }
          switch (d) {
            case 'enrolled':
              d = '<span class="label label-primary">enrolled</span>';
              break;
            case 'answered':
              d = '<span class="label label-warning">answered</span>';
              break;
            case 'scored':
              d = '<span class="label label-success">scored</span>';
              break;
          }
          $('#activityTable').dataTable().fnAddData([
            a,
            b,
            c,
            d,
            e,
            f,
            action
          ]);
        }
      }
    });
  </script>

  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>

@endsection
