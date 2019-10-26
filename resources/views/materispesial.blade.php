@extends('layout.form')
@section('content')                     
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                                <div class="row">
                                   <!-- Upload Tantangan --> <div class="col-lg-12">
                                        <div class="panel panel-color panel-custom">
                                            <div class="panel-heading">
                                                <h3 class="panel-title" id="materi"></h3>
                                            </div>
                                            <div class="panel-body">
                                                    <div class="col-lg-12"> 
                                                            <ul class="nav nav-tabs tabs">
                                                                <li class="active tab">
                                                                    <a href="#deskripsi" data-toggle="tab" aria-expanded="false"> 
                                                                        <span class="visible-xs"><i class="fa fa-home"></i></span> 
                                                                        <span class="hidden-xs">Deskripsi</span> 
                                                                    </a> 
                                                                </li> 
                                                                <li class="tab"> 
                                                                    <a href="#you_tube" data-toggle="tab" aria-expanded="false"> 
                                                                        <span class="visible-xs"><i class="fa fa-film"></i></span> 
                                                                        <span class="hidden-xs">Video</span> 
                                                                    </a> 
                                                                </li> 
                                                                <li class="tab"> 
                                                                    <a href="#pdf" data-toggle="tab" aria-expanded="true"> 
                                                                        <span class="visible-xs"><i class="fa  fa-file-pdf-o"></i></span> 
                                                                        <span class="hidden-xs">PDF</span> 
                                                                    </a> 
                                                                </li> 
                                                                <li class="tab"> 
                                                                    <a href="#gambar" data-toggle="tab" aria-expanded="false"> 
                                                                        <span class="visible-xs"><i class="fa  fa-image"></i></span> 
                                                                        <span class="hidden-xs">Gambar</span> 
                                                                    </a> 
                                                                </li> 
                                                                <li class="tab"> 
                                                                    <a href="#tantangan" data-toggle="tab" aria-expanded="false"> 
                                                                        <span class="visible-xs"><i class="fa  fa-pencil-square-o"></i></span> 
                                                                        <span class="hidden-xs">Tantangan</span> 
                                                                    </a> 
                                                                </li>
                                                            </ul> 
                                                            <div class="tab-content"> 
                                                                <div class="tab-pane active" id="deskripsi"> 
                                                                </div> 
                                                                <div class="tab-pane" id="you_tube">      
                                                               </div> 
                                                                <div  class="tab-pane" id="pdf">
                                                                </div> 
                                                                <div class="tab-pane" id="gambar">
                                                                </div>
                                                                <div class="tab-pane" id="tantangan">
                                                                <div id="tantangan_text">
                                                                </div>
                                                                <div style="margin-top:20px;">
                                                                        <form class="form-horizontal m-t-20">
                                                                            <label class="control-label">Upload Tantangan</label>
                                                                            <p style="margin-bottom:5px">Pilih beberapa foto secara langsung (ukuran gambar tidak boleh dari 5 MB), lalu upload</p>
                                                                            <input  type="file" multiple class="filestyle" data-buttonname="btn-white" name="image[]" id="foto_tantangan">

                                                                            <label style="margin-top:15px" class="control-label">Deskripsi</label>
                                                                            <p>Jelaskan secara singkat tentang jawaban dari tantangan ini</p>
                                                                            <textarea type="text" class="form-control" name="deskripsi" id="deskripsi_tantangan"></textarea>

                                                                            <input type="text" id="id_user" name="user_id" style="display:none">
                                                                            <input type="text" id="id_modul" name="modul_id" style="display:none">
                                                                            
                                                                        </form>
                                                                        <div style="text-align:right">
                                                                            <button style="text-align:right;margin-top:20px;margin-bottom:20px" onclick="upload_tantangan()" class="btn btn-default waves-effect waves-light "> <i style="display:none" id="iconLoading" class="fa fa-spin fa-spinner"> </i><span id="sendText">Submit</span> </button>
                                                                        </div>
                                                                </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                    </div> <!-- Upload Tantangan -->
                    
                    <!-- Penilaian -->
                    <div class="col-lg-12" id="penilaian" style="display:none">
                        <div class="panel panel-color panel-custom">
                            <div class="panel-heading">
                                <h3 class="panel-title">Penilaian Tantangan Anda</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-12" style="margin-bottom:20px"> 
                                    <p> <b>Berikut ini tantangan yang telah Anda upload</b></p>
                                    <p>Gambar :</p>
                                    <div class="row" style="margin:20px 0px 20px 0px;"  id="imageTantanganUploaded">
                                        {{-- Block Code --}}
                                    </div>
                                    
                                    <p>Deskripsi : <span id="deskripsi_tantangan_uploaded"></span></p>
                                  
                                </div>
                                <hr>
                                <div class="col-lg-12" style="margin-top:10px"> 
                                        <p> <b>Berikut ini penilaian dari assesor Anda</b></p>
                                        <p>Status :<span id="status"> -</span></p>
                                        <p>Penilaian : <span id="penilaian_tantangan"></span></p>
                                    </div>
                            </div>
                        </div>
                    </div> <!-- Penilaian -->
                </div> <!-- content -->

                <footer class="footer text-right">
                    © 2019. All rights reserved.
                </footer>

            </div>
            <script>
            $(document).ready(function(){
                var id_modul = localStorage.getItem("id_materi") 
                document.getElementById('id_modul').value = id_modul
                var data_user = JSON.parse(localStorage.getItem('data_user_elearning_gsm'))
                var id_assesor = localStorage.getItem('assessorId2')
                document.getElementById('id_user').value = data_user._id
                $(document).ajaxStart(function() { Pace.restart(); });
                var appurl = localStorage.getItem("url_elearning_gsm")
                var token_user = getCookie("token_login_user_gsm")
                $.ajax({
                type: 'GET',
                url :appurl+"v1/modul/"+id_modul, 
                headers : {
                    "Authorization" : "Bearer "+token_user , 
                    "Accept" : "application/json"
                }
                }).done(function(data, status){
                    console.log(data)
                    // console.log(data.tantangan.image[i].filename)
                    var length = data.tantangan.image.length
                    var urlImage = {!! json_encode(url('/')) !!}
                    for(var i = 0; i<length;i++){
                    $("#imageTantanganUploaded").append(
                        '<div class="col-md-4">'+
                                '<img  src="'+urlImage+'/storage/images/'+data.tantangan.image[i].filename+'"  alt="image" class="img-responsive img-rounded" width="100%"/>'+
                        '</div>'
                    )
                    }
                    
                    switch(data.tantangan.flag){
                        case "enrolled" : 
                        document.getElementById("penilaian").style.display="none"
                        // Block Code
                        break;

                        case "answered" : 
                        document.getElementById("penilaian").style.display="block"
                        document.getElementById("deskripsi_tantangan_uploaded").innerHTML = data.tantangan.deskripsi
                        var buttonText = document.getElementById('sendText') 
                        buttonText.innerHTML ="Update Tantangan"
                        if(id_assesor == "null"){
                            document.getElementById("penilaian_tantangan").innerHTML = "Anda belum memilih assesor untuk menilai tantangan yang Anda jawab, silahkan pilih assesor di halaman pendampingan"
                            document.getElementById("penilaian_tantangan").style.color = "red"
                        }else{
                            document.getElementById("penilaian_tantangan").innerHTML = "Sedang dalam proses"
                            document.getElementById("status").innerHTML = " Sedang dalam proses"

                        }
                        // Block Code
                        break;

                        case "scored" : 
                        document.getElementById("penilaian").style.display="block"
                        document.getElementById("deskripsi_tantangan_uploaded").innerHTML = data.tantangan.deskripsi
                        document.getElementById("penilaian_tantangan").innerHTML = data.tantangan.penilaian
                        if(data.tantangan.status=="revisi"){
                            document.getElementById("status").innerHTML = " Revisi, Upadate tantangan Anda di tab Tantangan"
                        }else{
                            document.getElementById("status").innerHTML = " Lulus, Anda berhasil mengerjakan tantangan dengan baik"

                        }
                        var buttonText = document.getElementById('sendText') 
                        buttonText.innerHTML ="Update Tantangan"
                        // Block Code
                        break;

                        default : 
                        // Block Code
                        break;
                    }
                    document.getElementById('materi').innerHTML = 'Materi '+data.modul.title
                    $('#deskripsi').append(
                    '<p>'+data.modul.description+'</p>'
                    )

                    $('#tantangan_text').append(
                        '<p>'+data.modul.task+'</p>'
                    )

                    var jumlah_data_video = data.modul.video.length
                    for(var i = 0; i < jumlah_data_video; i++){
                        var url_string = data.modul.video[i].url
                        var url = new URL(url_string);
                        var v = url.searchParams.get("v");
                        var ke= ["Pertama", "Kedua", "Ketiga", "Kempat", "Kelima", "Keenam", "Ketujuh", "Kedelapan", "Kesembilan", "Kesepuluh"]
                        $('#you_tube').append(
                            '<br>'+
                            '<p>Video '+ ke[i] +'</p>'+
                            '<br>'+
                            '<iframe src="https://www.youtube.com/embed/'+v+'" width="100%" height="500" frameborder="0" allowfullscreenid="you_tube"></iframe>'
                        )
                    }
                    var jumlah_data_pdf = data.modul.document.length
                    for(var i= 0; i< jumlah_data_pdf;i++){
                        var ke= ["Pertama", "Kedua", "Ketiga", "Kempat", "Kelima", "Keenam", "Ketujuh", "Kedelapan", "Kesembilan", "Kesepuluh"]
                        $('#pdf').append(
                            '<br>'+
                            '<p>PDF '+ ke[i] +'</p>'+
                            '<br>'+
                            '<iframe src="'+data.modul.document[i].url+'" width="100%" height="500"></iframe>'
                        
                        )
                    }
                    var urlImage = {!! json_encode(url('/')) !!}
                    var jumlah_data_gambar = data.modul.image.length
                    for(var i = 0; i < jumlah_data_gambar;i++){
                        var ke= ["Pertama", "Kedua", "Ketiga", "Kempat", "Kelima", "Keenam", "Ketujuh", "Kedelapan", "Kesembilan", "Kesepuluh"]
                        $('#gambar').append(
                            '<br>'+
                            '<p>Gambar '+ ke[i] +'</p>'+
                            '<br>'+
                            '<img  src="'+urlImage+'/storage/images/'+data.modul.image[i].filename+'"  alt="image" class="img-responsive img-rounded" width="100%"/>'
                        )
                    }
                }).fail(function(data, status){
                    hideloading()
                    swal("Terjadi Kesalahan", "Cek koneksi internet Anda dan ulangi");
                })
            })
            </script>
            
            <style>
                .title{
                    text-align:center;
                    font-size:50px;
                    font-family: 'Passion One', cursive;
                    letter-spacing: 3px;
                }
                
                @media only screen and (max-width: 600px) {
                    .title{
                    font-size:30px;
                
                }
                }
                </style>
        @endsection