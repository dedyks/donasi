@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - List Permintaan Sekolah Model GSM</title>
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
            <h4 class="page-title">List Permintaan Sekolah Model GSM</h4>
            <ol class="breadcrumb">
              <li>
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li>
                Permintaan Sekolah Model GSM
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
            <table class="table table-striped table-bordered" id="sekolahTable">
              <thead>
                <tr>
                  <th>Kepala Sekolah</th>
                  <th>Sekolah</th>
                  <th>Kabupaten</th>
                  <th>Label GSM</th>
                  <th>Actions</th>
                </tr>
              </thead>
            </table>
            <input type="text" id="id_sekolah" style="display:none">
            <div id="modal-accept" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Terima Permintaan Sekolah</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p for="field" class="control-label">Apakah anda yakin ingin menerima permintaan sekolah ini untuk menjadi Sekolah Model GSM?</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="accept_sekolah_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, terima</button>
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
                    <h4 class="modal-title">Tolak Permintaan Sekolah</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p for="field" class="control-label">Apakah anda yakin ingin menolak permintaan sekolah ini untuk menjadi Sekolah Model GSM?</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="decline_sekolah_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, tolak</button>
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
      $("#sekolahTable").DataTable();
      var x = getCookie('token_login_user_gsm');

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/sekolah/request-list",
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        myJsonData = data;
        populateDataTable(myJsonData);
      })

      function populateDataTable(data) {
        $("#sekolahTable").DataTable().clear();
        var length = data.data.length;
        for (var i = 0; i < length; i++) {
          a = data.data[i].name;
          b = data.data[i].schoolgsm.sekolah;
          c = data.data[i].schoolgsm.kabupaten_kota;
          if (data.data[i].schoolgsm.model_gsm.flag == 'model_gsm')
            d = '<span class="label label-success">Sekolah Model GSM</span>';
          else if (data.data[i].schoolgsm.model_gsm.flag == 'emodel_gsm')
            d = '<span class="label label-primary">Sekolah e-Model GSM</span>';
          else
            d = '<span class="label label-warning">Sekolah Jejaring GSM</span>';
          var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='{{ url('/dashboard/sekolah/detail') }}?id="+data.data[i].schoolgsm._id+"'>Detail</a>"+
          "<a class='btn btn-success btn-xs waves-effect waves-light' href='#' onclick=accept_sekolah('"+data.data[i]._id+"') data-toggle='modal' data-target='#modal-accept'>Accept</a>"+
          "<a class='btn btn-danger btn-xs waves-effect waves-light' href='#' onclick=decline_sekolah('"+data.data[i]._id+"') data-toggle='modal' data-target='#modal-decline'>Decline</a>";
          $('#sekolahTable').dataTable().fnAddData([
            a,
            b,
            c,
            d,
            action
          ]);
        }
      }
    });
  </script>
  <script>
    function accept_sekolah(id){
      document.getElementById('id_sekolah').value = id;
    }

    function accept_sekolah_confirmation(){
      var x = getCookie('token_login_user_gsm');
      var datas = { "confirmation" : "accept" }

      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/api/v1/admin/sekolah/confirm/"+document.getElementById('id_sekolah').value,
        data: datas,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Permintaan sekolah untuk menjadi Sekolah Model GSM diterima. \n\n Message: "+data.message,
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

    function decline_sekolah(id){
      document.getElementById('id_sekolah').value = id;
    }

    function decline_sekolah_confirmation(){
      var x = getCookie('token_login_user_gsm');
      var datas = { "confirmation" : "decline" }

      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/api/v1/admin/sekolah/confirm/"+document.getElementById('id_sekolah').value,
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
