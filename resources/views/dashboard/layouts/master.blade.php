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

    <link href="{{asset('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/multiselect/css/multi-select.css')}}"  rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/select2/css/select2.min.css" rel="stylesheet')}}" type="text/css">
    <link href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">

    <link href="{{asset('assets/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
		<link href="{{asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
		<link href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
		<link href="{{asset('assets/plugins/clockpicker/css/bootstrap-clockpicker.min.css')}}" rel="stylesheet">
		<link href="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">


    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/plugins/pace_master/themes/blue/pace-theme-minimal.css')}}" rel="stylesheet">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    {{-- GSM --}}
    <script src="{{asset('assets/js/gsm.js')}}"></script>

    @yield('css')

    <style>
        /* Set the size of the div element that contains the map */
       #map {
         height: 400px;  /* The height is 400 pixels */
         width: 100%;  /* The width is the width of the web page */
        }
     </style>

  </head>

  <body class="fixed-left">

    <div id="wrapper">
        <!-- Top Bar Start -->
        <div class="topbar">
            <!-- LOGO -->
            <div class="topbar-left">
                <div class="text-center">
                    <a href="index.html" class="logo"><span>Dashboard GSM</span></a>
                    <!-- Image Logo here -->
                    <!--<a href="index.html" class="logo">-->
                        <!--<i class="icon-c-logo"> <img src="assets/images/logo_sm.png" height="42"/> </i>-->
                        <!--<span><img src="assets/images/logo_light.png" height="20"/></span>-->
                    <!--</a>-->
                </div>
            </div>

            <!-- Button mobile view to collapse sidebar menu -->
            <div class="navbar navbar-default" role="navigation">
                <div class="container">
                    <div class="">
                        <div class="pull-left">
                            <button class="button-menu-mobile open-left waves-effect waves-light">
                                <i class="md md-menu"></i>
                            </button>
                            <span class="clearfix"></span>
                        </div>

                        <ul class="nav navbar-nav navbar-right pull-right">
                            <!-- <li class="dropdown top-menu-item-xs">
                                <a href="#" data-target="#" class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="true">
                                    <i class="icon-bell"></i> <span class="badge badge-xs badge-danger">0</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-lg">
                                    <li>
                                        <a href="javascript:void(0);" class="list-group-item text-right">
                                            <small class="font-600">See all notifications</small>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
                            <li class="hidden-xs">
                                <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                            </li>

                            <li class="dropdown top-menu-item-xs">
                                <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true" id="userPhoto"></a>
                                <ul class="dropdown-menu">
                                    <!-- <li><a href="javascript:void(0)"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li> -->
                                    <!-- <li class="divider"></li> -->
                                    <li><a href="#" onclick="logout()"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <!-- Top Bar End -->

        @include('dashboard.layouts.module.sidebar')

        @yield('content')

        @include('dashboard.layouts.module.footer')

    </div>

    <script>
        var resizefunc = [];
    </script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="{{asset('assets/js/modernizr.min.js')}}"></script>

    <!-- <script src="{{asset('assets/js/jquery.min.js')}}"></script> -->
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/detect.js')}}"></script>
    <script src="{{asset('assets/js/fastclick.js')}}"></script>
    <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('assets/js/waves.js')}}"></script>
    <script src="{{asset('assets/js/wow.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>

    <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
    <script src="{{asset('assets/plugins/morris/morris.min.js')}}"></script>
    <script src="{{asset('assets/plugins/raphael/raphael-min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>

    <script src="{{asset('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{asset('assets/plugins/switchery/js/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/jquery-quicksearch/jquery.quicksearch.js')}}"></script>
    <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/pages/jquery.todo.js')}}"></script>

    <script src="{{asset('assets/pages/jquery.chat.js')}}"></script>
    <script src="{{asset('assets/js/jquery.core.js')}}"></script>
    <script src="{{asset('assets/js/jquery.app.js')}}"></script>
    <script src="{{asset('assets/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('assets/pages/jquery.dashboard_2.js')}}"></script>

    <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/jquery.autocomplete.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/countries.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/pages/jquery.form-advanced.init.js')}}"></script>

    <script src="{{asset('assets/plugins/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/plugins/pace_master/pace.js')}}" type="text/javascript"></script>

    <script src="{{asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>

    <script>
      jQuery(document).ready(function($){
        var vpsurl = "{{env('VPS_URL')}}"
        var appurl = "{{env('APP_URL')}}"
        localStorage.setItem("url_elearning_gsm", appurl)

        var token_user=getCookie("token_login_user_gsm")
        if(token_user==""){
            window.location="{{ url('/dashboard/login') }}";
        }
        var linkfoto = localStorage.getItem("userPhoto")
        if(linkfoto !== null){
          $('#userPhoto').append(
          '<img  src="{{ url('/') }}/storage/images/500/'+linkfoto+'"  class="img-circle"  width="200"/>'
          )
        }else{
          $('#userPhoto').append(
          '<img  src="{{ asset('assets/images/users/avatar.png') }}" class="img-circle"  width="200"/>'
          )
        }
      });
    </script>

    <script>
      function logout() {
        var x = getCookie('token_login_user_gsm');

        $.ajax({
          type: 'GET',
          url: "{{ url('/') }}/api/v1/logout",
          headers: {"Authorization": "Bearer " + x}
        })
        .done(function(data, status){
          console.log(status);
          delete_cookie('token_login_user_gsm');
          localStorage.removeItem('userPhoto');
          localStorage.removeItem('data_user_elearning_gsm');
          localStorage.removeItem('tokenFCM');
          localStorage.removeItem('url_elearning_gsm');
          swal({
            title: "Sampai jumpa lagi",
            text: "Anda akan keluar dari Dashboard GSM. \n\n Message: "+data.message,
            type: "success",
            timer: 2000,
            showConfirmButton: false
          });
          window.setTimeout(function(){
            window.location = "{{ url('/dashboard/login') }}";
          }, 2000);

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
    </script>

    <script>
        function delete_cookie(cname) {
            document.cookie = cname +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }

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

    @yield('js')

  </body>
</html>
