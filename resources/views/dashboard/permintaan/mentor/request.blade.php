@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - List Permintaan Mentor</title>
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
            <h4 class="page-title">List Permintaan Mentor</h4>
            <ol class="breadcrumb">
              <li>
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li>
                Permintaan Mentor
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
            <table class="table table-striped table-bordered" id="userTable">
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
            <div id="modal-accept" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Terima Permintaan User</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p for="field" class="control-label">Apakah anda yakin ingin menerima permintaan user untuk menjadi assessor?</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="accept_assessor_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, terima</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batalkan</button>
                  </div>
                </div>
              </div>
            </div>
            <div id="modal-decline" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Tolak Permintaan User</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p for="field" class="control-label">Apakah anda yakin ingin menolak permintaan user untuk menjadi assessor?</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="decline_assessor_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, tolak</button>
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
      $("#userTable").DataTable();
      var x = getCookie('token_login_user_gsm');

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/assessor/request-list",
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        myJsonData = data;
        populateDataTable(myJsonData);
      })

      function populateDataTable(data) {
        $("#userTable").DataTable().clear();
        var length = data.data.length;
        for (var i = 0; i < length; i++) {
          var a=data.data[i].name;
          if ('detail' in data.data[i]) {
            if ('position' in data.data[i].detail) {
              var b=data.data[i].detail.position;
            } else {
              var b="-";
            }
          } else {
            var b="-";
          }
          if ('schoolgsm' in data.data[i] && data.data[i].schoolgsm !== null) {
            if ('sekolah' in data.data[i].schoolgsm) {
              var c=data.data[i].schoolgsm.sekolah;
            } else {
              var c="-";
            }
            if ('kabupaten_kota' in data.data[i].schoolgsm) {
              var d=data.data[i].schoolgsm.kabupaten_kota;
            } else {
              var d="-";
            }
          } else {
            var c="-";
            var d="-";
          }
          if (data.data[i].schoolgsm.model_gsm.flag == 'model_gsm')
            e = '<span class="label label-success">Sekolah Model GSM</span>';
          else if (data.data[i].schoolgsm.model_gsm.flag == 'emodel_gsm')
            e = '<span class="label label-primary">Sekolah e-Model GSM</span>';
          else
            e = '<span class="label label-warning">Sekolah Jejaring GSM</span>';
          var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='{{ url('/dashboard/user/detail') }}?id="+data.data[i]._id+"'>Detail</a>"+
          "<a class='btn btn-success btn-xs waves-effect waves-light' href='#' onclick=accept_assessor('"+data.data[i]._id+"') data-toggle='modal' data-target='#modal-accept'>Accept</a>"+
          "<a class='btn btn-danger btn-xs waves-effect waves-light' href='#' onclick=decline_assessor('"+data.data[i]._id+"') data-toggle='modal' data-target='#modal-decline'>Decline</a>";
          $('#userTable').dataTable().fnAddData([
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
    function accept_assessor(id){
      document.getElementById('id_user').value = id;
    }

    function accept_assessor_confirmation(){
      var x = getCookie('token_login_user_gsm');
      var datas = { "confirmation" : "accept" }

      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/api/v1/admin/assessor/confirm/"+document.getElementById('id_user').value,
        data: datas,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Permintaan user untuk menjadi assessor diterima. \n\n Message: "+data.message,
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

    function decline_assessor(id){
      document.getElementById('id_user').value = id;
    }

    function decline_assessor_confirmation(){
      var x = getCookie('token_login_user_gsm');
      var datas = { "confirmation" : "decline" }

      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/api/v1/admin/assessor/confirm/"+document.getElementById('id_user').value,
        data: datas,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Permintaan user untuk menjadi assessor ditolak. \n\n Message: "+data.message,
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
