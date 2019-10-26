@extends('assessor.layouts.master')
@section('title')
  <title>Assessor Dashboard GSM - Pendampingan</title>
@endsection

@section('content')
<div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                        <div class="col-sm-12">
                                <h4 class="page-title">Pendampingan</h4>
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="{{ url('assessor/') }}">Home</a>
                                    </li>
                                    <li>
                                        Pendampingan
                                    </li>
                                    <li>
                                        <a href="{{ url('assessor/pendampingan/listuser/') }}">List User</a>
                                    </li>
                                    <li>
                                            <a href="{{ url('assessor/pendampingan/pagependampingan/') }}">Page User : <span id="namaUser"></span></a>
                                        </li>
                                </ol>
                        </div>
                </div>
                
                <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-color panel-custom">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Detail User </h3>
                                </div>
                                <div class="panel-body">
                                <div class="col-sm-4" id="fotoUser">
                                    </div>
                                    <div class="col-md-4">
                                    <h5><b>Nama :</b></h5>
                                    <p class="text-muted m-b-15 font-13" id="name">
                                        Loading
                                    </p>

                                    <h5><b>Tempat Lahir :</b></h5>
                                    <p class="text-muted m-b-15 font-13" id="birthplace">
                                        Loading
                                    </p>
                                    <h5><b>Tanggal Lahir :</b></h5>
                                    <p class="text-muted m-b-15 font-13" id="birthdate">
                                        Loading
                                    </p>
                                    <h5><b>Nomor WA :</b></h5>
                                    <p class="text-muted m-b-15 font-13" id="phone">
                                        Loading
                                    </p>
                                    </div>
                                    <div class="col-md-4">
                                    <h5><b>Sudah Ikut Workshop :</b></h5>
                                    <p class="text-muted m-b-15 font-13" id="attendedWorkshop">
                                        Loading
                                    </p>
                                    <h5><b>Gender :</b></h5>
                                    <p class="text-muted m-b-15 font-13" id="gender">
                                        Loading
                                    </p>
                                    <h5><b>Posisi di Sekolah :</b></h5>
                                    <p class="text-muted m-b-15 font-13" id="position">
                                        Loading
                                    </p>
                                    <h5><b>Pendidikan Terakhir :</b></h5>
                                    <p class="text-muted m-b-15 font-13" id="lastEducation">
                                        Loading
                                    </p>
                                    <input type="text" id="id" style="display:none">
                                </div>
                                </div>
                            </div>
                        </div>                        
                </div>

                <div class="row">
                    {{-- User Activity --}}
                    <div class="col-md-4">
                       <div class="panel panel-color panel-custom">
                               <div class="panel-heading">
                                   <h3 class="panel-title">Modul Sedang Dipelajari</h3>
                               </div>
                               <div class="panel-body" style="height: 300px;overflow: auto;" id="list_modul_enrolled">
                                   {{-- Block Code --}}
                               </div>
                           </div>
                       </div> 
                       <div class="col-md-4">
                           <div class="panel panel-color panel-custom">
                                   <div class="panel-heading">
                                       <h3 class="panel-title">Tantangan Modul Dijawab</h3>
                                   </div>
                                   <div class="panel-body" style="height: 300px;overflow: auto;" id="list_modul_answered">
                                       {{-- Block Code --}}
                                   </div>
                               </div>
                           </div> 
                           <div class="col-md-4">
                               <div class="panel panel-color panel-custom">
                                       <div class="panel-heading">
                                           <h3 class="panel-title">Tantangan Modul Dinilai</h3>
                                       </div>
                                       <div class="panel-body" style="height: 300px;overflow: auto;" id="list_modul_scored">
                                           {{-- Block Code --}}
                                       </div>
                                   </div>
                               </div> 
                            <div class="col-md-12">
                                <div class="panel panel-color panel-custom">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Akses Materi Advanced</h3>
                                    </div>
                                    <div class="panel-body">
                                       <p>Berikan akses ke user ini untuk mengambil materi level advanced</p>
                                       <p id="aksesOpened" style="display:none;color:red">Anda telah memberikan akses materi advanced pada user ini</p>
                                       <button id="aksesButton" style="margin-top:10px" class="btn btn-default waves-effect waves-light" onclick="advancedAkses()">Beri Akses</button>
                                    </div>
                                </div>
                            </div>
               </div>

               <div class="row">
                <div class="col-lg-12">
                                <div class="panel panel-color panel-custom">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Chat Dengan User </h3>
                                    </div>
                                    <div class="panel-body">                                         
                                            <!-- CHAT -->
                                            <div class="col-lg-12">
                                                    {{-- <div class="card-box">     --}}
                                                        <div class="chat-conversation">
                                                            <ul class="conversation-list nicescroll" id="listChat">
                                                            <div class="col-md-12" style="text-align:center;display:block;" id="loading">
                                                                    <img src="{{asset('assets/images/ajax-loader.gif')}}" alt="image" style="" class="img-rounded" width="50"/>
                                                                </div>
                                                            </ul>
                                                            <div class="row">
                                                                <div class="col-sm-9">
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
                                    </div>
                                </div>
                            </div>

@endsection


@section('js')
<script src="{{asset('assets/js/gsm.js')}}"></script>       
<script>
        $(document).ready(function(){
            var appurl = localStorage.getItem("url_elearning_gsm")
            var token_user=getCookie("token_login_user_gsm")
            var user_id = localStorage.getItem("id_usernya_assessor")
            var user_id2 = { "user_id_lawan" : user_id}
            var namaUser = localStorage.getItem("user_name")
            document.getElementById('namaUser').innerHTML = namaUser
            showthread2users(appurl, token_user, user_id2)
            detailUser(appurl,user_id )
            getUserAct(appurl, token_user, user_id)
        })

        function advancedAkses(){
            var user_id = localStorage.getItem("id_usernya_assessor")
            var appurl = localStorage.getItem("url_elearning_gsm")
            var token_user=getCookie("token_login_user_gsm")
            var formData =new FormData()
            formData.append("level", "advanced")

            $.ajax({
            type: 'POST',
            url: appurl+'v1/admin/user/level/'+user_id,
            headers: {
                "Accept" : "application/x-www-form-urlencoded",
                "Authorization" : "Bearer "+token_user
            }, 
            data : formData, 
            processData: false,
            contentType: false
            })
            .done(function(response){
                swal("Berhasil", "Anda telah membuka akses materi advanced untuk user ini")
                document.getElementById('aksesOpened').style.display="block"
                document.getElementById('aksesButton').style.display = "none"

            })
        .fail(function(response){
            swal("Terjadi Kesalahan ", "Silahkan cek koneksi internet Anda")
        })
        }
        
        function getUserAct(appurl, token_user, user_id){
            console.log("Hello")
            $.ajax({
            type: 'GET',
            url: appurl+'v1/admin/quiz/user/'+user_id,
            headers: {
                "Authorization" : "Bearer "+token_user,
            }
            })
            .done(function(response){
                var length =  response.data.length
                var data= response.data
                ModulOnUserAct('enrolled', '#list_modul_enrolled', length, data)
                ModulOnUserAct('answered', '#list_modul_answered', length, data)
                ModulOnUserAct('scored', '#list_modul_scored', length, data)

            })
        .fail(function(response){
            console.log("Hello from fail")
            console.log(response)
        })
        }

        function ModulOnUserAct(status, id, length, data){
    for(var i=0; i<length;i++){
        if(data[i].flag == status){
            switch(data[i].modul.aspect){
                case "ekosistem-positif":
                        // code block
                        var category_materi = "Penciptaan Ekosistem Positif di Sekolah"
                    break;
                case "trisentra-pendidikan":
                    // code block
                    var category_materi = "Tri Sentra Pendidikan"
                    break;
                case "pengembangan-karakter":
                    // code block
                    var category_materi = "Pengembangan Karakter"
                    break;
                case "pembelajaran-riset":
                    // code block
                    var category_materi = "Pembelajaran Berbasis Riset"
                    break;
            }
            $(id)
            .append(
                '<div class="row" style="margin-bottom:20px;cursor:pointer">'+
                    '<div class="col-md-12" style="font-size:12px">'+
                        '<p style="margin-bottom:1px"><b>'+data[i].modul.title+'</b></p>'+
                        '<p style="margin-top:0px" >Kategori : '+category_materi+'</p>'+
                        '<p style="margin-top:0px" >Level : '+data[i].modul.grade+'</p>'+
                    '</div>'+
                '</div>'+
                '<hr>'
            )
        }
    }
}

        function showthread2users(appurl, token_user, user_id2){
            $.ajax({
            type: 'POST',
            url: appurl+'v1/pendampingan/thread2users',
            headers: {
                "Authorization" : "Bearer "+token_user,
                "Content-Type" : "application/x-www-form-urlencoded", 
                "Accept" : "application/x-www-form-urlencoded"
            },
            data: user_id2
            })
            .done(function(response){
            var x = document.getElementById("loading")
            x.style.display = "none"
            console.log(response)
            localStorage.setItem("thread_id", response.thread._id)
            var length = response.message.length
            for(var i = 0 ; i<length;i++){
                if(response.message[i].user.role == "assessor"){
                    var classChat = "clearfix"
                    var subject = "Anda"
                    var message = response.message[i].body
                }else{
                    var classChat = "clearfix odd"
                    var subject = "User"
                    var message = response.message[i].body
    
                }
                $("#listChat").append(
                '<li class="'+classChat+'">'+
                    '<div class="chat-avatar">'+
                        '<img src="{{asset('assets/images/users/avatar.png')}}" alt="male">'+
                        
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
        .fail(function(response){
            var x = document.getElementById("loading")
            x.style.display = "none"
            console.log(response)
        })
        }

        function sendchat(){
                    showLoading()
                    var appurl = localStorage.getItem("url_elearning_gsm")
                    var token_user=getCookie("token_login_user_gsm")
                    var threadId = localStorage.getItem("thread_id")
                    var pesan = { "message" : document.getElementById('pesan').value}
                    console.log(pesan)
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
                            '<li class="clearfix">'+
                                '<div class="chat-avatar">'+
                                    '<img src="{{asset('assets/images/users/avatar.png')}}" alt="male">'+
                                '</div>'+
                                '<div class="conversation-text">'+
                                    '<div class="ctext-wrap">'+
                                        '<i>Anda</i>'+
                                        '<p>'+document.getElementById('pesan').value+'</p>'+
                                    '</div>'+
                                '</div>'+
                            '</li>'
                        )
                        console.log(response)
                        document.getElementById('pesan').value =""
                    })
                    .fail(function(response){
                        swal("Terjadi Kesalahan", "Cek koneksi internet Anda")
                        console.log(response)
                    })
                }

        function detailUser(appurl, id){
            axios.get(appurl+'v1/users/'+id)
            .then(function (response) {
                if(response.data.level == "advanced"){
                    document.getElementById('aksesOpened').style.display="block"
                    document.getElementById('aksesButton').style.display = "none"
                }
                var jumlahfoto = response.data.photo_profile.length
                var urlImage = {!! json_encode(url('/')) !!}

                if(jumlahfoto > 0){
                $('#fotoUser').append(
                '<img  src="'+urlImage+'/storage/images/'+response.data.photo_profile[0].filename+'"  class="img-rounded"  width="200"/>'
                )
                }else{
                $('#fotoUser').append(
                '<img  src="{{asset('assets/images/users/avatar.png')}}" class="img-rounded"  width="200"/>'
                )
                }

                localStorage.setItem('data_user_profile', JSON.stringify(response.data))
                    var data_user_profile = JSON.parse(localStorage.getItem("data_user_profile"))
                    document.getElementById('name').innerHTML = data_user_profile.name
                    document.getElementById('birthplace').innerHTML = data_user_profile.detail.birthplace
                    document.getElementById('birthdate').innerHTML = data_user_profile.detail.birthdate
                    document.getElementById('position').innerHTML = data_user_profile.detail.position
                    document.getElementById('phone').innerHTML = data_user_profile.detail.phone
                    if(data_user_profile.attendedWorkshop){
                        var attendedWorkshop = "Sudah Pernah"
                    }else{
                        var attendedWorkshop = "Belum Pernah"
                    }
                    document.getElementById('attendedWorkshop').innerHTML = attendedWorkshop
                    document.getElementById('lastEducation').innerHTML = data_user_profile.detail.lastEducation
                    document.getElementById('gender').innerHTML = data_user_profile.detail.gender
            })
            .catch(function (error) {
                swal("Whops", "Beberapa data belum diupdate oleh user, beri tahu user untuk mengisinya")
            })
        }

        
        </script>
@endsection    




