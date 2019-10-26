<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-messaging.js"></script>


<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyD2_vmbS_W2BiPqwcupWyYKA4_iyOA9ZSY",
    authDomain: "elearning-dev-4a8be.firebaseapp.com",
    databaseURL: "https://elearning-dev-4a8be.firebaseio.com",
    projectId: "elearning-dev-4a8be",
    storageBucket: "elearning-dev-4a8be.appspot.com",
    messagingSenderId: "301304677986",
    appId: "1:301304677986:web:63e9558835dda44acb733b",
    measurementId: "G-27DVN1VLZW"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>  
<div class="topbar">
    <!-- LOGO -->
    <div class="topbar-left">
        <div class="text-center">
            <a href="elearning" class="logo"><span>E-Learning GSM</span></a>
        </div>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                    <div class="row" style="display:none">
                            <div class=col-lg-12>
                                <div class=card-box>
                                <div id="token_div">
                                  <h4>Instance ID Token</h4>
                                  <p id="token" style="word-break: break-all;"></p>
                                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                                          onclick="deleteToken()">Delete Token</button>
                                </div>
                                <!-- div to display the UI to allow the request for permission to
                                    notify the user. This is shown if the app has not yet been
                                    granted permission to notify. -->
                                <div id="permission_div">
                                  <h4>Needs Permission</h4>
                                  <p id="token"></p>
                                  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"
                                          onclick="requestPermission()">Request Permission</button>
                                </div>
                                <!-- div to display messages received by this app. -->
                                <div id="messages"></div>
                                </div>
                            </div>
                    </div>

                <div class="pull-left">
                    <button class="button-menu-mobile open-left waves-effect waves-light">
                        <i class="md md-menu"></i>
                    </button>
                    <span class="clearfix"></span>
                </div>

                {{-- Dropadown button --}}
                <ul class="nav navbar-nav navbar-right pull-right">
                        <li class="dropdown top-menu-item-xs">
                                {{-- <a href="#" onclick="openNotif()" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"> --}}
                                <a href="#" onclick="openNotif()">    
                                    <i class="icon-bell" ></i> <span class="badge badge-xs badge-danger" id="notification"></span>
                                    <input type="text" id="notifShow" value="show" style="display:none">
                                </a>
                                <ul id="testing" class="dropdown-menu dropdown-menu-lg notifInMedia">
                                    <div id="tes">
                                            <li style="" class="notifi-title" ><span style="cursor:pointer" onclick="loadmorenotif()" class="label label-default pull-right" id="notification2"></span>Belum dilihat</li>
                                            <li class="list-group slimscroll-noti notification-list notifHeight" id="listNotifUnread">
                                            </li>
        
                                            <li class="notifi-title">Sudah dilihat</li>                
                                            <li class="list-group slimscroll-noti notification-list notifHeight" id="listNotifRead">
                                            </li>
                                    </div>
                                    
                                    <li onclick="readAll()">
                                        <a href="javascript:void(0);" class="list-group-item text-right">
                                            <small class="font-600">Tandai semua sudah dilihat</small>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                    </li>
                    <li class="dropdown top-menu-item-xs">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true" id="fotoUserHeader"></a>
                        <ul class="dropdown-menu">
                            <li onclick="logout()"><a href="javascript:void(0)"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
                <input type="text" value="1" id="notifPage" style="display:none" autocomplete="off">
                {{-- Logout button --}}
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{asset('assets/js/fcm.js')}}"></script> 
<script src="{{asset('assets/js/gsm.js')}}"></script>       
<script>
$(document).ready(function(){
    var token_user=getCookie("token_login_user_gsm")
    if(token_user==""){
            window.location="login"
    }
    var appurl = localStorage.getItem("url_elearning_gsm") 
    var page = document.getElementById('notifPage').value
    getnotification(appurl, token_user, page)
    var urlImage = {!! json_encode(url('/')) !!} 
    var linkfoto = localStorage.getItem("fotoUser")
    if(linkfoto !== null){
    $('#fotoUserHeader').append(
    '<img  src="'+urlImage+'/storage/images/500/'+linkfoto+'"  class="img-circle"  width="200"/>'
    )
    }else{
    $('#fotoUserHeader').append(
    '<img  src="{{asset('assets/images/users/avatar.png')}}" class="img-circle"  width="200"/>'
    )
    }
})

// function deleteToken() {
//     console.log("Ini dari delete token")
//     // Delete Instance ID token.
//     // [START delete_token]
//     messaging.getToken().then((currentToken) => {
//       messaging.deleteToken(currentToken).then(() => {
//         console.log('Token deleted.');
//         setTokenSentToServer(false);
//       }).catch((err) => {
//       });
//       // [END delete_token]
//     }).catch((err) => {
//       showToken('Error retrieving Instance ID token. ', err);
//     });
// }

function setTokenSentToServer(sent) {
    window.localStorage.setItem('sentToServer', sent ? '1' : '0');
}


function openNotif(){
    document.getElementById('notification').style.display="none"
    if(document.getElementById('notifShow').value=="show"){
        document.getElementById('testing').style.display="block"
        document.getElementById('notifShow').value="dontshow"
    }else{
        document.getElementById('testing').style.display="none"
        document.getElementById('notifShow').value="show"
    }
}


function loadmorenotif(){
    var token_user=getCookie("token_login_user_gsm")
    var appurl = localStorage.getItem("url_elearning_gsm") 
    var page = document.getElementById('notifPage').value
    getnotification(appurl, token_user, page)
}

function getnotification(appurl, token_user, page){
    axios.get(appurl+"v1/notification?page="+page, {headers :{
        "Authorization" : "Bearer "+token_user
    }})
    .then(res=>{
        document.getElementById('notification').innerHTML = res.data.unread_count
        document.getElementById('notification2').innerHTML = 'Muat Lainnya'
        var dataNotifikasi = res.data.data.data
        var jumlahNotif = res.data.data.data.length
        var urlImage = {!! json_encode(url('/')) !!} 
        var nextPage = res.data.data.next_page_url
        if(nextPage == null){
            document.getElementById('notification2').style.display = "none"
        }   
        for(var i = 0; i < jumlahNotif; i++){
            var lengthphoto = dataNotifikasi[i].user_data.photo_profile.length
            if(lengthphoto == 0){
                var photo2 ='<img  src="{{asset('assets/images/users/avatar.png')}}"   class="img-circle authorImage"  />'
            }else{
                var photo2 =  '<img  src="'+urlImage+'/storage/images/500/'+dataNotifikasi[i].user_data.photo_profile[0].filename+'"   class="img-circle authorImage"  />'
            }
            var userName = dataNotifikasi[i].user_data.name
            var type = dataNotifikasi[i].type
            if(type == "like"){
                var msg = "Menyukai konten berbagi Anda"
            }else if(type=="comment"){
                var msg = "Mengomentari konten berbagi Anda"
            }
            var statusRead = dataNotifikasi[i].read
            var idKonten = dataNotifikasi[i].artikel_data.article_id
            var idNotif =  dataNotifikasi[i]._id
            if(statusRead == true){
            $('#listNotifRead').append(
                '<div class="list-group-item" style="cursor:pointer" onclick="gotokonten(\''+idKonten+'\', \''+idNotif+'\')">'+
                    '<div class="media">'+
                        '<div class="pull-left p-r-10">'+
                            photo2+
                        '</div>'+
                        '<div class="media-body">'+
                        '<h5 class="media-heading">'+userName+'</h5>'+
                        '<p class="m-0">'+
                            '<small>'+msg+'</small>'+
                        '</p>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            )
            }else{
                $('#listNotifUnread').append(
                '<div class="list-group-item" style="cursor:pointer" onclick="gotokonten(\''+idKonten+'\', \''+idNotif+'\')">'+
                    '<div class="media">'+
                        '<div class="pull-left p-r-10">'+
                            photo2+
                        '</div>'+
                        '<div class="media-body">'+
                        '<h5 class="media-heading">'+userName+'</h5>'+
                        '<p class="m-0">'+
                            '<small>'+msg+'</small>'+
                        '</p>'+
                        '</div>'+
                    '</div>'+
                '</div>'
            )
            }
        }

        document.getElementById('notifPage').value = parseInt(document.getElementById('notifPage').value, 10) + 1
        
    })
    .catch(err=>{
        console.log(err)
    })

}

function readAll(){
    var token_user=getCookie("token_login_user_gsm")
    var appurl = localStorage.getItem("url_elearning_gsm") 
    var data = ''
    axios.post(appurl+"v1/notification/read-all", data,  {headers :{
        "Authorization" : "Bearer "+token_user
    }})
    .then(res=>{
        swal("Tandai berhasil", "Semua pesan telah dilihat")
        window.location.reload();
    })
    .catch(err=>{
        swal("Mohon Maaf", "Terjadi kesalahan, silahkan cek koneksi internet Anda")
    })
}
function gotokonten(idKonten, idNotif){
    var token_user=getCookie("token_login_user_gsm")
    var appurl = localStorage.getItem("url_elearning_gsm") 
    var data = ''
    axios.post(appurl+"v1/notification/read/"+idNotif, data,  {headers :{
        "Authorization" : "Bearer "+token_user
    }})
    .then(res=>{
        window.location = "detailkonten?id="+idKonten
    })
    .catch(err=>{
        swal("Mohon Maaf", "Terjadi kesalahan, silahkan cek koneksi internet Anda")
    })
   
}
</script>

<style>
#tes .slimScrollDiv{
    max-height: 150px!important;
    padding: .5rem;
    -webkit-overflow-scrolling: touch;
    -ms-overflow-style: none;
    overflow: auto
}

@media only screen and (max-width: 400px) {
.authorImage{
    float:left;margin-right:15px;width:40px;height:40px
}

}

.authorImage{
    float:left;margin-right:15px;width:50px;height: 50px;
}


.notification-list {
    max-height: 150px!important;
}

@media only screen and (max-width: 770px) {
.notifInMedia{
margin-left: -150px
}
}





</style>