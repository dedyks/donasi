@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Add Modul</title>
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
                  <h4 class="page-title">Review Quiz</h4>
                  <ol class="breadcrumb">
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="active">
                      Quiz
                    </li>
                  </ol>
                </div>
              </div>

              <div class="panel">
                  <div class="panel-body">
                      <div class="row">
                          <div class="col-sm-6">
                          </div>
                      </div>
                      <table class="table table-striped table-bordered" id="quizTable">
                          <thead>
                              <tr>
                                  <th>Nama User</th>
                                  <th>Kategori Modul</th>
                                  <th>Level Modul</th>
                                  <th>Judul Modul</th>
                                  <th>Tanggal Upload</th>
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
      $("#quizTable").DataTable();
      var appurl = localStorage.getItem("url_elearning_gsm")

      $.ajax({
        type: 'GET',
        url: appurl+"v1/admin/quiz/index",
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status)
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
        $("#quizTable").DataTable().clear();
        var length = data.data.length;
        for (var i = 0; i < length; i++) {
          var a=data.data[i].user.name;
          var b=data.data[i].modul.aspect;
          var c=data.data[i].modul.grade;
          var d=data.data[i].modul.title;
          var e=data.data[i].created_at;
          var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='quiz/review?id="+data.data[i]._id+"'> <i class='ti-new-window'></i> Review</a>";
          switch (b) {
            case 'trisentra-pendidikan':
              b = 'Tri Sentra Pendidikan';
              break;
            case 'ekosistem-positif':
              b = 'Penciptaan Ekosistem Positif di Sekolah';
              break;
            case 'pembelajaran-riset':
              b = 'Pembelajaran Berbasis Riset';
              break;
            case 'pengembangan-karakter':
              b = 'Pengembangan Karakter';
              break;
          }
          switch (c) {
            case 'basic':
              c = 'Basic';
              break;
            case 'advanced':
              c = 'Advanced';
              break;
          }
          $('#quizTable').dataTable().fnAddData([
            a,
            b,
            c,
            d,
            e,
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
