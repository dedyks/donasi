@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Rapor Oleh Assessor</title>
@endsection

@section('content')
<div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                        <div class="col-sm-12">
                                <h4 class="page-title">Rapor Oleh Assessor : <span id="assessor_name"></span></h4>
                                <ol class="breadcrumb">
                                    <li>
                                      <a href="{{ url('dashboard/') }}">Home</a>
                                    </li>
                                    <li>
                                        Rapor
                                    </li>
                                    <li >
                                        <a href="{{ url('dashboard/raporbyassessor/listassessor') }}">List Assessor</a> 
                                     </li>
                                    <li>
                                        <a href="{{ url('dashboard/raporbyassessor/listuser') }}">List user yang diampu</a> 
                                    </li>
                                    <li class="active">
                                            <a href="{{ url('dashboard/raporbyassessor/listraporuser') }}">List rapor</a> 
                                    </li>
                                    <li class="active">
                                            <a href="{{ url('dashboard/raporbyassessor/detailrapor') }}">Detail rapor user : <span id="user_name"></span></a> 
                                    </li>
                                </ol>
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
                                            <div class="col-md-4" style="margin-bottom:20px">
                                                <p style="margin-top:10px"> <b>Tambahkan Beberapa Foto  :</b> </p>
                                                <input multiple type="file" name="foto_rapor" id="foto_rapor" class="form-control" value="">        
                                            </div>
                                          </div>
                                      <div class="row" id="uploadedImage" style="margin-bottom:20px">
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
    document.getElementById("user_name").innerHTML = localStorage.getItem("user_name")
    document.getElementById("assessor_name").innerHTML = localStorage.getItem("assessor_name")
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user=getCookie("token_login_user_gsm")
    var id = localStorage.getItem("id_rapor_user")
    var headers = {
        headers : {
        "Authorization" : "Bearer "+token_user
        }
    }
    axios.get(appurl+'v1/admin/rapor/id/'+id, headers)
    .then(function(data){
      var jumlahGambar = data.data.data.image.length
      var gambar = data.data.data.image
      var urlImage = {!! json_encode(url('/')) !!}

      for(var x= 0; x< jumlahGambar; x++){
        $("#uploadedImage").append(
          '<div class="col-md-4">'+
              '<img src="'+urlImage+'/storage/images/'+gambar[x].filename+'" alt="image" class="img-responsive img-rounded" width="100%"/>'+
          '</div>'
        )
      }
      var response = JSON.parse(data.data.data.laporan)
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
    .catch(function(response){
        swal("Maaf", "Terjadi kesalahan, cek koneksi internet Anda")
      console.log(response)
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
        '<p>'+response[i].poin+'</p>'+
        '</div>'+
        '<div class="col-md-1">'+
        '<div  class="checkbox checkbox-custom">'+
        '<input id="checkbox'+i+'" type="checkbox" '+checked+'>'+
        '<label for="checkbox'+i+'">'+
            'Cek'+
        '</label>'+
        '</div>'+
        '</div>'+
        '<div class="col-md-4">'+
        '<p style="margin-top:9px;margin-left:20px">Skor : '+response[i].skor+'</p>'+
        '</div>'+
        '<div class="col-md-12">'+
        '<p> <b>Bukti Perubahan</b> : <span>'+response[i].evaluasi+'</span></p>'+                     
        '</div>'+
        '<div class="col-md-12">'+
        '<hr>'+                        
        '</div>'+
        '</div>'
    )
}
</script>
@endsection