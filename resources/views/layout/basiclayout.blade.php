<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        {{-- <link rel="shortcut icon" href="{{asset('assets/images/gsm_logo.png')}}"> --}}
        <title>E-Learning GSM</title>
        {{-- <link href="{{asset('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}" rel="stylesheet" /> --}}
        {{-- <link href="{{asset('assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" /> --}}
        {{-- <link href="{{asset('assets/plugins/multiselect/css/multi-select.css')}}"  rel="stylesheet" type="text/css" /> --}}
        {{-- <link href="{{asset('assets/plugins/select2/css/select2.min.css" rel="stylesheet')}}" type="text/css" /> --}}
        <link href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" />
        {{-- <link href="{{asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" /> --}}

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://kit.fontawesome.com/c3094cfefd.js"></script>


        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
        {{-- <script src="assets/js/modernizr.min.js"></script> --}}
         <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

  <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-app.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/6.2.4/firebase-firestore.js"></script>
<script>
    // TODO: Replace the following with your app's Firebase project configuration
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
  <script src="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.js"></script>
<link type="text/css" rel="stylesheet" href="https://cdn.firebase.com/libs/firebaseui/3.5.2/firebaseui.css" />

  

    </head>


    <body class="fixed-left">
    
        <!-- Begin page -->
        <div id="wrapper">



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            @yield('content')
            
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        </div>
        <!-- END wrapper -->
        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/detect.js')}}"></script>
        <script src="{{asset('assets/js/fastclick.js')}}"></script>
        <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('assets/js/waves.js')}}"></script>
        <script src="{{asset('assets/js/wow.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>

        {{-- <script src="{{asset('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js')}}"></script> --}}
        {{-- <script src="{{asset('assets/plugins/switchery/js/switchery.min.js')}}"></script> --}}
        {{-- <script type="text/javascript" src="{{asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}"></script> --}}
        {{-- <script type="text/javascript" src="{{asset('assets/plugins/jquery-quicksearch/jquery.quicksearch.js')}}"></script> --}}
        {{-- <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script> --}}
        <script src="{{asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
        {{-- <script src="{{asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script> --}}
        {{-- <script src="{{asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script> --}}
        {{-- <script src="{{asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script> --}}
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

        <link rel="stylesheet" href="{{asset('assets/plugins/pace_master/themes/red/pace-theme-minimal.css')}}">
        <script src="{{asset('assets/plugins/pace_master/pace.js')}}" type="text/javascript"></script>

        {{-- GSM --}}
        <script src="{{asset('assets/js/gsm.js')}}"></script>       

        {{-- <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/jquery.mockjax.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/jquery.autocomplete.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/countries.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/pages/autocomplete.js')}}"></script> --}}

        {{-- <script type="text/javascript" src="{{asset('assets/pages/jquery.form-advanced.init.js')}}"></script> --}}


		<script src="{{asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('assets/js/jquery.app.js')}}"></script>

        <script src="{{asset('assets/plugins/tinymce/tinymce.min.js')}}"></script>       
        <script type="text/javascript">
        	$(document).ready(function () {
                var vpsurl = "{{env('VPS_URL')}}"
                var appurl = "{{env('APP_URL')}}"
                localStorage.setItem("url_elearning_gsm", appurl)
			});
        </script>



    </body>
</html>