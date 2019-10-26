@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Assessor</title>
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
            <h4 class="page-title">List Assessor</h4>
            <ol class="breadcrumb">
              <li>
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li class="active">
                Assessor
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
            <table class="table table-striped table-bordered" id="assessorTable">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Sekolah</th>
                  <th>Kabupaten</th>
                  <th>Label GSM</th>
                  <th>Actions</th>
                </tr>
              </thead>
            </table>
            <input type="text" id="id_user" style="display:none">
            <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Hapus dari Assessor</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p for="field" class="control-label">Apakah anda yakin ingin menghapus user ini dari assessor?</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="remove_assessor_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, hapus</button>
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
      $("#assessorTable").DataTable();
      var appurl = localStorage.getItem("url_elearning_gsm")
      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/user/role/assessor",
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        myJsonData = data;
        populateDataTable(myJsonData);
      })

      function populateDataTable(data) {
        $("#assessorTable").DataTable().clear();
        var length = data.length;
        for (var i = 0; i < length; i++) {
          var a=data[i].name;
          if ('detail' in data[i]) {
            if ('position' in data[i].detail) {
              var b=data[i].detail.position;
            } else {
              var b="-";
            }
          } else {
            var b="-";
          }
          if ('schoolgsm' in data[i] && data[i].schoolgsm !== null) {
            if ('sekolah' in data[i].schoolgsm) {
              var c=data[i].schoolgsm.sekolah;
            } else {
              var c="-";
            }
            if ('kabupaten_kota' in data[i].schoolgsm) {
              var d=data[i].schoolgsm.kabupaten_kota;
            } else {
              var d="-";
            }
          } else {
            var c="-";
            var d="-";
          }
          if (data[i].schoolgsm.model_gsm.flag == 'model_gsm')
            e = '<span class="label label-success">Sekolah Model GSM</span>';
          else if (data[i].schoolgsm.model_gsm.flag == 'emodel_gsm')
            e = '<span class="label label-primary">Sekolah e-Model GSM</span>';
          else
            e = '<span class="label label-warning">Sekolah Jejaring GSM</span>';
          var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='user/detail?id="+data[i]._id+"'> <i class='ti-new-window'></i> Detail</a>&nbsp&nbsp&nbsp"+"<a class='btn btn-danger btn-xs waves-effect waves-light' href='#' onclick=remove_assessor('"+data[i]._id+"') data-toggle='modal' data-target='#con-close-modal'> <i class='ti-trash'></i> Remove</a>";
          $('#assessorTable').dataTable().fnAddData([
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
  <script>
    function remove_assessor(id){
      document.getElementById('id_user').value = id;
    }

    function remove_assessor_confirmation(){
      var x = getCookie('token_login_user_gsm');
      var datas = { "role" : "user" }
      
      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/api/v1/admin/user/role/"+document.getElementById('id_user').value,
        data: datas,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "User dihapus dari assessor. \n\n Message: "+data.message,
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
