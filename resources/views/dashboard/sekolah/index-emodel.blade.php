@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Sekolah</title>
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
            <h4 class="page-title">Sekolah e-Model GSM</h4>
            <ol class="breadcrumb">
              <li>
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li>
                Sekolah
              </li>
              <li class="active">
                e-Model GSM
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
            <table class="table table-striped table-bordered" id="sModelTable">
              <thead>
                <tr>
                  <th>NPSN</th>
                  <th>Nama</th>
                  <th>Kabupaten</th>
                  <th>Provinsi</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
            <input type="text" id="id_sekolah" style="display:none">
            <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Memperbarui Label Sekolah</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-10">
                        <div class="form-group">
                          <label for="">Label</label>
                          <select id="labelSekolah" class="selectpicker" data-live-search="true" data-style="btn-white" required>
                              <option disabled>Pilih Label</option>
                              <option value="jejaring_gsm">Sekolah Jejaring GSM</option>
                              <option value="model_gsm">Sekolah Model GSM</option>
                              <option value="emodel_gsm">Sekolah e-Model GSM</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="change_label_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Simpan</button>
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
      $("#sModelTable").DataTable();

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/sekolah/label/emodel_gsm",
      })
      .done(function(data, status){
        console.log(status);
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
        $("#sModelTable").DataTable().clear();
        var length = data.data.length;
        for (var i = 0; i < length; i++) {
          var a=data.data[i].npsn;
          var b=data.data[i].sekolah;
          var c=data.data[i].kabupaten_kota;
          var d=data.data[i].propinsi;
          var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='detail?id="+data.data[i]._id+"'> <i class='ti-new-window'></i> Detail</a>&nbsp&nbsp&nbsp"+"<a class='btn btn-warning btn-xs waves-effect waves-light' href='#' onclick=change_label('"+data.data[i]._id+"','"+data.data[i].model_gsm.flag+"') data-toggle='modal' data-target='#con-close-modal'> <i class='ti-write'></i> Label</a>";
          $('#sModelTable').dataTable().fnAddData([
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
    function change_label(id, labelSekolah){
      document.getElementById('id_sekolah').value = id;
      document.getElementById('labelSekolah').value = labelSekolah;
      $('.selectpicker').selectpicker('val', labelSekolah);
    }

    function change_label_confirmation(){
      var x = getCookie('token_login_user_gsm');
      var labelSekolah = document.getElementById('labelSekolah').value;
      var datas = { "label" : labelSekolah }

      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/api/v1/admin/sekolah/label/"+document.getElementById('id_sekolah').value,
        data: datas,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Sekolah ditambahkan sebagai '"+labelSekolah+"'. \n\n Message: "+data.message,
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
