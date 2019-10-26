@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Buat Kupon Perubahan</title>
@endsection

@section('content')
  <div class="content-page">
      <div class="content">
          <div class="container">
  						<div class="row">
                  <div class="col-sm-12">
                      <h4 class="page-title">Buat Kupon Perubahan</h4>
                      <ol class="breadcrumb">
                          <li>
                            <a href="{{ url('/') }}">Home</a>
                          </li>
                          <li class="active">
                            Buat Kupon
                          </li>
                      </ol>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="card-box">
                          <div class="row">
                            <form name="add_kupon_form" id="add_kupon_form" enctype="multipart/form-data">
                              <div class="col-md-6">
                                  

                                  <div class="form-group">
                                      <label for="">Nama Kupon</label>
                                      <input type="text" class="form-control" id="coupon_title" name="coupon_title" placeholder="Nama Kupon" required>
                                  </div>

                                  <div class="form-group">
                                      <label for="">Kode Kupon</label>
                                      <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Kode Kupon" required>
                                  </div>

                                  
                              </div>
                              <div class="col-md-6">
                                {{-- Kategori Kupon --}}
                                <div class="form-group">
                                    <p> <b> Kategori Kupon</b></p>
                                        <div class="radio radio-info radio-inline">
                                            <input autocomplete="off" onclick="selectedKategori()" type="radio" id="inlineRadio1" value="date" name="radioInline">
                                            <label for="inlineRadio1"> Date </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input autocomplete="off" onclick="selectedKategori()" type="radio" id="inlineRadio2" value="kuota" name="radioInline">
                                            <label for="inlineRadio2"> Kuota </label>
                                        </div>
                                   
                                </div>
                               
                                {{-- Kuota --}}
                                <div class="form-group" id="kuotaView" style="display:none">
                                    <label for="">Kuota</label>
                                    <input type="text" class="form-control" id="coupon_quota" name="coupon_quota" placeholder="Masukan Kuota" required>
                                </div>
                                {{-- Tanggal --}}
                                <div class="form-group" id="rangeDate" style="display:none">
                                    
                                        <label for="">Date (Ex : 20-12-2019)</label>
                                        <input type="text" class="form-control" placeholder="dd-mm-yyyy" name="expired_date">
                                    </div>
                                  {{-- <div class="form-group">
                                      <label for="">Deskripsi Kupon</label>
                                      <textarea class="form-control" rows="5" id="deskripsi_kupon" name="deskripsi_kupon"></textarea>
                                  </div> --}}
                                 
                                  {{-- <div class="">
                                      <label for="">Gambar</label>
                                      <input type="file" class="form-control filestyle" data-buttonname="btn-white" id="image_0" name="image[]" placeholder="Masukkan Gambar">
                                  </div> --}}
                                  <div class="form-actions">

                                  </div>
                              </div>
                            </form>
                          </div>
                          <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6" style="margin-top:20px;text-align:right" >
                              <button class="btn btn-primary" id="add_kupon" onclick="add_kupon()">Buat Kupon</button>
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
    function selectedKategori(){
      // console.log(document.getElementsByName('radioInline').value)
      if(document.getElementById('inlineRadio1').checked){
        document.getElementById('rangeDate').style.display = "inline"
        document.getElementById('kuotaView').style.display = "none"
      }else{
        document.getElementById('rangeDate').style.display = "none"
        document.getElementById('kuotaView').style.display = "inline"
      }
      // if (document.getElementsByName('radioInline').value == "date") {
      //   console.log("Date Selected")
      // }else if(document.getElementsByName('radioInline').value == "kuota"){
      //   console.log("Kuota Selected")
      // }
    }
      function add_kupon(){
          var x = getCookie('token_login_user_gsm');
          var datas = new FormData(document.getElementById('add_kupon_form'));
          $.ajax({
              type: 'POST',
              url: "{{ url('/') }}/api/v1/admin/reg-coupon",
              // url: "{{ url('/') }}/api/v1/admin/kupon/create",
              processData: false,
              contentType: false,
              data: datas,
              headers: {"Authorization": "Bearer " + x}
          })
          .done(function(data, status){
            console.log(status)
            swal({
              title: "Selamat",
              text: "Kupon berhasil ditambahkan. \n\n Message: "+data.message,
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
  <script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('assets/pages/jquery.form-pickers.init.js')}}"></script>
  <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
  <script src="{{asset('assets/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
  <script src="{{asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
  <script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js')}}"></script>

@endsection
