@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Modul Basic</title>
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
            <h4 class="page-title">List Modul Basic</h4>
            <ol class="breadcrumb">
              <li>
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li>
                Modul
              </li>
              <li class="active">
                Basic
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
            <table class="table table-striped table-bordered" id="modulBasicTable">
              <thead>
                <tr>
                  <th>Judul</th>
                  <th>Kategori</th>
                  <th>Deskripsi</th>
                  <th style="width:100px;">Actions</th>
                </tr>
              </thead>
            </table>
            <input type="text" id="id_modul" style="display:none">
            <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Delete Modul</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p for="field" class="control-label">Apakah anda yakin ingin menghapus modul ini?</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="delete_modul_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, hapus</button>
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
    $("#modulBasicTable").DataTable();
      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/modul/grade/basic"
      })
      .done(function(data, status){
        //console.log(data)
        console.log(status);
        myJsonData = data;
        populateDataTable(myJsonData);
      })

      function populateDataTable(data) {
        $("#modulBasicTable").DataTable().clear();
        var length = data.length;
        for (var i = 0; i < length; i++) {
          var a=data[i].title;
          var b=data[i].aspect;
          if (b == 'ekosistem-positif') b = 'Penciptaan Ekosistem Positif dan Etis';
          else if (b == 'trisentra-pendidikan') b = 'Panca Sentra Pendidikan';
          else if (b == 'pembelajaran-riset') b = 'Pembelajaran Kontekstual dan Partisipatif';
          else if (b == 'pengembangan-karakter') b = 'Pengembangan Karakter';
          var c=data[i].description;
          var fix_c = c.length > 200 ? c.substring(0, 200 - 3) + "..." : c;
          var action = "<a class='btn btn-warning btn-xs waves-effect waves-light' href='edit?id="+data[i]._id+"'> <i class='ti-write'></i> Edit</a>&nbsp&nbsp&nbsp"+"<a class='btn btn-danger btn-xs waves-effect waves-light' href='#' onclick=delete_modul('"+data[i]._id+"') data-toggle='modal' data-target='#con-close-modal'> <i class='ti-trash'></i> Delete</a>";
          $('#modulBasicTable').dataTable().fnAddData([
            a,
            b,
            fix_c,
            action
          ]);
        }
      }
    });
  </script>
  <script>
    function delete_modul(id){
      document.getElementById('id_modul').value = id;
    }

    function delete_modul_confirmation(){
      var x = getCookie('token_login_user_gsm');
      $.ajax({
        type: 'DELETE',
        url: "{{ url('/') }}/api/v1/admin/modul/"+document.getElementById('id_modul').value,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        //console.log(data);
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Modul berhasil dihapus. \n\n Message: "+data.message,
          type: "success"
        }, function(){
          window.location.reload();
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

  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>
@endsection
