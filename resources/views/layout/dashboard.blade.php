<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        {{-- <link rel="shortcut icon" href="{{asset('assets/images/gsm_logo.png')}}"> --}}

        <title>E-Learning GSM</title>
        <link href="https://fonts.googleapis.com/css?family=Passion+One|Patua+One" rel="stylesheet"> 
        <!--Morris Chart CSS -->
		<link rel="stylesheet" href="{{asset('assets/plugins/morris/morris.css')}}">
        <link href="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.css')}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{asset('assets/plugins/pace_master/themes/red/pace-theme-minimal.css')}}">
        <script src="{{asset('assets/plugins/pace_master/pace.js')}}" type="text/javascript"></script>

        {{-- Owl Carousel  --}}
        <link href="{{asset('assets/plugins/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('assets/plugins/owl.carousel/dist/assets/owl.theme.default.min.css')}}" rel="stylesheet" type="text/css" />

        {{-- Select --}}
        <link href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        {{-- GSM --}}
        <script src="{{asset('assets/js/gsm.js')}}"></script>       
        <script>
        var token_user=getCookie("token_login_user_gsm")
        if(token_user==""){
                window.location="login"
        }
        </script>
        <style>
            /* Set the size of the div element that contains the map */
           #map {
             height: 400px;  /* The height is 400 pixels */
             width: 100%;  /* The width is the width of the web page */
            }
         </style> 
    </head>
    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            @include('layout.header')
            <!-- Top Bar End -->

            {{-- Sidebar --}}
           @include('layout.sidebar')
            {{-- Sidebar --}}
            
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
        {{-- <script src="{{asset('assets/js/jquery.min.js')}}"></script> --}}
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/detect.js')}}"></script>
        <script src="{{asset('assets/js/fastclick.js')}}"></script>
        <script src="{{asset('assets/js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('assets/js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('assets/js/waves.js')}}"></script>
        <script src="{{asset('assets/js/wow.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('assets/js/jquery.scrollTo.min.js')}}"></script>
        <!-- jQuery  -->
        {{-- <script src="{{asset('assets/plugins/moment/moment.js')}}"></script> --}}
        {{-- <script src="{{asset('assets/plugins/morris/morris.min.js')}}"></script> --}}
        {{-- <script src="{{asset('assets/plugins/raphael/raphael-min.js')}}"></script> --}}
        <script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


        {{-- Select --}}
        <script src="{{asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>

        <script src="{{asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('assets/js/jquery.app.js')}}"></script>
       
        {{-- Owl Carousel --}}
        <script src="{{asset('assets/plugins/owl.carousel/dist/owl.carousel.min.js')}}"></script>
        <script src="https://kit.fontawesome.com/c3094cfefd.js"></script>
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>


    <script>
      jQuery(document).ready(function($) {
        function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
            c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
            }
        }
        return "";
        }

        //owl carousel
        $("#owl-slider").owlCarousel({
            loop:true,
            nav:false,
            autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true,
            animateOut: 'fadeOut',
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
        
        $("#owl-slider-2").owlCarousel({
            loop:false,
            nav:false,
            autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:1
                },
                1000:{
                    items:1
                }
            }
        });
        
        //Owl-Multi
        $('#owl-multi').owlCarousel({
            loop:true,
            margin:20,
            nav:false,
            autoplay:true,
            responsive:{
                0:{
                    items:1
                },
                480:{
                    items:2
                },
                700:{
                    items:4
                },
                1000:{
                    items:3
                },
                1100:{
                    items:5
                }
            }
        })
    });
    </script>

<script type="text/javascript">
    $(document).ready(function () {
        // $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable();
        $('#datatable-colvid').DataTable({
            "dom": 'C<"clear">lfrtip',
            "colVis": {
                "buttonText": "Change columns"
            }
        });
        $('#datatable-scroller').DataTable({
            ajax: "assets/plugins/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
        var table = $('#datatable-fixed-col').DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 1,
                rightColumns: 1
            }
        });     
    });
    // TableManageButtons.init();

</script>

    </body>
</html>