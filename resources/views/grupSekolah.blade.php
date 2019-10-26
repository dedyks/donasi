@extends('layout.dashboard')
@section('content')
<link href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                    <div class="col-md-12">
                            <div class="panel panel-color panel-custom">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Chatting Sekolah</h3>
                                </div>
                                <div class="panel-body">                                         
                                        <!-- CHAT -->
                                        <div class="col-lg-12">
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
                                                                <button class="btn btn-md btn-info btn-block waves-effect waves-light" onclick="sendchatLobbySekolah()"><i style="display:none" id="iconLoading" class="fa fa-spin fa-spinner"> </i><span id="sendText">Send</span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                {{-- </div> --}}
                
                                            </div> <!-- end col-->
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
<script>
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user=getCookie("token_login_user_gsm")
    var headers = {
        headers : {
        "Accept" : "application/json", 
        "Content-Type" : "application/json", 
        "Authorization" : "Bearer "+token_user
        }
    }
    $(document).ready(function(){
        var data_diri = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
        var id_user = data_diri._id
        axios.get(appurl+'v1/pendampingan/lobby', headers)
        .then(function(response){
            document.getElementById('loading').style.display="none"
            localStorage.setItem("threadIdGrupSekolah", response.data.thread._id)
            var length = response.data.message.length
            for(var i = 0 ; i < length ; i++){
                if(response.data.message[i].user_id == id_user){
                    var classChat = "clearfix odd"
                    var subject = "Anda"
                    var message = response.data.message[i].body
                }else{
                    var classChat = "clearfix"
                    var subject = response.data.message[i].user.name
                    var message = response.data.message[i].body
                }
                $("#listChat").append(
                '<li class="'+classChat+'">'+
                    '<div class="chat-avatar">'+
                        '<img src="assets/images/users/avatar.png" alt="male">'+
                    '</div>'+
                    '<div class="conversation-text">'+
                        '<div class="ctext-wrap">'+
                            '<i>'+subject+'</i>'+
                            '<p>'+message+'</p>'+
                        '</div>'+
                    '</div>'+
                '</li>'
            )
            }

        })
        .catch(function(err){
            document.getElementById('loading').style.display="none"
            swal("Terjadi Kesalahan", "Mohon cek koneksi internet Anda")
            console.log(err)
        })
    })

    function sendchatLobbySekolah(){
        showLoading()
        var appurl = localStorage.getItem("url_elearning_gsm")
        var token_user=getCookie("token_login_user_gsm")
        var threadIdGrupSekolah =  localStorage.getItem("threadIdGrupSekolah")
        var pesan = { "message" : document.getElementById('pesan').value}
        $.ajax({
        type: 'PUT',
        url: appurl+'v1/pendampingan/update/'+threadIdGrupSekolah,
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
            document.getElementById('pesan').value =""
        })
        .fail(function(response){
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
            document.getElementById('pesan').value =""
            // swal("Terjadi Kesalahan", "Cek koneksi internet Anda")
            // console.log(response)
        })
    }
</script>

@endsection