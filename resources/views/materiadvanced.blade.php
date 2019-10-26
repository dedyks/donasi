@extends('layout.dashboard')
@section('content')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
                                                    Materi Advanced
                                                    </b>
                                                    </h1>
                                                    <p style="margin:10px">Materi advanced merupakan materi yang wajib dipelajari sebelum lanjut ke materi advanced</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  

                                <div class="row" id="aksesAdvanced">
                                    <div class="col-md-12">
                                        <div class="card-box">
                                           <p style="text-align:center;font-size:10px">Mohon maaf, Anda belum bisa membuka materi advanced. Selesaikan beberapa tantangan di materi basic terlebih dahulu dan minta persetujuan ke Assesor Anda untuk membuka materi ini </p> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="listMateri">
                                        <div class="col-md-12">
                                                <div class="card-box">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <p style="font-size:25px"> <b>Category</b> </p>
                                                        <p style="color:#5d9cec">Pilih materi sesuai kategori pada pilihan berikut ini : </p>
                                                        <div style="margin-top:30px" class="owl-carousel owl-theme" id="owl-multi">
                                                                <div class="item" style="cursor:pointer" onclick="pilih_kategori('advanced', 'ekosistem-positif')">
                                                                    <img style="margin:auto;width:50%!important;" src="https://image.flaticon.com/icons/svg/167/167707.svg" alt="">
                                                                    <p style="text-align:center;color:rgb(255, 135, 37);margin-top:10px"><b>Penciptaan Lingkungan Positif & Etis</b> </p>
                                                                </div>
                                                
                                                                <div class="item" style="cursor:pointer" onclick="pilih_kategori('advanced', 'trisentra-pendidikan')">
                                                                        <img style="margin:auto;width:50%!important" src="https://image.flaticon.com/icons/svg/1946/1946079.svg" alt="">
                                                                        <p style="text-align:center;color:rgb(60, 135, 233);margin-top:10px"><b>Panca Sentra Pendidikan</b> </p>
                                                                </div>
                                                
                                                                <div class="item" style="cursor:pointer" onclick="pilih_kategori('advanced', 'pengembangan-karakter')">
                                                                        <img style="margin:auto;width:50%!important" src="https://image.flaticon.com/icons/svg/906/906175.svg" alt="">
                                                                        <p style="text-align:center;color:purple;margin-top:10px"><b>Pengembangan Karakter</b> </p>
                                                                </div>
                                                
                                                                <div class="item" style="cursor:pointer" onclick="pilih_kategori('advanced', 'pembelajaran-riset')">
                                                                        <img style="margin:auto;width:50%!important" src="https://image.flaticon.com/icons/svg/1055/1055645.svg" alt="">
                                                                        <p style="text-align:center;color:rgb(252, 65, 96);margin-top:10px"><b>Pembelajaran Kontekstual & Partisipatif</b> </p>    
                                                                </div>
                                                            </div>  
                                                        </div>

                                                        <div class="col-md-12"  style="display:none;margin-left:-10px">
                                                        <select class="selectpicker" data-live-search="true"  data-style="btn-white" id="pilih_kategori_materi">
                                                                <option selected value="ekosistem-positif">Penciptaan Ekosistem Positif di Sekolah</option>
                                                                <option value="trisentra-pendidikan">Tri Sentra Pendidikan</option> 
                                                                <option value="pengembangan-karakter">Pengembangan Karakter</option>
                                                                <option value="pembelajaran-riset">Pembelajaran Berbasis Riset</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    </div>
                                                                                    
                                            </div>
                                            <div class="col-md-12">
                                                <div id="list_materi">
                                        
                                                </div>    
                                            </div>    
                                            {{-- <button class="button"onclick="testing()">Press Me</button> --}}
                                        </div>
                                    
                    </div> <!-- container -->
                </div> <!-- content -->
                <footer class="footer text-right">
                    © 2019. All rights reserved.
                </footer>
            </div>
            <script>
                
                $(document).ready(function(){
                        getAllQuizUser()
                        var datauser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                        var x = document.getElementById('listMateri')
                        var y = document.getElementById('aksesAdvanced')
                        console.log(datauser.level)
                        if(datauser.level == "basic"){
                            x.style.display = "none"
                        }else{
                        y.style.display = "none"
                        x.style.display = "block"
                        var kategori = document.getElementById('pilih_kategori_materi').value
                        var appurl = localStorage.getItem("url_elearning_gsm")
                        $(document).ajaxStart(function() { Pace.restart(); });
                        $.ajax({
                            type: 'GET',
                            url : appurl+"v1/modul/aspect-grade/"+kategori+"/advanced"
                            }).done(function(data, status){
                                var jumlah_materi = data.length
                                if(jumlah_materi == 0){
                                    $('#list_materi').append(
                                        // '<div class="col-md-12" style="text-align:center">'+
                                        '<div class="card-box" style="text-align:center">'+
                                            '<p>'+
                                                'Belum ada materi yang dapat ditampilkan'+
                                            '</p>'+
                                        '</div>'
                                        // '</div>'
                                    )
                                }
                                for(var i = 0; i<jumlah_materi;i++){
                                var judul = data[i].title  
                                var title = judul.replace(/\b\w/g, l => l.toUpperCase())
                                var category = document.getElementById('pilih_kategori_materi').value
                                switch(category) {
                                case "ekosistem-positif":
                                    // code block
                                    var category_materi = "Penciptaan Ekosistem Positif di Sekolah"
                                    break;
                                case "trisentra-pendidikan":
                                    // code block
                                    var category_materi = "Tri Sentra Pendidikan"
                                    break;
                                case "pengembangan-karakter":
                                    // code block
                                    var category_materi = "Pengembangan Karakter"
                                    break;
                                case "pembelajaran-riset":
                                    // code block
                                    var category_materi = "Pembelajaran Berbasis Riset"
                                    break;
                                default:
                                    // code block
                                } 
                                    $('#list_materi').append(
                                        '<div class="card-box">'+
                                        '<div class="bar-widget">'+
                                            '<div class="table-box">'+
                                                '<div class="table-detail">'+
                                                    '<div class="col-md-12">'+
                                                    '<div class="row">'+
                                                        '<div class="col-md-6">'+
                                                            '<p style="font-size:25px"> <b>'+title+'</b> </p>'+
                                                        '</div>'+
                                                        '<div class="col-md-6">'+
                                                        '<p class="statusMateri" id="'+data[i]._id+'">Anda belum mempelajari materi ini</p>'+
                                                        '</div>'+
                                                    '</div>'+
                                                        '<p style="color:#5d9cec" class="categoryText">Category : '+category_materi+'</p>'+
                                                        '<p>'+data[i].description+'</p>'+
                                                    '</div>'+
                                                    '<div class="col-md-12">'+
                                                            '<button style="float:right" type="button" class="btn btn-default waves-effect waves-light" onclick=enroll("'+data[i]._id+'") href="{{ url("/detailmateri") }}">Pelajari</button>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'
                                    )
                                }
                                modulStatus(data, jumlah_materi)
                            }).fail(function(data,status){
                                swal("Terjadi Kesalahan", "Cek koneksi internet Anda dan ulangi");
                            })
                        }
                        // Ambil quiz user
                    })
                    </script>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        @endsection