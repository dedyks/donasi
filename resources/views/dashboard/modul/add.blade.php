@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Buat Modul Materi</title>
@endsection

@section('content')
  <div class="content-page">
      <div class="content">
          <div class="container">
  						<div class="row">
                  <div class="col-sm-12">
                      <h4 class="page-title">Buat Modul Materi</h4>
                      <ol class="breadcrumb">
                          <li>
                            <a href="{{ url('/') }}">Home</a>
                          </li>
                          <li class="active">
                            Buat Modul
                          </li>
                      </ol>
                  </div>
              </div>
              <div class="row">
                  <div class="col-sm-12">
                      <div class="card-box">
                          <div class="row">
                            <form name="upload_modul_form" id="upload_modul_form" enctype="multipart/form-data">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">Jenis Modul</label>
                                      <select name="flag" class="selectpicker" data-live-search="true" data-style="btn-white" required>
                                          <option value="-" selected disabled>Pilih Jenis</option>
                                          <option value="-">Biasa</option>
                                          <option value="spesial">Spesial</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="">Kategori Modul</label>
                                      <select name="aspect" class="selectpicker" data-live-search="true" data-style="btn-white" required>
                                          <option selected disabled>Pilih Kategori</option>
                                          <option value="ekosistem-positif">Penciptaan Ekosistem Positif di Sekolah</option>
                                          <option value="pembelajaran-riset">Pembelajaran Berbasis Riset</option>
                                          <option value="pengembangan-karakter">Pengembangan Karakter</option>
                                          <option value="trisentra-pendidikan">Tri Sentra Pendidikan</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="">Level Modul</label>
                                      <select name="grade" class="selectpicker" data-live-search="true" data-style="btn-white" required>
                                          <option selected disabled>Pilih Level</option>
                                          <option value="basic">Basic</option>
                                          <option value="advanced">Advanced</option>
                                      </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="">Tingkat Sekolah</label>
                                    <select name="level" class="selectpicker" data-live-search="true" data-style="btn-white" required>
                                        <option selected disabled>Pilih Level</option>
                                        <option  value="SD">SD</option>
                                        <option  value="SD">MI</option>
                                        <option  value="SMP">SMP</option>
                                        <option  value="SMP">MTs</option>
                                        <option  value="SMA">SMA</option>
                                        <option  value="SMA">SMK</option>
                                        <option  value="SMA">MA</option>
                                        <option  value="SMA">MAK</option>
                                     </select>
                                </div>
                                  <div class="form-group">
                                      <label for="">Judul Modul</label>
                                      <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan Judul Modul" required>
                                  </div>

                                  <div class="form-group">
                                      <label for="">Deskripsi Modul</label>
                                      <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                                  </div>
                                  <div class="form-group">
                                      <label for="">Tantangan</label>
                                      <textarea class="form-control" rows="5" id="task" name="task"></textarea>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="">Upload URL Video</label>
                                      <input type="text" class="form-control" id="video_0" name="video[]" placeholder="Masukan URL Video">
                                      <div id="field_url_video" >

                                      </div>
                                      <div style="text-align:right;" class="col-md-12">
                                        <button id="add_video" style="margin-top:10px" name="add_video" class="btn btn-purple waves-effect waves-light" >Add</button>
                                        <hr>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="">Upload URL Dokumen</label>
                                      <input type="text" class="form-control" id="document_0" name="document[]" placeholder="Masukkan URL Dokumen">
                                      <div id="field_url_document">

                                      </div>
                                      <div style="text-align:right;" class="col-md-12">
                                        <button id="add_document" style="margin-top:10px" name="add_document" class="btn btn-purple waves-effect waves-light" >Add</button>
                                        <hr>
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      <label for="">Upload Gambar</label>
                                      <input type="file" class="form-control filestyle" data-buttonname="btn-white" id="image_0" name="image[]" placeholder="Masukkan Gambar">
                                      <div id="field_url_image">

                                      </div>
                                      <div style="text-align:right;" class="col-md-12">
                                        <button id="add_image" style="margin-top:10px" name="add_image" class="btn btn-purple waves-effect waves-light" >Add</button>
                                        <hr>
                                      </div>
                                  </div>
                                  <div class="form-actions">

                                  </div>
                              </div>
                            </form>
                          </div>
                          <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                              <button class="btn btn-primary" id="upload_modul" onclick="upload_modul()">Upload Modul</button>
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
        $('#add_video').click(function(event ){
            event.preventDefault();
            var row = document.getElementsByName('video[]').length;
            console.log(row);
            $('#field_url_video').append(
                '<div style="margin-left:-10px;margin-top:10px;margin-bot:10px" id="row'+row+'" class="col-md-12">'+
                '<input type="text" class="form-control" id="video_0" name="video[]" placeholder="Masukkan URL Video">'+
                '<button  style="display:inline;margin-top:10px;" name="remove" id="'+row+'" class="btn btn-danger btn_remove">Delete</button>'+
                '</div>'
            );
        });

        $(document).on('click', '.btn_remove', function(){
            var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
        });

        $('#add_document').click(function(event ){
            event.preventDefault();
            var row = document.getElementsByName('document[]').length;
            console.log(row);
            $('#field_url_document').append(
                '<div style="margin-left:-10px;margin-top:10px;margin-bot:10px" id="row_document'+row+'" class="col-md-12">'+
                '<input type="text" class="form-control" id="document_0" name="document[]" placeholder="Masukkan URL Dokumen">'+
                '<button  style="display:inline;margin-top:10px;" name="remove" id="'+row+'" class="btn btn-danger btn_remove2">Delete</button>'+
                '</div>'
            );
        });

        $(document).on('click', '.btn_remove2', function(){
            var button_id = $(this).attr("id");
            $('#row_document'+button_id+'').remove();
        });

        $('#add_image').click(function(event ){
            event.preventDefault();
            var row = document.getElementsByName('image[]').length;
            console.log(row);
            $('#field_url_image').append(
                '<div style="margin-left:-10px;margin-top:10px;margin-bot:10px" id="row_image'+row+'" class="col-md-12">'+
                '<input type="file" class="form-control filestyle" data-buttonname="btn-white" id="image_0" name="image[]" placeholder="Masukkan Gambar">'+
                '<button  style="display:inline;margin-top:10px;" name="remove" id="'+row+'" class="btn btn-danger btn_remove3">Delete</button>'+
                '</div>'
            );
        });

        $(document).on('click', '.btn_remove3', function(){
            var button_id = $(this).attr("id");
            $('#row_image'+button_id+'').remove();
        });
    });
  </script>
  <script>
      function upload_modul(){
          var x = getCookie('token_login_user_gsm');
          var appurl = localStorage.getItem("url_elearning_gsm")
          var datas = new FormData(document.getElementById('upload_modul_form'));

          $.ajax({
              type: 'POST',
              url: "{{ url('/') }}/api/v1/admin/modul/create",
              processData: false,
              contentType: false,
              data: datas,
              headers: {"Authorization": "Bearer " + x}
          })
          .done(function(data, status){
            console.log(status)
            swal({
              title: "Selamat",
              text: "Modul berhasil ditambahkan. \n\n Message: "+data.message,
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
@endsection
