@extends('layout.basiclayout')
@section('content')

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">

<div class="account-pages"></div>
<div class="clearfix"></div>


<div class="container-alt">
    <div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <div class="wrapper-page signup-signin-page">
            <div class="card-box" style="display:block" id="kuponPendaftaran">
            <div class="panel-heading">
            <h3 class="text-center">
                Input Kupon Pendaftaran
            </h3>
            <p style="text-align:center">Masukan kupon pendaftaran Anda di bawah ini</p>

            </div> 
            <div class="panel-body">
            <div style="text-align:center" class="row">
                    <img src="assets/images/ajax-loader.gif" alt="image" style="display:none;margin-bottom:20px;margin-top:-10px" class="img-rounded" id="loadingKupon" width="50"/>
            </div>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                        <input class="form-control" type="text" required id="kupon" placeholder="" value="">
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-12" style="text-align:center">
                <button style="margin-top:20px" class="btn btn-info text-uppercase waves-effect waves-light w-sm" onclick="submitKupon()">
                        Submit
                    </button>
                </div>                                            
            </div>
            </div>
            </div>
            <div class="card-box" style="display:none" id="HalamanPendaftaran">
                <div class="panel-heading">
                    <h3 class="text-center">Halaman pendaftaran <strong class="text-custom">E-Learning GSM</strong></h3>
                    <p style="text-align:Center">Isilah form di bawah ini sesuai dengan data diri anda</p>
                </div>

                <div class="panel-body">
                    <div style="text-align:center" class="row">
                            <img src="assets/images/ajax-loader.gif" alt="image" style="display:none;margin-bottom:20px;margin-top:-10px" class="img-rounded" id="loading" width="50"/>
                    </div>
                    <div style="margin-top:20px" class="row">

                        <div style="margin-top:-55px" class="col-md-6">
                            <div class="p-20">
                                <form class="form-horizontal m-t-20" action="index.html">
                                    <div class="form-group ">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="text" required id="nama" placeholder="Nama" value="">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <input class="form-control" type="email" required id="email" placeholder="Email" value="">
                                        </div>
                                    </div>

                                    <div class="row" style="margin-bottom:10px;margin-top:5px">
                                        {{-- <div class="form-group"> --}}
                                            <div class="col-xs-6">
                                                <input class="form-control" type="password" required id="password" placeholder="Password" value="">
                                            </div>
                                        {{-- </div> --}}

                                    {{-- <div class="form-group"> --}}
                                            <div class="col-xs-6">
                                                <input class="form-control" type="password" required id="repeat_password" placeholder="Ulangi Password" value="" >
                                            </div>
                                        {{-- </div>  --}}
                                    </div>

                                    <div class="form-group" style="margin-top:10px;display:block">
                                            <div class="col-xs-12">
                                                    <p>Kabupaten/Kota Anda atau Sekolah Anda<span id="loadingDaerah"><img src="assets/images/ajax-loader.gif" alt="image" style="width:5%" class="img-rounded"/></span> </p>
                                                    <select name="daerah[]" id="my_select" data-live-search="true" data-style="btn-white" class="selectpicker"><option value="" selected disabled>Please select</option>
                                                    </select>
                                                    <input type="text" style="display:none" id="kabupaten/kota">

                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>


                        <div style="margin-top:-60px"  class="col-md-6">
                            <div class="p-20">
                                <form class="form-horizontal m-t-20" action="index.html">
                                        <!-- <div class="form-group">
                                                <div class="col-xs-12">
                                                        <p>Apakah Anda seorang guru ?</p>
                                                        <select name="status_guru[]" id="status_guru" data-live-search="true" data-style="btn-white" class="selectpicker">
                                                            <option value="" selected disabled>Please select</option>
                                                            <option value="" selected disabled>Iya</option>
                                                            <option value="" selected disabled>Tidak</option>
                                                        </select>
                                                </div>
                                            </div> -->

                                    <div style="display:none" id="formInputNPSN">
                                        <input type="text" class="form-control" placeholder="Inputkan NPSN" id="npsnSekolah">
                                        <p style="display:none;" id="namaSekolahByNPSN1" >Sekolah Anda :  <span id="namaSekolahByNPSN2" style="color:deepskyblue"></span></p>
                                        <p style="cursor:pointer;color:blue;" > <span onclick="cekSekolah()">Cek NPSN Sekolah</span> | <span onclick="backToPilihanSekolah()">Kembali</span></p>
                                    </div>

                                    <div id="jenisSekolahAndNama">
                                    <div class="form-group" style="display:block">
                                            <div class="col-xs-12">
                                                    <p>Jenis Sekolah Anda</p>
                                                    <select name="jenisSekolah"  id="jenisSekolah" data-live-search="true" data-style="btn-white" class="selectpicker">
                                                        <option value="null" selected disabled>Please select</option>
                                                        {{-- <option value="Bukan dari instansi pendidikan">Bukan dari instansi pendidikan</option> --}}

                                                        <option  value="SD">SD</option>
                                                        <option  value="MI">MI</option>
                                                        <option  value="SMP">SMP</option>
                                                        <option  value="MTs">MTs</option>
                                                        <option  value="SMA">SMA</option>
                                                        <option  value="SMK">SMK</option>
                                                        <option  value="MA">MA</option>
                                                        <option  value="MAK">MAK</option>
                                                    </select>
                                                </div>
                                            </div>

                                    <div class="form-group"  style="display:block">
                                            <div class="col-xs-12">
                                                    <p>Nama Sekolah Anda <span style="display:none" id="loadingSekolah"><img src="assets/images/ajax-loader.gif" alt="image" style="width:5%" class="img-rounded"/></span> </p>
                                                    {{-- <input class="form-control" type="text" required id="nama_sekolah" placeholder=""> --}}
                                                    <select name="sekolah[]"  id="sekolah" data-live-search="true" data-style="btn-white" class="selectpicker"><option value="-" selected disabled>Please select</option>
                                                    </select>
                                                    <p id="inputNPSN" style="display:none;margin-bottom:-10px">Sekolah Anda tidak ada ? Klik --> <span style="color:blue;cursor:pointer" onclick="inputNPSN()"><u>Masukan NPSN Sekolah Anda</u></span></p>
                                                    <input type="text" value="-" style="display:none" id="propinsi">
                                                    <input type="text" value="-" style="display:none" id="kode_kab_kota">
                                                    <input type="text" value="-" style="display:none" id="kabupaten_kota">
                                                    <input type="text" value="-" style="display:none" id="kode_kec">
                                                    <input type="text" value="-" style="display:none" id="kecamatan">
                                                    <input type="text" value="-" style="display:none" id="npsn">
                                                    <input type="text" value="-" style="display:none" id="bentuk">
                                                    <input type="text" value="-" style="display:none" id="status">
                                                    <input type="text" value="-" style="display:none" id="lintang">
                                                    <input type="text" value="-" style="display:none" id="alamat_jalan">
                                                    <input type="text" value="-" style="display:none" id="bujur">
                                                    {{-- <input type="text" style="display:none" id="nama_sekolah">  --}}

                                                </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                            <div class="col-xs-12">
                                                <p style="font-size:10px">Apa Anda sudah pernah mengikuti workshop yang diadkan GSM secara langsung ?</p>
                                                <div style="margin-top:-10px;margin-left:-10px" class="radio radio-custom">
                                                    <div class="col-md-2">
                                                        <input type="radio" name="workshop" id="radio1" value=true>
                                                        <label for="radio1">Iya</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                            <input type="radio" name="workshop" id="radio2" value=false>
                                                            <label for="radio2">Tidak</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group text-right m-t-20 m-b-0">
                                <div style="text-align:center" class="col-xs-12">
                                    <button  class="btn btn-info text-uppercase waves-effect waves-light w-sm" id="daftar">
                                        Daftar
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</div>


<script>
    var resizefunc = [];
</script>

<script>
    function submitKupon(){
        document.getElementById('loadingKupon').style.display = "inline"
        var kupon = document.getElementById('kupon').value
        var appurl = "{{env('APP_URL')}}"
        var request = $.get(appurl+"v1/use-reg-coupon/"+kupon)
        request.success(function(data) {
            document.getElementById('loadingKupon').style.display = "none"
            document.getElementById('HalamanPendaftaran').style.display = "block"
            document.getElementById('kuponPendaftaran').style.display = "none"
            swal("Selamat", "Kupon Anda Valid")
        })

        request.error(function(jqXHR, textStatus, errorThrown) {
            swal("Maaf", "Kupon Anda Tidak Valid")
            document.getElementById('loadingKupon').style.display = "none"

        });

    }

    function inputNPSN(){
        document.getElementById('npsnSekolah').value = ""
        document.getElementById('namaSekolahByNPSN1').style.display = "none"
        document.getElementById('formInputNPSN').style.display="block"
        document.getElementById('jenisSekolahAndNama').style.display="none"
    }

    function backToPilihanSekolah(){
        document.getElementById('sekolah').value = ""
        $("select[name='sekolah[]']").selectpicker("refresh");
        document.getElementById('formInputNPSN').style.display="none"
        document.getElementById('jenisSekolahAndNama').style.display="block"
    }

    function cekSekolah(){
        document.getElementById('loadingSekolah').style.display = "inline"
        var npsn = document.getElementById('npsnSekolah').value
        var appurl = "{{env('APP_URL')}}"
        $.get(appurl+"v1/sekolah/crawl/"+npsn, function(data, status){
            if(data){
                var sekolah = "<option value='"+data.sekolah+"'>"+ data.sekolah+"</option>"
                $("select[name='sekolah[]']").append(sekolah);
                $("select[name='sekolah[]']").selectpicker("refresh");
                document.getElementById('propinsi').value = data.propinsi
                document.getElementById('kode_kab_kota').value = "-"
                document.getElementById('kabupaten_kota').value = data.kabupaten_kota
                document.getElementById('kode_kec').value = "-"
                document.getElementById('kecamatan').value = data.kecamatan
                document.getElementById('npsn').value = data.npsn
                document.getElementById('bentuk').value = data.bentuk
                document.getElementById('status').value = data.status
                document.getElementById('lintang').value = data.lintang
                document.getElementById('alamat_jalan').value = data.alamat_jalan
                document.getElementById('bujur').value = data.bujur
                document.getElementById('sekolah').value = data.sekolah
                document.getElementById('loadingSekolah').style.display = "none"
                document.getElementById('namaSekolahByNPSN1').style.display = "block"
                document.getElementById('namaSekolahByNPSN2').innerHTML = data.sekolah

            }
            console.log(document.getElementById('sekolah').value)
        })
    }

    $(document).ready(function(){
    var appurl = "{{env('APP_URL')}}"
    $.get(appurl+"v1/wilayahKabGet", function(data, status){
        data = JSON.parse(data);
        var banyak_data = data.data.length;
          var daerah ="";
          for (var i = 0; i < banyak_data; i++) {
            daerah += '<option id ="'+data.data[i]["kode_wilayah"]+'"'+ 'value="'+data.data[i]["nama"] +'"'+'>' +data.data[i]["nama"]+'</option>'
          }
          $("select[name='daerah[]']").append(daerah);
          $("select[name='daerah[]']").selectpicker("refresh");
    if(data){
        document.getElementById('loadingDaerah').style.display = "none"
    }
    })
    $("#my_select").change(function() {
    console.log("Hello")
    var id = $(this).children(":selected").attr("id");
    var id_mst_kode_wilayah = id.replace(/\s/g, "")
    var kabupaten = $(this).children(":selected").attr("value");
    document.getElementById('kabupaten/kota').value =  kabupaten
    localStorage.setItem("id_mst_kode_wilayah", id_mst_kode_wilayah)
    var jenisSekolah = document.getElementById("jenisSekolah").value
    console.log(jenisSekolah)
    if(jenisSekolah !== "null"){
            sekolah(id_mst_kode_wilayah, jenisSekolah)
    }
    })

    $("#jenisSekolah").change(function(){
    var jenisSekolah = $(this).children(":selected").attr("value");
    var id_mst_kode_wilayah = localStorage.getItem("id_mst_kode_wilayah")
    var daerah = document.getElementById('my_select').value
        if(daerah !== ""){
            sekolah(id_mst_kode_wilayah, jenisSekolah)
        }else{
            swal("Maaf", "Pilih daerah Anda terlebih dahulu")
            $("#jenisSekolah").val(document.getElementById('jenisSekolah').value);
        }

    })

    $("#sekolah").change(function() {
    document.getElementById('propinsi').value = $(this).children(":selected").attr("propinsi");
    document.getElementById('kode_kab_kota').value = $(this).children(":selected").attr("kode_kab_kota");
    document.getElementById('kabupaten_kota').value = $(this).children(":selected").attr("kabupaten_kota");
    document.getElementById('kode_kec').value = $(this).children(":selected").attr("kode_kec");
    document.getElementById('kecamatan').value = $(this).children(":selected").attr("kecamatan");
    document.getElementById('npsn').value = $(this).children(":selected").attr("npsn");
    document.getElementById('sekolah').value = $(this).children(":selected").attr("value");
    document.getElementById('bentuk').value = $(this).children(":selected").attr("bentuk");
    document.getElementById('status').value = $(this).children(":selected").attr("status");
    document.getElementById('alamat_jalan').value = $(this).children(":selected").attr("alamat_jalan");
    document.getElementById('lintang').value = $(this).children(":selected").attr("lintang");
    document.getElementById('bujur').value = $(this).children(":selected").attr("bujur");
    })
    })
</script>
<script>
    function sekolah(id, jenisSekolah){
        var appurl = "{{env('APP_URL')}}"
        document.getElementById('loadingSekolah').style.display = "inline"
        var url = appurl+"v1/detailSekolahGET?mst_kode_wilayah="+id+"&bentuk="+jenisSekolah
        $.get(url, function(data, status){
            $("#sekolah")
            .find('option')
            .remove()
            $("#sekolah").selectpicker("refresh");
            if(data){
                document.getElementById('loadingSekolah').style.display = "none"
                document.getElementById('inputNPSN').style.display="block"
            }
          data = JSON.parse(data);
          var banyak_data = data.data.length;
          var sekolah ="<option value=''  selected disabled>Please select</option>";
          for (var i = 0; i < banyak_data; i++) {
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
        });
    }
</script>

        {{-- Sweet Alerts --}}
        <script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
        <script src="{{asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>

@endsection
