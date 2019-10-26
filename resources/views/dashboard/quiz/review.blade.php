@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Review Quiz</title>
@endsection

@section('content')
  <div class="content-page">
      <div class="content">
          <div class="container">
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="page-title">Review Quiz</h4>
                  <ol class="breadcrumb">
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                      <a href="{{ url('/quiz') }}">Quiz</a>
                    </li>
                    <li class="active">
                      Review
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
                        <img src="{{ asset('assets/images/avatar-3.png') }}" alt="image" class="img-responsive img-rounded" width="150" style="margin: auto">
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Nama:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="name">
                            Nama pengguna
                        </p>
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Asal Sekolah:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="school">
                            Sekolah asal
                        </p>
                        <h5><b>Jabatan:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="position">
                            Jabatan di sekolah
                        </p>
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Email:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="email">
                            Email pengguna
                        </p>
                        <h5><b>No. HP (WA):</b></h5>
                        <p class="text-muted m-b-15 font-13" id="phone">
                            Nomor HP (WA)
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
                        Deskripsi jawaban dari pengguna
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
                    <form name="feedback_form" id="feedback_form">
                      <h5> <b>Berikan status evaluasi kepada user: </b> </h5>
                      <select name="status" id="status" class="selectpicker" data-live-search="true" data-style="btn-white" required>
                        <option selected disabled>Pilih Status</option>
                        <option value="revisi">Revisi</option>
                        <option value="lulus">Lulus</option>
                      </select>
                      <h5> <b>Berikan evaluasi kepada user: </b> </h5>
                      <textarea class="form-control" rows="5" id="penilaian" name="penilaian"></textarea>
                    </form>
                    <br>
                    <div align="right">
                      <button style="text-align: right" class="btn btn-primary" data-toggle='modal' data-target='#con-close-modal'>Submit</button>
                    </div>
                  </div>
                  <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h4 class="modal-title">Confirmation</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <p for="field" class="control-label">Apakah anda sudah memeriksa kembali evaluasi yang akan dikirimkan kepada user?</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" onclick="send_feedback()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, lanjutkan</button>
                          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batalkan</button>
                        </div>
                      </div>
                    </div>
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
        url: appurl+"v1/admin/quiz/"+id_quiz,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status)

        document.getElementById('name').innerHTML = data.data.user.name;
        document.getElementById('school').innerHTML = data.data.sekolah.sekolah;
        document.getElementById('position').innerHTML = data.data.user.detail.position;
        document.getElementById('email').innerHTML = data.data.user.email;
        document.getElementById('phone').innerHTML = data.data.user.detail.phone;

        document.getElementById('aspect').innerHTML = data.data.modul.aspect;
        document.getElementById('grade').innerHTML = data.data.modul.grade;
        document.getElementById('title').innerHTML = data.data.modul.title;
        document.getElementById('description').innerHTML = data.data.modul.description;
        document.getElementById('task').innerHTML = data.data.modul.task;

        document.getElementById('jawaban').innerHTML = data.data.deskripsi;
        for (var i=0; i<data.data.image.length; i++) {
          $('#image-quiz').append(
            '<img id="preview" src="http://207.148.68.185/storage/images/'+data.data.image[i].filename+'" alt="'+data.data.image[i].filename+'" height="300px" width="auto">&nbsp&nbsp&nbsp'
          );
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
  <script>
    function send_feedback(){
      var x = getCookie('token_login_user_gsm');

      var id = new URLSearchParams(document.location.search.substring(1));
      var id_quiz = id.get("id");

      var datas = new FormData(document.getElementById('feedback_form'));
      var appurl = localStorage.getItem("url_elearning_gsm")
      $.ajax({
        type: 'POST',
        url: appurl+"v1/admin/quiz/"+id_quiz,
        processData: false,
        contentType: false,
        data: datas,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Evaluasi telah dikirimkan ke user. \n\n Message: "+data.message,
          type: "success"
        }, function(){
          window.location = '/elearning/public/dashboard/quiz';
        });
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
    }
  </script>
@endsection
