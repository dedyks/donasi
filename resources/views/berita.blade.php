@extends('layout.dashboard')
@section('content')
<style>
.title{
    text-align:center;
    font-size:50px;
    font-family: 'Passion One', cursive;
    letter-spacing: 3px;
}

@media only screen and (max-width: 600px) {
    .title{
    font-size:30px;
}
}
</style>
            <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                            <div class="row">
                                    <div  style="margin-top:-20px" class="col-sm-12">
                                        <div class="card-box widget-inline">
                                            <div class="row">
                                                    <div style="text-align:center"class="col-md-12">
                                                    <h1> 
                                                    <b>
                                                    Berita GSM 
                                                    </b>
                                                    </h1>
                                                    <p>Update Berita GSM Terkini </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                 <!-- Blog -->
                 <div class="col-md-12" id="blog_gsm" style="text-align:center">
                    <div class="col-md-12" style="text-align:center" id="loading">
                        <img src="assets/images/ajax-loader.gif" alt="image" class="img-rounded" width="100"/>
                    </div>
                 </div>
                 
                                         
                    </div> <!-- container -->
                               
                </div> <!-- content -->

                <footer class="footer text-right">
                    © 2019. All rights reserved.
                </footer>

            </div>
            <script>
            $(document).ready(function(){
                axios.get("https://www.sekolahmenyenangkan.org/wp-json/wp/v2/posts")
                .then(function(response){
                  var x = document.getElementById("loading")
                  x.style.display = "none"
                  var data = response.data
                  var jumlah_berita = data.length -1
                  var bulan_string = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]
                  for(var i = 0; i<jumlah_berita;i++){
                    var data_tanggal = new Date (data[i].date)
                    var tanggal = data_tanggal.getDate()
                    var bulan = data_tanggal.getMonth()
                    var title= data[i].title.rendered
                    var title_limit = title.substr(0, 100)
                    $('#blog_gsm').append(
                    '<div class="col-md-12">'+
                    '<div class="blog-box-one">'+
                        '<div class="cover-wrapper">'+
                            '<a href="'+data[i].link+'" target="_blank"><img alt="Blog-img" src="'+data[i].jetpack_featured_media_url+'" class="img-responsive"/></a>'+
                        '</div>'+
                        '<div class="post-info">'+
                            '<div class="date">'+
                                '<span class="day">'+tanggal+'</span><br>'+
                                '<span class="month">'+bulan_string[bulan]+'</span>'+
                            '</div>'+
    
                            '<div class="meta-container">'+
                                '<a href="'+data[i].link+'" target="_blank">'+
                                    '<h5 class="text-overflow m-t-0" style="">'+title_limit+' ...</h5>'+
                                '</a>'+
                                '<div class="font-13">'+
                                    '<span class="meta">Posted by : <a href="#"><b>Admin GSM</b></a></span>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row m-t-10">'+
                                '<div class="col-xs-6">'+
                                '</div>'+
                                '<div class="col-xs-6 text-right">'+
                                    '<a href="'+data[i].link+'" target="_blank" class="btn btn-sm waves-effect btn-white">Read More</a>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>' 
                    )
                  }
                })
            })
            </script>
            
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        @endsection