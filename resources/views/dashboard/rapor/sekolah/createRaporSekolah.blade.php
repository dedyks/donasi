@extends('assessor.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Buat Rapor Sekolah</title>
@endsection

@section('content')
  <div class="content-page">
      <div class="content">
          <div class="container">
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="page-title">Buat Rapor Sekolah</h4>
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
                      Buat Rapor Sekolah
                    </li>
                  </ol>
                </div>
              </div>
              <div class="row" id="daftarAspek" style="">
                <div class="col-md-12">
                    <div class="card-box">
                        <p> <b>Judul Rapor :</b> </p>
                        <input type="text" name="judul" id="judul" class="form-control" value="">
                        <p style="margin-top:10px"> <b>Upload Beberapa Foto  :</b> </p>
                        <input multiple type="file" name="foto_rapor" id="foto_rapor" class="form-control" value="">
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Lingkungan Positif dan Etis</h3>
                    </div>
                    <div class="panel-body" style="height:300px;overflow:auto" id="aspek-lingkungan-positif-dan-etis">
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Penumbuhan Karakter</h3>
                    </div>
                    <div class="panel-body" style="height:300px;overflow:auto" id="aspek-penumbuhan-karakter">
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Pembelajaran Berbasis Problem & Riset</h3>
                    </div>
                    <div class="panel-body" style="height:300px;overflow:auto" id="aspek-pembelajaran-berbasis-problem-dan-riset">
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Konektifitas Sekolah</h3>
                    </div>
                    <div class="panel-body" style="height:300px;overflow:auto" id="aspek-konektifitas-sekolah">
                    </div>
                  </div>
                </div>
              </div>
              <div class="btn-group pull-right m-t-15">
                  <button type="button" class="btn btn-default dropdown-toggle waves-effect waves-light" onclick="createRapor()">Submit Rapor</button>
              </div>
          </div>
      </div>
    </div>
@endsection

@section('js')
  <script>
    $(document).ready(function(){
        getKerangkaRapor()
    })

    function appendList(aspek, response, i, id_namePanel, id_nameList ){
        $("#"+id_namePanel).append(
            '<div class="row" id="'+id_nameList+i+'">'+
            '<div class="col-md-12">'+
            '<p>'+response.data.data.kerangka[i].poin+'</p>'+
            '<input type="text" name="aspek" style="display:none" value="'+aspek+'"></input>'+
            '<input type="text" name="inputFormatKerangka"  style="display:none" value="'+response.data.data.kerangka[i].poin+'"></input>'+
            '</div>'+

            '<div class="col-md-12" style="margin-top:9px">'+
            '<form class="form-horizontal" role="form">'+
            // Checkbox
            '<div class="col-md-1 form-group">'+
            '<div class="col-md-9">'+
            '<div  class="checkbox checkbox-custom">'+
            '<input name="cek" id="checkbox'+i+'" type="checkbox">'+
            '<label for="checkbox'+i+'">Cek</label>'+
            '</div>'+
            '</div>'+
            '</div>'+
            // Checkbox

            // Skor
            '<div class="col-md-8 form-group" style="margin-top:-2px">'+
                '<p class="col-md-4 control-label">Skor :</p>'+
                '<div class="col-md-4">'+
                    '<input type="text" name="skor" class="form-control" value="">'+
                '</div>'+
            '</div>'+
            // Skor

            // Bukti Perubahan
            '<div class="col-md-12  form-group">'+
            '<p> <b>Bukti Perubahan</b> : </p>'+
            '<textarea name="evidance" style="width:100%"  class="form-control" value=""></textarea>'+
            '</div>'+
            // Bukti Perubahan
            '</form>'+
            '</div>'+

            '<div class="col-md-12" style="margin-top:-10px">'+
            '<hr>'+
            '</div>'+
            '</div>'
        )
    }

    function getKerangkaRapor(){
        var token_user = getCookie("token_login_user_gsm")
        axios.get("{{ url('/') }}/api/v1/admin/rapor/kerangka", {headers : {
          "Authorization" : "Bearer "+token_user,
          "Content-Type" : "application/json"
        }})
        .then(function(response){
            var length = response.data.data.kerangka.length
            if(length > 0 ){
                for(var i = 0; i<length; i++){
                var aspek = response.data.data.kerangka[i].aspek
                var response = response
                switch(aspek){
                    case "Lingkungan Positif dan Etis":
                        var id_namePanel = 'aspek-lingkungan-positif-dan-etis'
                        var id_nameList = 'listLPdE'
                        appendList(aspek, response, i, id_namePanel, id_nameList )

                    break;
                    case "Penumbuhan Karakter":
                            var id_namePanel = 'aspek-penumbuhan-karakter'
                            var id_nameList = 'listPK'
                            appendList(aspek, response, i, id_namePanel, id_nameList )

                    break;
                    case "Pembelajaran Berbasis Problem dan Riset":
                            var id_namePanel = 'aspek-pembelajaran-berbasis-problem-dan-riset'
                            var id_nameList = 'listPBPdR'
                            appendList(aspek, response, i, id_namePanel, id_nameList )

                    break;
                    case "Konektifitas Sekolah":
                        var id_namePanel = 'aspek-konektifitas-sekolah'
                        var id_nameList = 'listKS'
                        appendList(aspek, response, i, id_namePanel, id_nameList )
                    break;
                }
            }
            }else{
                swal("Maaf", "Belum ada format atau kerangka rapor yang dibuat oleh Admin, silahkan hubungi Admin yang bersangkutan")
            }
            console.log(response)
        })
        .catch(function(error){
            console.log(error)
            swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
        })
    }

    function createRapor(){
        // Poin Inputan
        var inputan = ''
        $("input[name='inputFormatKerangka']").each(function(){
            inputan += '{'
            inputan += '"poin" : "'
            inputan += this.value
            inputan += '"}, '
           })
        var inputan2 = JSON.parse('['+inputan.replace(/,\s*$/, "")+']')

        var skor = ''
        $("input[name='skor']").each(function(){
            skor += '{'
            skor += '"skor" : "'
            skor += this.value
            skor += '"}, '
           })
        var skor2 = JSON.parse('['+skor.replace(/,\s*$/, "")+']')

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
           console.log(cek2)
        var evidance = ''
        $("textarea[name='evidance']").each(function(){
            evidance += '{'
            evidance += '"evaluasi" : "'
            evidance += this.value
            evidance += '"}, '
           })
        var evidance2 = JSON.parse('['+evidance.replace(/,\s*$/, "")+']')
        console.log(evidance2)

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

        // var kerangka2 = JSON.stringify('['+kerangka.replace(/,\s*$/, "")+']')
        // var kerangka2 = '['+kerangka.replace(/,\s*$/, "")+']'
        // console.log(kerangka2)
        // var data = {
        //     "user_id" : user_id ,
        //     "judul" : judul,
        //     "laporan" : kerangka2
        // }
        // $.ajax({
        //     method: "POST",
        //     url: appurl+"v1/admin/rapor",
        //     headers : {
        //         "Authorization" : "Bearer "+token_user,
        //         "Content-Type" : "application/x-www-form-urlencoded"
        //     },
        //     data : data
        //     })
        //     .done(function (response, status) {
        //         console.log(status)
        //         console.log(response);
        //         swal("Berhasil", "Rapor sudah berhasil Anda buat")
        //         window.location = '/elearning/public/assessor/rapor/listraporuser'
        //     })
        //     .fail(function (response) {
        //         //handle error
        //         console.log(response);
        //     });

        var kerangkaorigin = '['+kerangka.replace(/,\s*$/, "")+']'
        console.log(kerangkaorigin)
        var judul = document.getElementById('judul').value
        var id = new URLSearchParams(document.location.search.substring(1));
        var id_sekolah = id.get("id");


        var formData = new FormData();
        formData.append("user_id", id_sekolah );
        formData.append("judul", judul );
        formData.append("laporan", kerangkaorigin)
        var jumlah_gambar = document.getElementById('foto_rapor').files.length;
        for (var x = 0; x < jumlah_gambar; x++) {
            formData.append("image[]", document.getElementById('foto_rapor').files[x]);
        }

        var token_user = getCookie("token_login_user_gsm")
        $(document).ajaxStart(function() { Pace.restart(); });
        $.ajax({
            url: '{{ url('/') }}/api/v1/admin/rapor/sekolah',
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
            swal("Selamat", "Anda berhasil membuat rapor")
            window.location =  "{{ url('/dashboard/rapor/sekolah') }}"
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
