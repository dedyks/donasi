@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - List Rapor</title>
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
                  <h4 class="page-title">List Rapor</h4>
                  <ol class="breadcrumb">
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                      <a href="{{ url('/dashboard/rapor/sekolah') }}">Rapor Sekolah</a>
                    </li>
                    <li class="active">
                      List Rapor
                    </li>
                  </ol>
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
              <div class="panel panel-color panel-custom">
                <div class="panel-heading">
                  <h3 class="panel-title">Rapor Sekolah</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <button class="btn btn-primary" id="createRapor" onclick=createRapor()> <i class="md md-add-circle-outline"></i> <span>Create Rapor Sekolah</span></button>
                    </div>
                  </div>
                  <div class="row">
                    &nbsp
                  </div>
                  <table class="table table-striped" id="lRaporSekolahTable">
                    <thead>
                      <tr>
                        <th>Judul</th>
                        <th>Dibuat Oleh</th>
                        <th>Tanggal Diperbarui</th>
                        <th>Tanggal Dibuat</th>
                        <th style="width:150px">Action</th>
                      </tr>
                    </thead>
                  </table>
                  <input type="text" id="id_rapor" style="display:none">
                  <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-md">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                          <h4 class="modal-title">Menghapus Rapor</h4>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <p for="field" class="control-label">Apakah anda yakin ingin menghapus rapor ini?</p>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" onclick="delete_rapor_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, hapus</button>
                          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batalkan</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="panel panel-color panel-custom">
                <div class="panel-heading">
                  <h3 class="panel-title">Rapor User Terkait</h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                      <div class="col-sm-6">
                      </div>
                  </div>
                  <table class="table table-striped" id="lRaporUserTable">
                    <thead>
                      <tr>
                        <th>Judul</th>
                        <th>Nama User</th>
                        <th>Nama Mentor</th>
                        <th>Tanggal Diperbarui</th>
                        <th>Tanggal Dibuat</th>
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

      var id = new URLSearchParams(document.location.search.substring(1));
      var id_sekolah = id.get("id");
      $("#lRaporSekolahTable").DataTable();
      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/sekolah/"+id_sekolah,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status)

        document.getElementById('sekolah').innerHTML = data.data.sekolah;
        document.getElementById('bentuk').innerHTML = data.data.bentuk;
        if (data.data.status == 'N')
          document.getElementById('status').innerHTML = 'Negeri';
        else
          document.getElementById('status').innerHTML = 'Swasta';
        document.getElementById('npsn').innerHTML = data.data.npsn;
        document.getElementById('alamat_jalan').innerHTML = data.data.alamat_jalan;
        document.getElementById('kecamatan').innerHTML = data.data.kecamatan;
        document.getElementById('kabupaten_kota').innerHTML = data.data.kabupaten_kota;
        document.getElementById('propinsi').innerHTML = data.data.propinsi;
        if (data.data.model_gsm.flag == 'model_gsm')
          document.getElementById('label_gsm').innerHTML = '<span class="label label-success">Sekolah Model GSM</span>';
        else if (data.data.model_gsm.flag == 'emodel_gsm')
          document.getElementById('label_gsm').innerHTML = '<span class="label label-primary">Sekolah e-Model GSM</span>';
        else
          document.getElementById('label_gsm').innerHTML = '<span class="label label-warning">Sekolah Jejaring GSM</span>';
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

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/rapor/sekolah/"+id_sekolah,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        myJsonData = data;
        populateDataTable(myJsonData);
      })

      function populateDataTable(data) {
        $("#lRaporSekolahTable").DataTable().clear();
        var length = data.data.length;
        for (var i = 0; i < length; i++) {
          var a=data.data[i].judul;
          var b=data.data[i].assessor.name;
          var c=data.data[i].updated_at;
          var d=data.data[i].created_at;
          var action = "<a class='btn btn-warning btn-xs waves-effect waves-light' href='{{ url("/dashboard/rapor/sekolah/list-rapor/detail-rapor-sekolah") }}?id="+data.data[i]._id+"'> <i class='ti-new-window'></i> Update</a>&nbsp&nbsp&nbsp"+"<a class='btn btn-danger btn-xs waves-effect waves-light' href='#' onclick=delete_rapor('"+data.data[i]._id+"') data-toggle='modal' data-target='#con-close-modal'> <i class='ti-trash'></i> Delete</a>";
          $('#lRaporSekolahTable').dataTable().fnAddData([
            a,
            b,
            c,
            d,
            action
          ]);
        }
      }

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/rapor/by-sekolah/"+id_sekolah,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        myJsonData = data;
        populateDataTable2(myJsonData);
      })

      function populateDataTable2(data){
        $("#lRaporUserTable").DataTable().clear();
        var length = data.data.length;
        for (var i = 0; i < length; i++) {
          var a=data.data[i].judul;
          var b=data.data[i].user.name;
          var c=data.data[i].assessor.name;
          var d=data.data[i].updated_at;
          var e=data.data[i].created_at;
          var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='{{ url("/dashboard/rapor/sekolah/list-rapor/detail-rapor-user") }}?id="+data.data[i]._id+"'> <i class='ti-new-window'></i> Detail</a>&nbsp&nbsp&nbsp";
          $('#lRaporUserTable').dataTable().fnAddData([
            a,
            b,
            c,
            d,
            e,
            action
          ]);
        }
      }
    })
  </script>
  <script>
    function delete_rapor(id){
      document.getElementById('id_rapor').value = id;
    }

    function delete_rapor_confirmation(){
      var x = getCookie('token_login_user_gsm');

      $.ajax({
        type: 'DELETE',
        url: "{{ url('/') }}/api/v1/admin/rapor/id/"+document.getElementById('id_rapor').value,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Rapor berhasil dihapus. \n\n Message: "+data.message,
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

    function createRapor(){
      var id = new URLSearchParams(document.location.search.substring(1));
      var id_sekolah = id.get("id");
      window.location.href = "{{ url('/dashboard/rapor/sekolah/create') }}?id="+id_sekolah;
    }
  </script>

  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>

@endsection
