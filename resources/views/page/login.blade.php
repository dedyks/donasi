@extends('layout.basiclayout')
@section('content')

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
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


<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class=" card-box">
    <div class="panel-heading">
        <h3 class="text-center"> Login ke <strong class="text-custom">E-Learning GSM</strong> </h3>
    </div>



    <div class="panel-body" style="text-align:center">
    <img style="text-align:center;display:none" src="assets/images/ajax-loader.gif" id="loading" alt="image" style="margin-bottom:10px" class="img-rounded" width="50"/>
    <form class="form-horizontal m-t-20" enctype="multipart/form-data" method="post" name="loginform">

        <div class="form-group ">
            <div class="col-xs-12">
                <input class="form-control" type="text" required="" id="email" placeholder="Email" value="">
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <input class="form-control" type="password" required="" id="password" placeholder="Password" value="">
            </div>
        </div>

        <div class="form-group text-center m-t-40">
            <div class="col-xs-12">
                <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="button" id="login">Login</button>
            </div>
        </div>

        <div class="form-group m-t-30 m-b-0">
            <div class="col-sm-12">
                <a href="{{ url('/resetpassword') }}" class="text-dark"><i class="fa fa-lock m-r-5"></i> Lupa Password ?</a>
            </div>
        </div>
    </form>
    <div></div>

    </div>
    </div>
        <div class="row">
        <div class="col-sm-12 text-center">
            <p>Belum punya akun ? <a href="{{ url('/daftar') }}" class="text-primary m-l-5"><b>Daftar Sekarang</b></a></p>

            </div>
    </div>

                  
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

</div>
<script>
    var resizefunc = [];
    $(document).ready(function(){
        localStorage.removeItem("data_user_profile");
        localStorage.removeItem("data_user_elearning_gsm");
    })
</script>

<script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
<script src="{{asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>
<script src="{{asset('assets/js/fcm.js')}}"></script>   
@endsection
