@extends('layout.basiclayout')
@section('content')

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">


<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
    <div class=" card-box">
    <div class="panel-heading" style="margin-bottom:-20px"> 
        <h3 class="text-center"> Halaman <strong class="text-custom">Lupa Password</strong> </h3>
        <p style="text-align:center;font-size:12px" id="inputEmailMessage">Silhakan masukan alamat email Anda terlebih dahulu </p>
        <p style="text-align:center;font-size:12px;display:none;margin-bottom:-5px" id="resetPasswordMessage">Kami  mengirimkan email berisi link untuk mereset password. Silahkan cek spam bila bila tidak menemukannya</p>
        
    </div> 
    <div class="col-md-12" style="text-align:center;display:none;margin-bottom:10px;margin-top:10px" id="loading">
        <img src="assets/images/ajax-loader.gif" alt="image" style="" class="img-rounded" width="50"/>
    </div>


    <div class="panel-body">
    {{-- <form class="form-horizontal m-t-20" enctype="multipart/form-data" method="post" name="loginform"> --}}
     <form class="form-horizontal m-t-20"  enctype="multipart/form-data" method="post" name="resetpassword">
        <div class="form-group" id="sendEmail">
            <div class="col-xs-12">
                <input class="form-control" type="text" required="" id="email" name="email" placeholder="Email" value="">
            </div>
            {{-- <div class="col-xs-12" id="resetPassword" style="display:none">
                <input style="margin-top:10px" class="form-control" type="password" required="" id="pass1" name="pass1" placeholder="Password Baru" value="">
                <input style="margin-top:10px" class="form-control" type="password" required="" id="pass2" name="pass2" placeholder="Ulangi Password" value="">
                <input style="margin-top:10px" class="form-control" type="text" required="" id="token" name="token" placeholder="Token" value="">
            </div> --}}
        </div>

        <div class="form-group text-center m-t-40">
            <div class="col-xs-12" style="margin-top:-20px" id="sendEmailButton">
                <button class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="button" id="lupapassword">kirim</button>
            </div>

            {{-- <div class="col-xs-12" style="margin-top:-20px;display:none" id="sendResetPassword">
                <button  class="btn btn-info btn-block text-uppercase waves-effect waves-light" type="button" id="resetpassword" onclick="resetpass()">Reset Password</button>
            </div> --}}

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
    
</div>




<script>
    var resizefunc = [];
    function resetpass(){
        document.getElementById('loading').style.display = "block"
        var appurl = localStorage.getItem("url_elearning_gsm")
        var formData = new FormData()
        formData.append("email", document.getElementById('email').value)
        formData.append("password", document.getElementById('pass1').value)
        formData.append("password_confirmation", document.getElementById('pass2').value)
        formData.append("token", document.getElementById('token').value)
        $(document).ajaxStart(function() { Pace.restart(); });
        $.ajax({
        type: 'POST',
        url: appurl+'v1/password/reset',
        data: formData,
        processData: false,
        contentType: false
        })
        .done(function(data, status){
            document.getElementById('loading').style.display = "none"
            swal("Berhasil Diubah", "Mengalihkan ke halaman login")
            window.location = 'login'
        })
        .fail(function(data, status){
            document.getElementById('loading').style.display = "none"
            swal("Terjadi Kesalahan", "Pastikan Anda memasukan data dengan benar dan cek koneksi internet Anda")
        })
    }
</script>

{{-- Sweet Alerts --}}
<script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
<script src="{{asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>




@endsection