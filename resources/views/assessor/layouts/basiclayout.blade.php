<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        {{-- <link rel="shortcut icon" href="{{asset('assets/images/gsm_logo.png')}}"> --}}
        <title>Login Assesor GSM</title>
        <link href="{{asset('assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/plugins/switchery/css/switchery.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/plugins/multiselect/css/multi-select.css')}}"  rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/plugins/select2/css/select2.min.css" rel="stylesheet')}}" type="text/css" />
        <link href="{{asset('assets/plugins/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" />
        <link href="{{asset('assets/plugins/bootstrap-touchspin/css/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/core.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/components.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/pages.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('assets/css/responsive.css')}}" rel="stylesheet" type="text/css" />
        <script src="assets/js/modernizr.min.js"></script>
        
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

        <script src="{{asset('assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js')}}"></script>
        <script src="{{asset('assets/plugins/switchery/js/switchery.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/plugins/jquery-quicksearch/jquery.quicksearch.js')}}"></script>
        <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>

        <link rel="stylesheet" href="{{asset('assets/plugins/pace_master/themes/blue/pace-theme-minimal.css')}}">
        <script src="{{asset('assets/plugins/pace_master/pace.js')}}" type="text/javascript"></script>


        {{-- <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/jquery.mockjax.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/jquery.autocomplete.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/plugins/autocomplete/countries.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/pages/autocomplete.js')}}"></script> --}}

        <script type="text/javascript" src="{{asset('assets/pages/jquery.form-advanced.init.js')}}"></script>


		<script src="{{asset('assets/js/jquery.core.js')}}"></script>
        <script src="{{asset('assets/js/jquery.app.js')}}"></script>

        <script src="{{asset('assets/plugins/tinymce/tinymce.min.js')}}"></script>       
        <script type="text/javascript">
        	$(document).ready(function () {
			    if($("#elm1").length > 0){
			        tinymce.init({
			            selector: "textarea#elm1",
			            theme: "modern",
			            height:300,
			            plugins: [
			                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			                "save table contextmenu directionality emoticons template paste textcolor"
			            ],
			            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
			            style_formats: [
			                {title: 'Bold text', inline: 'b'},
			                {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			                {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			                {title: 'Example 1', inline: 'span', classes: 'example1'},
			                {title: 'Example 2', inline: 'span', classes: 'example2'},
			                {title: 'Table styles'},
			                {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
			            ]
			        });    
			    }  
			});
        </script>



    </body>
</html>