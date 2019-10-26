@extends('layout.dashboard')
@section('content')
<link href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">


            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                                <div class="row">

                                    <div class="col-lg-12">
                                            <div class="panel panel-color panel-custom">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Assesor </h3>
                                                </div>
                                                <div class="panel-body" id="assesorIdNotNull" style="display:none">
                                                    <div class="row">
                                                        <div class="col-md-12" style="margin-bottom:5px">
                                                                <p> <b>Assessor Anda</b> </p>
                                                            </div>
                                                        <div class="col-md-4">
                                                            <p>Nama : <span id="namaAssesor"></span></p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p>Mengampu : <span id="mengampu"></span> Orang</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <p>Email : <span id="emailAssesor"></span></p>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-12" style="margin-top:10px">
                                                            <p> <b>Apakah Anda tertarik menjadi assessor ?</b> </p>
                                                        </div>
                                                        <div class="col-md-12" id="assessorReqSection" style="margin-top:5px;display:none">
                                                            <p style="">Klik tombol di bawah ini untuk mengajukan diri Anda</p>
                                                            <button style="float:left;margin-top:10px" type="button" class="btn btn-default waves-effect waves-light" onclick="assessorReq()">Ajukan</button>
                                                        </div>
                                                        <div class="col-md-12" id="assessorReqSectionWait" style="display:none">
                                                            <p style=""> Anda sudah mengajukan diri sebagai Assessor, tunggu pemberitahuan selanjutnya </p>
                                                        </div>
                                                        <div class="col-md-12" id="assessorReqSectionAccept" style="display:none">
                                                                <p style=""> Anda sudah diterima sebagai assessor </p>
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="panel-body" id="assesorIdNull" style="display:none">  
                                                    <p style="margin-bottom:20px;color:red">Anda belum memiliki assesor, pilih seorang assesor untuk mulai pendampingan dan penilaian modul</p> 
                                                    <div class="card-box table-responsive">
                                                        <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>Nama</th>
                                                                    <th>Sekolah</th>
                                                                    <th>Kabupaten/Kota</th>
                                                                    <th>Kuota</th>
                                                                    <th>Aksi</th>   
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <div class="col-lg-12">
                                        <div class="panel panel-color panel-custom">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Chat Dengan Assesor </h3>
                                            </div>
                                            <div class="panel-body">                                         
                                                    <!-- CHAT -->
                                                    <div class="col-lg-12"><p style="text-align:center;display:none" id="chatBlocked">Fitur chating belum bisa digunakan karena Anda belum memilih assessor</p></div>
                                                    <div class="col-lg-12" id="chatWithAssessor" style="display:none">
                                                            {{-- <div class="card-box">     --}}
                                                                <div class="chat-conversation">
                                                                    <ul class="conversation-list nicescroll" id="listChat">
                                                                    <div class="col-md-12" style="text-align:center;display:block;" id="loading">
                                                                            <img src="assets/images/ajax-loader.gif" alt="image" style="" class="img-rounded" width="50"/>
                                                                        </div>
                                                                    </ul>
                                                                    <div class="row">
                                                                        <div class="col-sm-9" style="margin-bottom:10px">
                                                                            <input type="text" id="pesan" class="form-control" placeholder="Ketikan Pesan">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <button class="btn btn-md btn-info btn-block waves-effect waves-light" onclick="sendchat()"><i style="display:none" id="iconLoading" class="fa fa-spin fa-spinner"> </i><span id="sendText">Send</span></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            {{-- </div> --}}
                            
                                                        </div> <!-- end col-->
                                            </div>
                                        </div>
                                    </div>
                                </div>                              
                    </div> <!-- container -->
                </div> <!-- content -->
                <footer class="footer text-right">
                    © 2019. All rights reserved.
                </footer>

            </div>
            <!-- chatjs  -->
            <link href="{{asset('assets/plugins/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
            <link href="{{asset('assets/plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
            {{-- <link href="{{asset('assets/plugins/datatables/fixedColumns.dataTables.min.css')}}" rel="stylesheet" type="text/css"/> --}}
            <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
            <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>

            {{-- <script src="{{asset('assets/plugins/datatables/dataTables.fixedHeader.min.js')}}"></script> --}}
            {{-- <script src="{{asset('assets/plugins/datatables/dataTables.keyTable.min.js')}}"></script> --}}
            <script src="{{asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
            <script src="{{asset('assets/plugins/datatables/responsive.bootstrap.min.js')}}"></script>
            {{-- <script src="{{asset('assets/plugins/datatables/dataTables.fixedColumns.min.js')}}"></script> --}}
            <script src="https://kit.fontawesome.com/c3094cfefd.js"></script>
            <script src="{{asset('assets/pages/datatables.init.js')}}"></script>

            <script src="assets/pages/jquery.chat.js"></script>
            <script>
            $(document).ready(function(){
                var data_diri = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                var assesorId2 = localStorage.getItem('assessorId2')
                var reqAssessor = data_diri.request
                var roleUser = data_diri.role
                var appurl = localStorage.getItem("url_elearning_gsm")
                var token_user=getCookie("token_login_user_gsm")
                var headers = {
                    headers : {
                    "Content-Type" : "application/x-www-form-urlencoded", 
                    "Authorization" : "Bearer "+token_user
                    }
                }
                if( assesorId2 !=="null" ){
                    console.log("Tes")
                    document.getElementById('assesorIdNotNull').style.display ="block"
                    document.getElementById('chatWithAssessor').style.display = "block"
                    switch(reqAssessor){
                        case "false" :
                        document.getElementById('assessorReqSection').style.display ="block"
                        break;
                        case "true" :
                        if(reqAssessor == "true" && roleUser == "assessor" ){
                            document.getElementById('assessorReqSectionAccept').style.display ="block"
                        }else{
                            document.getElementById('assessorReqSectionWait').style.display ="block"
                        }
                        break;
                    }
                   var assesorId2 = { "user_id_lawan" : assesorId2}
                    getAssessorDetail(appurl, headers)
                    showthread2users(appurl, token_user, assesorId2)
                    
                }else{
                    document.getElementById('assesorIdNull').style.display ="block"
                    document.getElementById('chatBlocked').style.display ="block"
                    axios.get(appurl+'v1/users/choose/assessor', headers)
                    .then(function(response){
                        // console.log(response)
                        populateDataTable(response.data.data)
                    })
                }

                function populateDataTable(data) {
						$("#datatable-fixed-header").DataTable().clear();
						var length = data.length;
						// Perulangan for untuk memasukan data ke variable, akan diulang sekian kali sesuai length nya
						for (var i = 0; i < length; i++) {
						var a=data[i].name;
						var b=data[i].school_gsm.sekolah;
                        var c = data[i].school_gsm.kabupaten_kota;
                        var d = data[i].assessor_kuota_now+"/25" ;
						var action = '<button  style="margin-left:10px" class="btn btn-default waves-effect waves-light" onclick=chooseAssessor("'+data[i]._id+'")><i style="display:none" id="iconLoading" class="fa fa-spin fa-spinner"> </i><span id="sendText">Pilih</span></button>';
						$('#datatable-fixed-header').dataTable().fnAddData([
						a, b, c, d, action
						]);
						}
                    }
            });
            </script>
            <script>
            
             function chooseAssessor(id){
                        showLoading()
                        var appurl = localStorage.getItem("url_elearning_gsm")
                        var token_user=getCookie("token_login_user_gsm")
                        var data = {}
                        var headers = {
                            headers : {
                            "Content-Type" : "application/json", 
                            "Authorization" : "Bearer "+token_user
                            }
                        }
                        
                        axios.post(appurl+'v1/users/choose/assessor/'+id, data, headers)
                        .then(function(response){
                        console.log(response)
                        if(response.data.message == "assessor terpilih"){
                            hideLoading()
                            swal("Berhasil", "Anda berhasil memilih assessor")
                            // document.getElementById('assesorIdNull').style.display ="none"
                            localStorage.setItem('assessorId2', response.data.data.assessor_id)
                            getAssessorDetail(appurl, headers)
                            window.location = "pendampingan"
                        }else {
                             swal("Mohon maaf", "Kuota assessor penuh, silahkan pilih yang lainnya ")
                           }
                        })
                        .catch(function(error){
                            hideLoading()
                            // console.log(error)
                            swal("Terjadi Kesalahan", "Mohon cek koneksi internet Anda")
                        })
                    }
                function getAssessorDetail(appurl, headers){
                    axios.get(appurl+'v1/users/self', headers)
                    .then(function(response){
                        document.getElementById('namaAssesor').innerHTML =  response.data.user.assessor.name
                        document.getElementById('emailAssesor').innerHTML =  response.data.user.assessor.email
                        document.getElementById('mengampu').innerHTML =  response.data.user.assessor.assessor_kuota_now
                    })
                    .catch(function(error){
                        swal("Terjadi Kesalahan", "Mohon cek koneksi internet Anda")
                    })
                }

                function assessorReq(){
                    var appurl = localStorage.getItem("url_elearning_gsm")
                    var token_user=getCookie("token_login_user_gsm")
                    var data_diri = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                    var id_user = data_diri._id
                    var data = ""
                    axios.post(appurl+"v1/users/"+id_user+"/request-assessor", data, {
                        headers : {
                            "Content-Type" : "application/json", 
                            "Authorization" : "Bearer "+token_user
                        }
                    })
                    .then(function(response){
                        // console.log(response)
                        document.getElementById('assessorReqSectionWait').style.display ="block"
                        document.getElementById('assessorReqSection').style.display ="none"
                        swal("Berhasil", "Anda telah mengajukan diri sebagai assessor, Admin kami akan mengecek progress Anda di elearning ini sebagai bahan pertimbangan")
                    })
                    .catch(function(error){
                        swal("Terjadi Kesalahan", "Mohon cek koneksi internet Anda")
                        // console.log(error)
                    })
                }

                function sendchat(){
                    showLoading()
                    var appurl = localStorage.getItem("url_elearning_gsm")
                    var token_user=getCookie("token_login_user_gsm")
                    var threadId = localStorage.getItem("thread_id")
                    var pesan = { "message" : document.getElementById('pesan').value}
                    // console.log(pesan)
                    $.ajax({
                    type: 'PUT',
                    url: appurl+'v1/pendampingan/update/'+threadId,
                    headers: {
                        "Authorization" : "Bearer "+token_user,
                        "Content-Type" : "application/x-www-form-urlencoded", 
                        "Accept" : "application/x-www-form-urlencoded"
                    },
                    data: pesan
                    })
                    .done(function(response){
                        hideLoading()
                        $("#listChat").append(
                            '<li class="clearfix odd">'+
                                '<div class="chat-avatar">'+
                                    '<img src="assets/images/users/avatar.png" alt="male">'+
                                '</div>'+
                                '<div class="conversation-text">'+
                                    '<div class="ctext-wrap">'+
                                        '<i>Anda</i>'+
                                        '<p>'+document.getElementById('pesan').value+'</p>'+
                                    '</div>'+
                                '</div>'+
                            '</li>'
                        )
                        // console.log(response)
                        document.getElementById('pesan').value =""
                    })
                    .fail(function(response){
                        swal("Terjadi Kesalahan", "Cek koneksi internet Anda")
                        // console.log(response)
                    })

                }
            </script>

            <style>
            @media only screen and (max-width:400px){
                .chat-avatar{
                    display: none!important
                }
            }
            </style>
@endsection