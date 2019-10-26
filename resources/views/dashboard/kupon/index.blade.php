@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Kupon</title>
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
            <h4 class="page-title">List Kupon Perubahan</h4>
            <ol class="breadcrumb">
              <li>
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li class="active">
                Kupon Perubahan
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
            <table class="table table-striped table-bordered" id="kuponTable">
              <thead>
                <tr>
                  <th>Kode Kupon</th>
                  <th>Nama Kupon</th>
                  <th>Kuota Kupon</th>
                  <th>Kuota Digunakan</th>
                  <th>Expired</th>
                  <th>Action</th>
                </tr>
              </thead>
            </table>
            <input type="text" id="id_kupon" style="display:none">
            <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Menghapus Kupon</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p for="field" class="control-label">Apakah anda yakin ingin menghapus kupon ini?</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="delete_kupon_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, hapus</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batalkan</button>
                  </div>
                </div>
              </div>
            </div>
            {{-- <div id="update-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Memperbarui Kupon</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <form id="update_kupon_form" enctype="multipart/form-data">
                          <div class="form-group">
                            <label for="" class="col-form-label">Kode Kupon</label>
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code" disabled>
                          </div>
                          <div class="form-group">
                            <label for="" class="col-form-label">Nama Kupon</label>
                            <input type="text" class="form-control" id="coupon_title" name="coupon_title">
                          </div>
                          <div class="form-group">
                            <label for="" class="col-form-label">Kuota</label>
                            <textarea class="form-control" rows="5" id="coupon_quota" name="coupon_quota"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="" class="col-form-label">Expired</label>
                             <input type="file" class="form-control filestyle" data-buttonname="btn-white" id="image_0" name="image[]" placeholder="Tambahkan Gambar"> 
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="update_kupon_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, perbarui</button>
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Batalkan</button>
                  </div>
                </div>
              </div>
            </div> --}}
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
      $("#kuponTable").DataTable();
      var appurl = localStorage.getItem("url_elearning_gsm")
      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/reg-coupon",
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        myJsonData = data;
        populateDataTable(myJsonData);
      })

      function populateDataTable(data) {
        $("#kuponTable").DataTable().clear();
        var length = data.data.length;
        for (var i = 0; i < length; i++) {
          var a = data.data[i].coupon_code;
          var b = data.data[i].coupon_title;
          var c = data.data[i].coupon_quota
          var d = data.data[i].coupon_used
          // var c='-';
          // if (data.data[i].deskripsi_kupon){
          //   c=data.data[i].deskripsi_kupon;
          //   if (c.length > 40){
          //     c = c.substring(0, 40 - 3) + "...";
          //   }
          // }
          var e=data.data[i].expired_date;
          // var action = "<a class='btn btn-warning btn-xs waves-effect waves-light' href='#' onclick=update_kupon('"+data.data[i]._id+"','"+data.data[i].kode_kupon+"','"+encodeURIComponent(data.data[i].nama_training)+"','"+encodeURIComponent(data.data[i].deskripsi_kupon)+"') data-toggle='modal' data-target='#update-modal'> <i class='ti-pencil-alt'></i> Update</a>&nbsp&nbsp&nbsp"+"<a class='btn btn-danger btn-xs waves-effect waves-light' href='#' onclick=delete_kupon('"+data.data[i]._id+"') data-toggle='modal' data-target='#con-close-modal'> <i class='ti-trash'></i> Delete</a>";

          var action = "<a class='btn btn-danger btn-xs waves-effect waves-light' href='#' onclick=delete_kupon('"+data.data[i]._id+"') data-toggle='modal' data-target='#con-close-modal'> <i class='ti-trash'></i> Delete</a>";
          $('#kuponTable').dataTable().fnAddData([
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
    // function update_kupon(id, kode_kupon, nama_training, deskripsi_kupon){
    //   document.getElementById('id_kupon').value = id;
    //   document.getElementById('kode_kupon').value = kode_kupon;
    //   document.getElementById('nama_training').value = decodeURIComponent(nama_training);
    //   document.getElementById('deskripsi_kupon').value = decodeURIComponent(deskripsi_kupon);
    // }

    function update_kupon_confirmation(){
      var x = getCookie('token_login_user_gsm');
      var datas = new FormData(document.getElementById('update_kupon_form'));
      console.log(datas);

      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/api/v1/admin/kupon/"+document.getElementById('id_kupon').value,
        processData: false,
        contentType: false,
        data: datas,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Kupon berhasil diperbarui. \n\n Message: "+data.message,
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

    function delete_kupon(id){
      document.getElementById('id_kupon').value = id;
    }

    function delete_kupon_confirmation(){
      var x = getCookie('token_login_user_gsm');

      $.ajax({
        type: 'DELETE',
        url: "{{ url('/') }}/api/v1/admin/reg-coupon/"+document.getElementById('id_kupon').value,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Kupon berhasil dihapus. \n\n Message: "+data.message,
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
