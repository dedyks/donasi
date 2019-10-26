@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Detail Rapor Sekolah</title>
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
                  <h4 class="page-title">Detail Rapor Sekolah</h4>
                  <ol class="breadcrumb">
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                      <a href="{{ url('/dashboard/rapor/sekolah') }}">Rapor Sekolah</a>
                    </li>
                    <li>
                      <a href="{{ url('/dashboard/rapor/sekolah/list-rapor') }}?id=">List Rapor</a>
                    </li>
                    <li class="active">
                      Detail Rapor Sekolah
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

              <div class="row">
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Lingkungan Positif dan Etis</h3>
                    </div>
                    <div class="panel-body" style="height:200px;overflow:auto" id="aspek-lingkungan-positif-dan-etis">

                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Penumbuhan Karakter</h3>
                    </div>
                    <div class="panel-body" style="height:200px;overflow:auto" id="aspek-penumbuhan-karakter">

                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Pembelajaran Berbasis Problem & Riset</h3>
                    </div>
                    <div class="panel-body" style="height:200px;overflow:auto" id="aspek-pembelajaran-berbasis-problem-dan-riset">

                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Konektifitas Sekolah</h3>
                    </div>
                    <div class="panel-body" style="height:200px;overflow:auto" id="aspek-konektifitas-sekolah">

                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Gambar yang diupload</h3>
                    </div>
                    <div class="panel-body" style="height:300px;overflow:auto" id="aspek-konektifitas-sekolah">
                      <div class="row">
                        <div class="col-md-12" style="margin-bottom:20px">
                          <p style="margin-top:10px"> <b>Tambahkan Beberapa Foto  :</b> </p>
                          <input multiple type="file" name="foto_rapor" id="foto_rapor" class="form-control" value="">
                        </div>
                      </div>
                      <div class="row" id="uploadedImage" style="margin-bottom:20px">

                      </div>
                    </div>
                  </div>
                </div>
                <div class="btn-group pull-right m-t-15">
                    <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" onclick="updateRapor()">Update Rapor</button>
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
      var id_rapor = id.get("id");

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/rapor/sekolah/id/"+id_rapor,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status)

        document.getElementById('sekolah').innerHTML = data.data.user.sekolah;
        document.getElementById('bentuk').innerHTML = data.data.user.bentuk;
        if (data.data.user.status == 'N')
          document.getElementById('status').innerHTML = 'Negeri';
        else
          document.getElementById('status').innerHTML = 'Swasta';
        document.getElementById('npsn').innerHTML = data.data.user.npsn;
        document.getElementById('alamat_jalan').innerHTML = data.data.user.alamat_jalan;
        document.getElementById('kecamatan').innerHTML = data.data.user.kecamatan;
        document.getElementById('kabupaten_kota').innerHTML = data.data.user.kabupaten_kota;
        document.getElementById('propinsi').innerHTML = data.data.user.propinsi;
        if (data.data.user.model_gsm.flag == 'model_gsm')
          document.getElementById('label_gsm').innerHTML = '<span class="label label-success">Sekolah Model GSM</span>';
        else if (data.data.user.model_gsm.flag == 'emodel_gsm')
          document.getElementById('label_gsm').innerHTML = '<span class="label label-primary">Sekolah e-Model GSM</span>';
        else
          document.getElementById('label_gsm').innerHTML = '<span class="label label-warning">Sekolah Jejaring GSM</span>';

        if ('image' in data.data){
          var jumlahGambar = data.data.image.length
          var gambar = data.data.image
          var urlImage = {!! json_encode(url('/')) !!}

          for(var x= 0; x< jumlahGambar; x++){
            $("#uploadedImage").append(
              '<div class="col-md-4">'+
                  '<img src="'+urlImage+'/storage/images/'+gambar[x].filename+'" alt="image" class="img-responsive img-rounded" width="100%"/>'+
              '</div>'
            )
          }
        }

        var response = JSON.parse(data.data.laporan)
        console.log(response)
        var length =  response.length
          for(var i = 0; i<length; i++){
              var aspek = response[i].aspek
              var response2 = response
              switch(aspek){
                  case "Lingkungan Positif dan Etis":
                      var id_namePanel = 'aspek-lingkungan-positif-dan-etis'
                      var id_nameList = 'listLPdE'
                      appendListRapor(aspek, response2, i, id_namePanel, id_nameList )

                  break;
                  case "Penumbuhan Karakter":
                          var id_namePanel = 'aspek-penumbuhan-karakter'
                          var id_nameList = 'listPK'
                          appendListRapor(aspek, response2, i, id_namePanel, id_nameList )

                  break;
                  case "Pembelajaran Berbasis Problem dan Riset":
                          var id_namePanel = 'aspek-pembelajaran-berbasis-problem-dan-riset'
                          var id_nameList = 'listPBPdR'
                          appendListRapor(aspek, response2, i, id_namePanel, id_nameList )

                  break;
                  case "Konektifitas Sekolah":
                      var id_namePanel = 'aspek-konektifitas-sekolah'
                      var id_nameList = 'listKS'
                      appendListRapor(aspek, response2, i, id_namePanel, id_nameList )
                  break;
              }
          }
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
    })

    function appendListRapor(aspek, response, i, id_namePanel, id_nameList ){
        if(response[i].cek == "true"){
            var checked = "checked"
        }else{
            var checked =""
        }
        $("#"+id_namePanel).append(
            '<div class="row" id="'+id_nameList+i+'">'+
            '<div class="col-md-12">'+
            '<input name="aspek" value="'+response[i].aspek+'" type="input" style="display:none">'+
            '<input name="inputFormatKerangka" value="'+response[i].poin+'" type="input" style="display:none">'+
            '<p>'+response[i].poin+'</p>'+
            '</div>'+

            '<div class="col-md-12" style="margin-top:9px">'+
            '<form class="form-horizontal" role="form">'+
            // Checkbox
            '<div class="col-md-1 form-group">'+
            '<div class="col-md-9">'+
            '<div  class="checkbox checkbox-custom">'+
            '<input name="cek" id="checkbox'+i+'" '+checked+' type="checkbox">'+
            '<label for="checkbox'+i+'">Cek</label>'+
            '</div>'+
            '</div>'+
            '</div>'+
            // Checkbox

            // Skor
            '<div class="col-md-8 form-group" style="margin-top:-2px">'+
                '<p class="col-md-4 control-label">Skor :</p>'+
                '<div class="col-md-4">'+
                    '<input type="text" name="skor" class="form-control" value="'+response[i].skor+'">'+
                '</div>'+
            '</div>'+
            // Skor

            // Bukti Perubahan
            '<div class="col-md-12  form-group">'+
            '<p> <b>Bukti Perubahan</b> : </p>'+
            '<textarea name="evidance" style="width:100%"  class="form-control">'+response[i].evaluasi+'</textarea>'+
            '</div>'+
            // Bukti Perubahan
            '</form>'+
            '</div>'+

            // '<div class="col-md-2">'+
            // '<div  class="checkbox checkbox-custom">'+
            // '<input id="checkbox'+i+'" type="checkbox" '+checked+'>'+
            // '<label for="checkbox'+i+'">'+
            //     'Cek'+
            // '</label>'+
            // '</div>'+
            // '</div>'+
            // '<div class="col-md-4">'+
            // '<p style="margin-top:9px;">Skor : '+response[i].skor+'</p>'+
            // '</div>'+
            // '<div class="col-md-12">'+
            // '<p> <b>Bukti Perubahan</b> : <span>'+response[i].evaluasi+'</span></p>'+
            // '</div>'+
            '<div class="col-md-12">'+
            '<hr>'+
            '</div>'+
            '</div>'
        )
    }


    function updateRapor(){
        // Poin Inputan
        var inputan = ''
        $("input[name='inputFormatKerangka']").each(function(){
            inputan += '{'
            inputan += '"poin" : "'
            inputan += this.value
            inputan += '"}, '
           })
        var inputan2 = JSON.parse('['+inputan.replace(/,\s*$/, "")+']')
        console.log("ini inputan2")
        console.log(inputan2)
        // Skor
        var skor = ''
        $("input[name='skor']").each(function(){
            skor += '{'
            skor += '"skor" : "'
            skor += this.value
            skor += '"}, '
           })
        var skor2 = JSON.parse('['+skor.replace(/,\s*$/, "")+']')
        // Cek
        var cek = ''
        $("input[name='cek']").each(function(){
            if($(this).prop("checked") == true){
                var value = "true"
            }
            else if($(this).prop("checked") == false){
               var value = "false"
            }
            cek += '{'
            cek += '"cek" : "'
            cek += value
            cek += '"}, '
           })
           var cek2 = JSON.parse('['+cek.replace(/,\s*$/, "")+']')
        // Evidance
        var evidance = ''
        $("textarea[name='evidance']").each(function(){
            evidance += '{'
            evidance += '"evaluasi" : "'
            evidance += this.value
            evidance += '"}, '
           })
        var evidance2 = JSON.parse('['+evidance.replace(/,\s*$/, "")+']')
        // Aspek
        var aspek = ''
        $("input[name='aspek']").each(function(){
            aspek += '{'
            aspek += '"aspek" : "'
            aspek += this.value
            aspek += '"}, '
           })
        var aspek2 = JSON.parse('['+aspek.replace(/,\s*$/, "")+']')
        var length = aspek2.length
        var kerangka = ''
        for(var i= 0;i<length;i++){
            kerangka += '{'
            kerangka += '"aspek" : "'
            kerangka += aspek2[i].aspek
            kerangka += '", "poin" : "'
            kerangka += inputan2[i].poin
            kerangka += '", "cek" : "'
            kerangka += cek2[i].cek
            kerangka += '", "skor" : "'
            kerangka += skor2[i].skor
            kerangka += '", "evaluasi" : "'
            kerangka += evidance2[i].evaluasi
            kerangka += '"}'
            if(i == length-1){
                kerangka += ''
            }else{
                kerangka += ','
            }
        }

        var kerangkaorigin = '['+kerangka.replace(/,\s*$/, "")+']'
        console.log(kerangkaorigin)
        var user_id = localStorage.getItem('id_usernya_assessor')

        var formData = new FormData();
        formData.append("laporan", kerangkaorigin)
        var jumlah_gambar = document.getElementById('foto_rapor').files.length;
        for (var x = 0; x < jumlah_gambar; x++) {
            formData.append("image[]", document.getElementById('foto_rapor').files[x]);
        }

        var token_user = getCookie("token_login_user_gsm")
        var id = new URLSearchParams(document.location.search.substring(1));
        var id_rapor = id.get("id");

        $(document).ajaxStart(function() { Pace.restart(); });
        $.ajax({
            url: '{{ url('/') }}/api/v1/admin/rapor/sekolah/id/'+id_rapor,
            data: formData,
            type: 'POST',
            headers : {
                "Authorization" : "Bearer "+token_user
                // "Content-Type" : "application/x-www-form-urlencoded"
            },
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
        })
        .done(function(response){
            console.log(response)
            swal("Berhasil Mengupdate")
            window.location =  "{{ url('/assessor/rapor/listraporuser') }}"

            // window.location = '/elearning/public/assessor/rapor/listraporuser'
            // getAllQuizUser()
        })
        .fail(function(response){
            console.log(response)
            swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
        })
    }
  </script>
@endsection
