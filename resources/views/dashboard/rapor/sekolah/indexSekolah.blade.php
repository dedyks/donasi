@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Rapor Sekolah</title>
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
            <h4 class="page-title">Rapor Sekolah</h4>
            <ol class="breadcrumb">
              <li>
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li class="active">
                Rapor Sekolah
              </li>
            </ol>
          </div>
        </div>
        <div class="panel">
          <div class="panel-body">
            <div class="row">
              <form class="form-horizontal">
                <div class="col-sm-4">
                  <div class="form-group">
                    <div class="col-xs-12">
                      <p>Pilih Sekolah</p>
                      <select id="sekolah_label_select" data-style="btn-white" class="selectpicker">
                        <option value="" selected disabled>Please select</option>
                        <option value="model_gsm">Sekolah Model GSM</option>
                        <option value="emodel_gsm">Sekolah e-Model GSM</option>
                        <option value="jejaring_gsm">Sekolah Jejaring GSM</option>
                      </select>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <table class="table table-striped table-bordered" id="raporSekolahTable">
              <thead>
                <tr>
                  <th>NPSN</th>
                  <th>Sekolah</th>
                  <th>Kabupaten</th>
                  <th>Provinsi</th>
                  <th style="width:150px;">Actions</th>
                </tr>
              </thead>
            </table>
            <input type="text" id="id_sekolah" style="display:none">
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script>
    $(document).ready(function(){
      $("#sekolah_label_select").change(function() {
        $("#raporSekolahTable").DataTable();
        $.ajax({
          type: 'GET',
          url: "{{ url('/') }}/api/v1/sekolah/label/"+document.getElementById('sekolah_label_select').value,
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
          $("#raporSekolahTable").DataTable().clear();
          var length = data.data.length;
          for (var i = 0; i < length; i++) {
            var a=data.data[i].npsn;
            var b=data.data[i].sekolah;
            var c=data.data[i].kabupaten_kota;
            var d=data.data[i].propinsi;
            var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='{{ url("/dashboard/rapor/sekolah/list-rapor") }}?id="+data.data[i]._id+"'> <i class='ti-bookmark-alt'></i> Lihat Rapor</a>";
            $('#raporSekolahTable').dataTable().fnAddData([
              a,
              b,
              c,
              d,
              action
            ]);
          }
        }
      })
    });
  </script>

  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>
@endsection
