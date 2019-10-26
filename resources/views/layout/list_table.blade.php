<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        {{-- <link rel="shortcut icon" href="{{asset('assets/images/gsm_logo.png')}}"> --}}
        <title>E-Learning GSM</title>
        


        <!-- Plugin Css-->
        <link rel="stylesheet" href="{{asset('assets/plugins/magnific-popup/css/magnific-popup.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-editable/datatables.css')}}" />

        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
`       <script src="https://kit.fontawesome.com/c3094cfefd.js"></script>
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
        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            @include('layout.header')
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            @include('layout.sidebar')
            <!-- Left Sidebar End --> 



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

		
		<script src="{{asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('assets/js/jquery.app.js')}}"></script>

        <!-- Examples -->
	    <script src="{{asset('assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js')}}"></script>
	    <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script> 
	    <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
	    <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
        <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
        
        <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>

        <script>
			$('#mainTable').editableTableWidget().numericInputExample().find('td:first').focus();
		</script>
		
        

    </body>
</html>