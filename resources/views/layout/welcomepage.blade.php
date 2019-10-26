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

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>
        <style>
            /* Set the size of the div element that contains the map */
           #map {
             height: 400px;  /* The height is 400 pixels */
             width: 100%;  /* The width is the width of the web page */
            }
         </style>
     
    </head>


    <body class="fixed-left">
<!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="/" class="logo">
                            <span style="color:rgb(255, 121, 121)">E</span>
                            <span style="color:rgb(28, 253, 84)">L</span>
                            <span style="color:rgb(255, 187, 0)">e</span>
                            <span style="color:rgb(255, 0, 191)">a</span>
                            <span style="color:rgb(0, 255, 76)">r</span>
                            <span style="color:rgb(247, 101, 101)">n</span>
                            <span style="color:rgb(229, 255, 0)">i</span>
                            <span style="color:rgb(146, 255, 179)">n</span>
                            <span style="color:rgb(0, 225, 255)">g</span>
                            <span style="color:rgb(241, 109, 208)"> G</span>
                            <span style="color:rgb(238, 255, 0)">S</span>
                            <span style="color:rgb(255, 66, 66)">M</span>
                        </a>
                    </div>
                </div>
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                            <ul class="nav navbar-nav navbar-right pull-right" style="margin:20px;">
                                <li style="color:white;letter-spacing: 1px" class="dropdown top-menu-item-xs"> <b> <a  href="{{ url('/login') }}" style="color:rgb(151, 234, 255)"> LOGIN</a></b></li>
                                <li style="color:white;letter-spacing: 1px" class="dropdown top-menu-item-xs"> <b> <span style="color:white"> &nbsp;&nbsp; | &nbsp;&nbsp; </span></b></li>
                                <li style="color:white;letter-spacing: 1px" class="dropdown top-menu-item-xs"> <b> <a  href="{{ url('/daftar') }}" style="color:rgb(255, 139, 245)"> DAFTAR</a></b></li>
                            </ul>                    
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


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
        <!-- jQuery  -->
        {{-- <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
        <script src="{{asset('assets/plugins/morris/morris.min.js')}}"></script>
        <script src="{{asset('assets/plugins/raphael/raphael-min.js')}}"></script> --}}
         <script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>

        <!-- Todojs  -->
        {{-- <script src="{{asset('assets/pages/jquery.todo.js')}}"></script> --}}

        {{-- Select --}}
        <script src="{{asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
        <!-- chatjs  -->
        {{-- <script src="{{asset('assets/pages/jquery.chat.js')}}"></script>
        <script src="{{asset('assets/plugins/peity/jquery.peity.min.js')}}"></script>		 --}}
		<script src="{{asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('assets/js/jquery.app.js')}}"></script>
        {{-- <script src="{{asset('assets/pages/jquery.dashboard_2.js')}}"></script> --}}

        {{-- GSM --}}
        <script src="{{asset('assets/js/gsm.js')}}"></script>     
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  

       
        {{-- Owl Carousel --}}
        <script src="{{asset('assets/plugins/owl.carousel/dist/owl.carousel.min.js')}}"></script>
    <script>
      jQuery(document).ready(function($) {
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
      <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

  



    </body>
</html>