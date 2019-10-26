<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    @yield('title')

    <link href="{{asset('assets/plugins/morris/morris.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/pace_master/themes/blue/pace-theme-minimal.css')}}" rel="stylesheet">

    <title></title>
  </head>
  <body class="fixed-left">
    <div id="wrapper">

      @yield('content')

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
    <script src="{{asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/plugins/pace_master/pace.js')}}" type="text/javascript"></script>

    <script>
        jQuery(document).ready(function($){
            var token_user=getCookie("token_login_user_gsm")
            if(token_user!=""){
                window.location="{{ url('/dashboard') }}"
            }
        });
    </script>

    <script>
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for(var i = 0; i < ca.length; i++){
                var c = ca[i];
                while (c.charAt(0) == ' '){
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    </script>

    <script>
        $('#loginAdmin').click(function(){
            $(document).ajaxStart(function() { Pace.restart(); });
            if(document.getElementById('email').value == "" ||
            document.getElementById('password').value == ""
            ){
                swal("Isilah semua field yang ada")
            } else {
               var data = {
                    email : document.getElementById('email').value,
                    password : document.getElementById('password').value,
                }
                var appurl = localStorage.getItem('url_elearning_gsm')
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/') }}/api/v1/admin/login",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "Accept"      : "application/x-www-form-urlencoded"
                    },
                    data: data
                })
                .done(function(data, status){
                     swal({
                       title: "Selamat",
                       text: "Anda berhasil login",
                       type: "success",
                       timer: 2000,
                       showConfirmButton: false
                     });
                     window.setTimeout(function(){
                       window.location = "{{ url('/dashboard') }}";
                     }, 2000);

                     console.log(status);
                     localStorage.setItem('data_user_elearning_gsm', JSON.stringify(data.data));
                     setCookie("token_login_user_gsm", data.token, 30);
                     if(data.data.photo_profile.length>0){
                        localStorage.setItem('userPhoto', data.data.photo_profile[0].filename)
                     }

                     function setCookie(cname,cvalue,exdays) {
                         var d = new Date();
                         d.setTime(d.getTime() + (exdays*24*60*60*1000));
                         var expires = "expires=" + d.toGMTString();
                         document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                     }

                     function getCookie(cname){
                         var name = cname + "=";
                         var decodedCookie = decodeURIComponent(document.cookie);
                         var ca = decodedCookie.split(';');
                         for(var i = 0; i < ca.length; i++){
                             var c = ca[i];
                             while (c.charAt(0) == ' '){
                                c = c.substring(1);
                             }
                             if (c.indexOf(name) == 0) {
                                return c.substring(name.length, c.length);
                             }
                         }
                         return "";
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
            }
        })
    </script>

  </body>
</html>
