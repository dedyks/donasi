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
            <h4 class="page-title">Sekolah di Indonesia</h4>
            <ol class="breadcrumb">
              <li>
                <a href="{{ url('/') }}">Home</a>
              </li>
              <li>
                Sekolah
              </li>
              <li class="active">
                Indonesia
              </li>
            </ol>
          </div>
        </div>
        <div class="panel">
          <div class="panel-body">
            <div class="row">
              <form class="form-horizontal">
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="col-xs-12">
                      <p>Pilih Kabupaten/Kota</p>
                      <select name="kabupaten_kota[]" id="kabupaten_kota_select" data-live-search="true" data-style="btn-white" class="selectpicker">
                        <option value="" selected disabled>Please select</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="col-xs-12">
                      <p>Pilih Jenis Sekolah</p>
                      <select name="jenis_sekolah" id="jenis_sekolah_select" data-live-search="true" data-style="btn-white" class="selectpicker">
                        <option value="" selected disabled>Please select</option>
                        <option  value="TK">TK</option>
                        <option  value="KB">KB</option>
                        <option  value="TPA">TPA</option>
                        <option  value="SPS">SPS</option>
                        <option  value="SD">SD</option>
                        <option  value="SMP">SMP</option>
                        <option  value="SDLB">SDLB</option>
                        <option  value="SMPLB">SMPLB</option>
                        <option  value="MI">MI</option>
                        <option  value="MTs">MTs</option>
                        <option  value="Paket A">Paket A</option>
                        <option  value="Paket B">Paket B</option>
                        <option  value="SMA">SMA</option>
                        <option  value="SMLB">SMLB</option>
                        <option  value="SMK">SMK</option>
                        <option  value="MA">MA</option>
                        <option  value="MAK">MAK</option>
                        <option  value="Paket C">Paket C</option>
                        <option  value="Akademik">Akademik</option>
                        <option  value="Politeknik">Politeknik</option>
                        <option  value="Sekolah Tinggi">Sekolah Tinggi</option>
                        <option  value="Institut">Institut</option>
                        <option  value="Universitas">Universitas</option>
                        <option  value="SLB">SLB</option>
                        <option  value="Kursus">Kursus</option>
                        <option  value="Keaksaraan">Keaksaraan</option>
                        <option  value="TBM">TBM</option>
                        <option  value="PKBM">PKBM</option>
                        <option  value="Life Skill">Life Skill</option>
                        <option  value="Satap TK SD">Satap TK SD</option>
                        <option  value="Satap SD SMP">Satap SD SMP</option>
                        <option  value="Satap TK SD SMP">Satap TK SD SMP</option>
                        <option  value="Satap SD SMP SMA">Satap SD SMP SMA</option>
                        <option  value="RA">RA</option>
                        <option  value="SMP Terbuka">SMP Terbuka</option>
                        <option  value="SMPTK">SMPTK</option>
                        <option  value="SMTK">SMTK</option>
                        <option  value="SDTK">SDTK</option>
                        <option  value="SPK PG">SPK PG</option>
                        <option  value="SPK TK">SPK TK</option>
                        <option  value="SPK SD">SPK SD</option>
                        <option  value="SPK SMP">SPK SMP</option>
                        <option  value="SPK SMA">SPK SMA</option>
                        <option  value="Pondok Pesantren">Pondok Pesantren</option>
                        <option  value="SMAg.K">SMAg.K</option>
                        <option  value="SKB">SKB</option>
                        <option  value="Taman Seminari">Taman Seminari</option>
                        <option  value="TKLB">TKLB</option>
                        <option  value="Pratama W P">Pratama W P</option>
                        <option  value="Adi W P">Adi W P</option>
                        <option  value="Madyama W P">Madyama W P</option>
                        <option  value="Utama W P">Utama W P</option>
                        <option  value="SMAK">SMAK</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-3">
                  <div class="form-group">
                    <div class="col-xs-12">
                      <p>Pilih Sekolah</p>
                      <select name="sekolah[]" id="sekolah_select" data-live-search="true" data-style="btn-white" class="selectpicker">
                        <option value="" selected disabled>Please select</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="col-xs-12">
                    <p>&nbsp</p>
                    <a class="btn btn-primary waves-effect waves-light" href="#" data-toggle="modal" data-target="#con-close-modal">Tambahkan ke Database</a>
                  </div>
                </div>
              </form>
            </div>
            <hr style="margin-top: 0px">
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
                  <p class="text-muted m-b-15 font-13" id="nama_sekolah">
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
                </div>
                <input type="text" id="kode_kab_kota" style="display:none">
                <input type="text" id="kode_kec" style="display:none">
                <input type="text" id="lintang" style="display:none">
                <input type="text" id="bujur" style="display:none">
              </div>
            </div>
            <div class="panel panel-color panel-custom">
              <div class="panel-heading">
                <h3 class="panel-title">User di Sekolah Ini</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                    </div>
                </div>
                <table class="table table-striped table-bordered" id="sUserTable">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Jabatan</th>
                      <th>Role</th>
                      <th>Aktivitas</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <input type="text" id="npsn_sekolah" style="display:none">
            <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Tambahkan ke Database</h4>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <p for="field" class="control-label">Apakah anda yakin ingin menambahkan sekolah ini ke database?</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" onclick="add_sekolah_confirmation()" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Iya, tambahkan</button>
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

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/wilayahKabGet"
      })
      .done(function(data, status){
        console.log(status);
        data = JSON.parse(data);
        length = data.data.length;
        var kabupaten_kota = "";
        for (var i = 0; i < length; i++) {
          kabupaten_kota += '<option id ="'+data.data[i]["mst_kode_wilayah"]+'"'+ 'value="'+data.data[i]["nama"] +'"'+'>' +data.data[i]["nama"]+'</option>'
        }
        $("select[name='kabupaten_kota[]']").append(kabupaten_kota);
        $("select[name='kabupaten_kota[]']").selectpicker("refresh");
      })

      $("#kabupaten_kota_select").change(function() {
        var id = $(this).children(":selected").attr("id");
        var id_mst_kode_wilayah = id.replace(/\s/g, "")
        localStorage.setItem("id_mst_kode_wilayah", id_mst_kode_wilayah)
        var jenis_sekolah = document.getElementById('jenis_sekolah_select').value;

        if (jenis_sekolah !== 'null')
          listSekolah(id_mst_kode_wilayah, jenis_sekolah);
      });

      $("#jenis_sekolah_select").change(function() {
        var jenis_sekolah = $(this).children(":selected").attr("value");
        var id_mst_kode_wilayah = localStorage.getItem("id_mst_kode_wilayah");
        var daerah = document.getElementById('kabupaten_kota_select').value;

        if (daerah !== "") {
          listSekolah(id_mst_kode_wilayah, jenis_sekolah)
        } else {
          swal({
            title: "Maaf",
            text: "Pilih Kabupaten/Kota terlebih dahulu",
            type: "warning",
            allowOutsideClick: true
          })
          $("#jenis_sekolah").val("none");
        }

      })

      $("#sekolah_select").change(function(){
        document.getElementById('propinsi').innerHTML = $(this).children(":selected").attr("propinsi");
        document.getElementById('kode_kab_kota').value = $(this).children(":selected").attr("kode_kab_kota");
        document.getElementById('kabupaten_kota').innerHTML = $(this).children(":selected").attr("kabupaten_kota");
        document.getElementById('kode_kec').value = $(this).children(":selected").attr("kode_kec");
        document.getElementById('kecamatan').innerHTML = $(this).children(":selected").attr("kecamatan");
        document.getElementById('npsn').innerHTML = $(this).children(":selected").attr("npsn");
        document.getElementById('nama_sekolah').innerHTML = $(this).children(":selected").attr("value");
        document.getElementById('bentuk').innerHTML = $(this).children(":selected").attr("bentuk");
        if ($(this).children(":selected").attr("status") == 'S')
          document.getElementById('status').innerHTML = 'Swasta';
        else
          document.getElementById('status').innerHTML = 'Negeri';
        document.getElementById('alamat_jalan').innerHTML = $(this).children(":selected").attr("alamat_jalan");
        document.getElementById('lintang').value = $(this).children(":selected").attr("lintang");
        document.getElementById('bujur').value = $(this).children(":selected").attr("bujur");

        $("#sUserTable").DataTable();
        $.ajax({
          type: 'GET',
          url: "{{ url('/') }}/api/v1/sekolah/npsn/"+document.getElementById('npsn').innerHTML,
        })
        .done(function(data, status){
          console.log(status);
          if ('data' in data){
            myJsonData = data;
            populateDataTable(myJsonData);
          }
        })

        function populateDataTable(data) {
          $("#sUserTable").DataTable().clear();
          var length = data.data.user.length;
          for (var i = 0; i < length; i++) {
            var a=data.data.user[i].name;
            if ('detail' in data.data.user[i]) {
              if ('position' in data.data.user[i].detail) {
                var b=data.data.user[i].detail.position;
              } else {
                var b="-";
              }
            } else {
              var b="-";
            }
            if ('schoolgsm' in data.data.user[i] && data.data.user[i].schoolgsm !== null) {
              if ('sekolah' in data.data.user[i].schoolgsm) {
                var c=data.data.user[i].schoolgsm.sekolah;
              } else {
                var c="-";
              }
              if ('kabupaten_kota' in data.data.user[i].schoolgsm) {
                var d=data.data.user[i].schoolgsm.kabupaten_kota;
              } else {
                var d="-";
              }
            } else {
              var c="-";
              var d="-";
            }
            if ('role' in data.data.user[i]){
              var e=data.data.user[i].role;
            } else {
              var e="user";
            }
            var action = "<a class='btn btn-primary btn-xs waves-effect waves-light' href='user/detail?id="+data.data.user[i]._id+"'> <i class='ti-new-window'></i> Detail</a>&nbsp&nbsp&nbsp"+"<a class='btn btn-success btn-xs waves-effect waves-light' href='#' onclick=add_assessor('"+data.data.user[i]._id+"') data-toggle='modal' data-target='#con-close-modal'> <i class='ti-plus'></i> Assessor</a>";
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
    });
  </script>
  <script>
    function listSekolah(id, jenis_sekolah){
      $("#sIndonesiaTable").DataTable();
      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/detailSekolahGET?mst_kode_wilayah="+id+"&bentuk="+jenis_sekolah
      })
      .done(function(data, status){
        console.log(status);
        data = JSON.parse(data);
        var length = data.data.length;

        $("#sekolah_select")
        .find('option')
        .remove()
        $("#sekolah_select").selectpicker("refresh");

        var sekolah ="<option selected disabled>Please select</option>";
        for (var i = 0; i < length; i++) {
          sekolah += '<option id ="'+i+'"'+
          'value="'+data.data[i]["sekolah"] +'"'+
          'propinsi="'+data.data[i]["propinsi"]+'"'+
          'kode_kab_kota="'+data.data[i]["kode_kab_kota"]+'"'+
          'kabupaten_kota="'+data.data[i]["kabupaten_kota"]+'"'+
          'kode_kec="'+data.data[i]["kode_kec"]+'"'+
          'kecamatan="'+data.data[i]["kecamatan"]+'"'+
          'npsn="'+data.data[i]["npsn"]+'"'+
          'bentuk="'+data.data[i]["bentuk"]+'"'+
          'status="'+data.data[i]["status"]+'"'+
          'alamat_jalan="'+data.data[i]["alamat_jalan"]+'"'+
          'lintang="'+data.data[i]["lintang"]+'"'+
          'bujur="'+data.data[i]["bujur"]+'"'+
          '>' +data.data[i]["sekolah"]+
          '</option>'
        }
        $("select[name='sekolah[]']").append(sekolah);
        $("select[name='sekolah[]']").selectpicker("refresh");
      })
      .fail(function(data, status){
        console.log(status);
      })
    }
  </script>
  <script>
    function add_sekolah_confirmation(){
      var x = getCookie('token_login_user_gsm');
      if (document.getElementById('status').innerHTML == 'Swasta')
        document.getElementById('status').innerHTML = 'S';
      else
        document.getElementById('status').innerHTML = 'N';
      var datas = {
        "propinsi" : document.getElementById('propinsi').innerHTML,
        "kode_kab_kota" : document.getElementById('kode_kab_kota').value,
        "kabupaten_kota" : document.getElementById('kabupaten_kota').innerHTML,
        "kode_kec" : document.getElementById('kode_kec').value,
        "kecamatan" : document.getElementById('kecamatan').innerHTML,
        "npsn" : document.getElementById('npsn').innerHTML,
        "sekolah" : document.getElementById('nama_sekolah').innerHTML,
        "bentuk" : document.getElementById('bentuk').innerHTML,
        "status" : document.getElementById('status').innerHTML,
        "alamat_jalan" : document.getElementById('alamat_jalan').innerHTML,
        "lintang" : document.getElementById('lintang').value,
        "bujur" :document.getElementById('bujur').value
      }
      $.ajax({
        type: 'POST',
        url: "{{ url('/') }}/api/v1/admin/sekolah/store",
        data: datas,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status);
        swal({
          title: "Berhasil",
          text: "Sekolah ditambahkan ke database. \n\n Message: "+data.message,
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
