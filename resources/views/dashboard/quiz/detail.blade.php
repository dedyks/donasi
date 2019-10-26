@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Detail Aktivitas</title>
@endsection

@section('content')
  <div class="content-page">
      <div class="content">
          <div class="container">
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="page-title">Detail Aktivitas</h4>
                  <ol class="breadcrumb">
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                      <a href="{{ url('/user') }}">User</a>
                    </li>
                    <li class="active">
                      Detail Aktivitas
                    </li>
                  </ol>
                </div>
              </div>

              <div class="panel panel-color panel-custom">
                <div class="panel-heading">
                  <h3 class="panel-title">Status Aktivitas User</h3>
                </div>
                <div class="panel-body">
                  <div class="col-sm-4">
                    <h5> <b>Status: </b> </h5>
                    <p class="text-muted m-b-15 font-13" id="statusActivity">
                      ...
                    </p>
                  </div>
                  <div class="col-sm-4">
                    <h5> <b>Tanggal mulai: </b> </h5>
                    <p class="text-muted m-b-15 font-13" id="startDate">
                        ...
                    </p>
                  </div>
                  <div class="col-sm-4">
                    <h5> <b>Tanggal selesai: </b> </h5>
                    <p class="text-muted m-b-15 font-13" id="endDate">
                        User belum menyelesaikan modul ini
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-color panel-custom">
                  <div class="panel-heading">
                    <h3 class="panel-title">Profil User</h3>
                  </div>
                  <div class="panel-body">
                      <div class="col-sm-3">
                        <img src="{{ asset('assets/images/avatar-3.png') }}" alt="image" class="img-responsive img-rounded" width="150" style="margin: auto">
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Nama:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="name">
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
                      </div>
                      <div class="col-sm-3">
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
                  <h3 class="panel-title">Modul</h3>
                </div>
                <div class="panel-body">
                  <div class="col-sm-4">
                    <h5><b>Kategori:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="aspect">
                        Kategori modul
                    </p>
                    <h5><b>Level:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="grade">
                        Level modul
                    </p>
                    <h5><b>Judul:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="title">
                        Judul modul
                    </p>
                  </div>
                  <div class="col-sm-8">
                    <h5><b>Deskripsi:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="description">
                        Deskripsi modul
                    </p>
                    <h5><b>Tantangan:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="task">
                        Tantangan modul
                    </p>
                  </div>
                </div>
              </div>
              <div class="panel panel-color panel-custom">
                <div class="panel-heading">
                  <h3 class="panel-title">Jawaban</h3>
                </div>
                <div class="panel-body">
                  <div class="col-sm-12">
                    <h5><b>Deskripsi Jawaban:</b></h5>
                    <p class="text-muted m-b-15 font-13" id="jawaban">
                        User belum memberikan jawaban untuk tantangan modul ini
                    </p>
                    <h5><b>Foto pendukung:</b></h5>
                    <div id="image-quiz">

                    </div>
                  </div>
                </div>
              </div>
              <div class="panel panel-color panel-custom">
                <div class="panel-heading">
                  <h3 class="panel-title">Evaluasi</h3>
                </div>
                <div class="panel-body">
                  <div class="col-sm-12">
                    <h5> <b>Evaluasi dari assessor: </b> </h5>
                    <p class="text-muted m-b-15 font-13" id="penilaian">
                        User belum mendapatkan evaluasi dari assessor
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
      var id_quiz = id.get("id");
      var appurl = localStorage.getItem("url_elearning_gsm")

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/quiz/"+id_quiz,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status)

        document.getElementById('startDate').innerHTML = data.data.created_at;

        document.getElementById('name').innerHTML = data.data.user.name;
        document.getElementById('school').innerHTML = data.data.user.schoolgsm_id;
        if ('detail' in data.data.user) {
          document.getElementById('position').innerHTML = data.data.user.detail.position;
          document.getElementById('phone').innerHTML = data.data.user.detail.phone;
        }
        document.getElementById('email').innerHTML = data.data.user.email;

        document.getElementById('aspect').innerHTML = data.data.modul.aspect;
        document.getElementById('grade').innerHTML = data.data.modul.grade;
        document.getElementById('title').innerHTML = data.data.modul.title;
        document.getElementById('description').innerHTML = data.data.modul.description;
        document.getElementById('task').innerHTML = data.data.modul.task;

        if (data.data.flag == 'scored'){
          document.getElementById('penilaian').innerHTML = data.data.penilaian;
          document.getElementById('jawaban').innerHTML = data.data.deskripsi;
          for (var i=0; i<data.data.image.length; i++) {
            $('#image-quiz').append(
              '<img id="preview" src="http://207.148.68.185/storage/images/'+data.data.image[i].filename+'" alt="'+data.data.image[i].filename+'" height="300px" width="auto">&nbsp&nbsp&nbsp'
            );
          }
          document.getElementById('statusActivity').innerHTML = '<span class="label label-success">SCORED</span><br>Assessor telah memberikan evaluasi';
          document.getElementById('endDate').innerHTML = data.data.updated_at;
        } else if (data.data.flag == 'answered'){
          document.getElementById('jawaban').innerHTML = data.data.deskripsi;
          for (var i=0; i<data.data.image.length; i++) {
            $('#image-quiz').append(
              '<img id="preview" src="http://207.148.68.185/storage/images/'+data.data.image[i].filename+'" alt="'+data.data.image[i].filename+'" height="300px" width="auto">&nbsp&nbsp&nbsp'
            );
          }
          document.getElementById('statusActivity').innerHTML = '<span class="label label-warning">ANSWERED</span><br>User menunggu evaluasi dari assessor';
        } else {
          document.getElementById('statusActivity').innerHTML = '<span class="label label-primary">ENROLLED</span><br>User sedang mempelajari modul ini';
        }

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
    });
  </script>
@endsection
