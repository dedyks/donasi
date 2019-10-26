@extends('layout.dashboard')
@section('content')
<style>
    .title{
        text-align:center;
        font-size:50px;
        font-family: 'Passion One', cursive;
        letter-spacing: 3px;
    }
    .bg-custom-green{
        background-color: #81c868  !important;
    }
    .bg-custom-pink{
        background-color: #df78e3   !important;
    }

    .custom-modal-title {
        background-color: #38cde7   !important;
    }
    @media only screen and (max-width: 400px) {
      .title{
        font-size:30px;
      }

      .BigText{
        font-size:20px!important
    }
    }

    .BigText{
        margin-top:15px;
        margin-bottom:15px;
        font-family: 'Passion One', cursive;
        font-size:35px
    }
</style>
<link href="{{asset('assets/plugins/custombox/css/custombox.css')}}" rel="stylesheet">

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
                <div class="row">
                  <div class="col-lg-12">
                      <div style="margin-top:-30px" class="card-box">
                          <div class="row">
                            <div class="col-md-12" id="welcomeBack" style="display:none;margin-bottom:30px">
                                <h1 class="title" style="color:rgb(32, 198, 248)">Welcome Back </h1>
                                <div class="row" >
                                <div style="margin-top:10px" class="owl-carousel owl-theme" id="owl-multi-2">
                                    <div class="item">
                                        {{-- <div class="col-md-4"> --}}
                                            <div class="card-box" style="text-align:center">
                                                <p style="margin-bottom: -5px;color: rgb(30, 236, 185);font-size:20px;font-weight: bold;" id="jumlahQuiz"></p>
                                                <p style="color:rgb(30, 236, 185);font-size:20px"> <b>Materi</b> </p>
                                                <p>Sudah Dipelajari</p>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                    

                                    <div class="item">
                                        {{-- <div class="col-md-4"> --}}
                                            <div class="card-box" style="text-align:center;" >
                                                <p style="margin-bottom:-5px;color:rgb(247, 65, 171);font-size:20px"><b>Halaman</b></p>
                                                <p style="color:rgb(247, 65, 171);font-size:20px"> <b>Materi</b> </p>
                                                <p style="cursor:pointer" onclick="goToMateri()"> Buka Di Sini </p>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                    

                                    <div class="item">
                                        {{-- <div class="col-md-4"> --}}
                                            <div class="card-box" style="text-align:center">
                                                <p style="margin-bottom: -5px;color: rgb(65, 129, 247);font-size:20px;font-weight: bold;" id="jumlahQuizDiNilai"></p>
                                                <p style="color:rgb(65, 129, 247);font-size:20px"> <b>Tantangan</b> </p>
                                                <p>Sudah Dinilai</p>
                                            </div>
                                        {{-- </div> --}}
                                    </div>
                                    

                                    <div class="item" id="halamanAssessor">
                                        {{-- <div class="col-md-4"> --}}
                                            <div class="card-box" style="text-align:center" >
                                                <p style="margin-bottom:-5px;color:rgb(65, 241, 247);font-size:20px"><b>Halaman</b></p>
                                                <p style="color:rgb(65, 241, 247);font-size:20px"><b>Assessor</b></p>
                                                <p style="cursor:pointer" onclick="goToAssessor()">Buka Di Sini</p>
                                            </div>
                                        {{-- </div> --}}
                                    </div>

                                    <div class="item">
                                            {{-- <div class="col-md-4"> --}}
                                                <div class="card-box" style="text-align:center;" >
                                                    <p style="margin-bottom:-5px;color:rgb(247, 86, 65);font-size:20px"><b>Grup</b></p>
                                                    <p style="color:rgb(247, 86, 65);font-size:20px"> <b>Sekolah</b> </p>
                                                    {{-- <p style="cursor:pointer"> Coming Soon </p> --}}
                                                     <p style="cursor:pointer" onclick="goToLobbySekolah()"> Coming Soon </p>
                                                </div>
                                            {{-- </div> --}}
                                        </div>
                                </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h1 class="title"><font color="#eb3986">4 Framework Penting GSM</font></h1>
                                <p style="text-align:center">Klik salah satu untuk melihat detail</p>
                                <div style="margin-top:30px" class="owl-carousel owl-theme" id="owl-multi">
                                    
                                    <div class="item">
                                    <a href="#custom-modal-1" data-animation="fadein" data-plugin="custommodal" 
                                    data-overlaySpeed="200" data-overlayColor="#36404a">
                                    <!-- <div class="col-md-4"> -->
                                        <img style="margin:auto;width:50%!important" src="https://image.flaticon.com/icons/svg/1055/1055645.svg" alt="">
                                        <p style="text-align:center;color:rgb(252, 65, 96);margin-top:10px"><b>Pembelajaran Kontekstual & Partisipatif</b> </p>
                                    <!-- </div> -->
                                    </a>
                                    </div>

                                    <div class="item">
                                    <a href="#custom-modal-2" data-animation="slide" data-plugin="custommodal" 
                                    data-overlaySpeed="200" data-overlayColor="#36404a">
        
                                        <!-- <div class="col-md-4"> -->
                                            <img style="margin:auto;width:50%!important" src="https://image.flaticon.com/icons/svg/1946/1946079.svg" alt="">
                                            <p style="text-align:center;color:rgb(60, 135, 233);margin-top:10px"><b>Panca sentra Pendidikan</b> </p>
                                            <!-- </div> -->
                                    </a>
                                    </div>

                                    <div class="item">
                                    <a href="#custom-modal-3" data-animation="slidetogether" data-plugin="custommodal" 
                                    data-overlaySpeed="200" data-overlayColor="#36404a">
                                        <!-- <div class="col-md-4"> -->
                                            <img style="margin:auto;width:50%!important" src="https://image.flaticon.com/icons/svg/906/906175.svg" alt="">
                                            <p style="text-align:center;color:purple;margin-top:10px"><b>Pengembangan Karakter</b> </p>
                                            <!-- </div> -->
                                    </a>
                                    </div>

                                    <div class="item">
                                    <a href="#custom-modal-4" data-animation="door" data-plugin="custommodal" 
                                    data-overlaySpeed="200" data-overlayColor="#36404a">
                                        <!-- <div class="col-md-4"> -->
                                            <img style="margin:auto;width:50%!important;" src="https://image.flaticon.com/icons/svg/167/167707.svg" alt="">
                                            <p style="text-align:center;color:rgb(255, 135, 37);margin-top:10px"><b>Penciptaan Lingkungan Positif & Etis</b> </p>
                                            <!-- </div> -->
                                    </a>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <div id="custom-modal-1" class="modal-demo">
                                    <button type="button" class="close" onclick="Custombox.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">Pembelajaran Kontekstual & Partisipatif</h4>
                                    <div class="custom-modal-text">
                                        Pembelajaran sosial emosional pembentukan karakter 
                                    </div>
                                </div>

                                <div id="custom-modal-2" class="modal-demo">
                                    <button type="button" class="close" onclick="Custombox.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">Panca Sentra Pendidikan</h4>
                                    <div class="custom-modal-text">
                                        Panca sentra lingkungan sinergi antara sekolah, murid, guru, orang tua, masyarakat, dan global
                                    </div>
                                </div>

                                <div id="custom-modal-3" class="modal-demo">
                                    <button type="button" class="close" onclick="Custombox.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">Pengembangan Karakter</h4>
                                    <div class="custom-modal-text">
                                        Paradigma pendidikan yang mengedepankan perlibatan siswa, berfokus pada siswa, dengan berbagai macam metode yang kontekstual 
                                    </div>
                                </div>

                                <div id="custom-modal-4" class="modal-demo">
                                    <button type="button" class="close" onclick="Custombox.close();">
                                        <span>&times;</span><span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="custom-modal-title">Penciptaan Lingkungan Positif & Etis</h4>
                                    <div class="custom-modal-text">
                                        Bagaimana membangun lingkungan sekolah yang postif untuk perkembangan siswa dengan melibatkan siswa
                                    </div>
                                </div>


            
                            </div>

                            <div id="ayoMulaiSection" class="col-md-12" style="display:none;margin-top:50px;background-color: rgb(250, 250, 250);padding: 50px 0px 50px 0px">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img style="margin:auto;width:100%" src="https://image.flaticon.com/icons/svg/609/609001.svg" alt="">
                                    </div>
                                    <div class="col-md-8"  style="text-align: center">
                                        <p class="BigText"><span style="color:skyblue">Apakah Anda sudah Siap ? Klik tombol untuk memilih materi pertamamu !</span></p>
                                    <a href="{{url('materibasic')}}">
                                            <button style="background-color:plum!important;border:1px solid plum !important" type="button" class="btn btn-default waves-effect waves-light">Ayo Mulai </button>
                                        </a>
                                     </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top:50px">
                                <div class="row">
                                    <div class="col-md-12" style="text-align:center;margin-bottom:20px">
                                        <!-- <img style="width:10%" src="https://image.flaticon.com/icons/svg/1497/1497573.svg" alt=""> -->
                                        <h1 style="color:rgb(252, 65, 96)" class="title">4 Fitur Utama E-Learning GSM</h1>
                                        <p style="text-align:center">Klik salah satu untuk mencoba fitur</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" style="text-align: center">
                                            <div class="col-md-3" style="margin-bottom: 50px">
                                                <img style="width:40%" src="https://image.flaticon.com/icons/svg/167/167755.svg" alt="">            
                                                <p style="color:rgb(255, 0, 200)"><b>Materi Pelatihan</b></p>
                                                <p>Materi di sajikan dalama bentuk pdf, gambar dan video interaktif</p>
                                                <a href="{{url('materibasic')}}">
                                                    <button style="background-color:rgb(255, 0, 200)!important;border:1px solid rgb(255, 0, 200) !important" type="button" class="btn btn-default waves-effect waves-light">Pelajari Materi</button>
                                                </a>
                                            </div>

                                            <div class="col-md-3" style="margin-bottom: 50px">
                                                <img style="width:40%" src="https://image.flaticon.com/icons/svg/1006/1006542.svg" alt="">            
                                                <p style="color:rgb(0, 255, 191)"><b>Pendampingan</b></p>
                                                <p>Anda bebas memilih assessor untuk menjadi pendamping Anda</p>
                                                <a href="{{url('pendampingan')}}">
                                                    <button style="background-color:rgb(0, 255, 191)!important;border:1px solid rgb(0, 255, 191) !important" type="button" class="btn btn-default waves-effect waves-light">Pilih Assessor </button>
                                                </a>
                                            </div>

                                            <div class="col-md-3" style="margin-bottom: 50px">
                                                <img style="width:40%" src="https://image.flaticon.com/icons/svg/1279/1279498.svg" alt="">            
                                                <p style="color:rgb(0, 153, 255)"><b>Berbagi</b></p>
                                                <p>Anda dapat membuat sebuah konten dan membagikannya</p>
                                                <a href="{{url('createkontenberbagi')}}">
                                                    <button style="background-color:rgb(0, 153, 255)!important;border:1px solid rgb(0, 153, 255) !important" type="button" class="btn btn-default waves-effect waves-light">Buat Sekarang </button>
                                                </a>
                                            </div>
                                            
                                            
                                            <div class="col-md-3" style="margin-bottom: 50px">
                                                 <img style="width:40%" src="https://image.flaticon.com/icons/svg/237/237645.svg" alt="">            
                                                 <!-- <p style="color:rgb(0, 255, 55)><b>Like & Save</b></p> -->
                                                 <p style="color:rgb(255, 79, 79)"><b>Like & Save</b></p>
                                                 <p>Temukan berbagai macam konten dari pengguna lain, sukai dan simpan !</p>  
                                                 <a href="{{url('linimasaberbagi')}}">
                                                    <button style="background-color:rgb(255, 79, 79)!important;border:1px solid rgb(255, 79, 79) !important" type="button" class="btn btn-default waves-effect waves-light">Cari Konten</button>
                                                 </a>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                          </div>
                          
                        </div>
                  </div>
                </div>
            <!-- end row -->
        </div> <!-- container -->

    </div> <!-- content -->

    <footer class="footer text-right">
        © 2019. All rights reserved.
    </footer>

</div>
<script src="{{asset('assets/plugins/owl.carousel/dist/owl.carousel.min.js')}}"></script>   
<!-- Modal-Effect -->
<script src="{{asset('assets/plugins/custombox/js/custombox.min.js')}}"></script>
<script src="{{asset('assets/plugins/custombox/js/legacy.min.js')}}"></script>

<script>
function goToMateri(){
    window.location = "{{url('materibasic')}}"
}

function goToAssessor(){
    window.location = "{{url('assessor/login')}}"
}

function goToLobbySekolah(){
    window.location = "{{url('grupsekolah')}}"
}

$(document).ready(function(){
    $(document).ajaxStart(function() { Pace.restart(); });
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user = getCookie("token_login_user_gsm")
    $.ajax({
    type: 'GET',
    headers :{
        "Content-Type" : "application/json", 
        "Accept" : "application/json", 
        "Authorization" : "Bearer "+token_user
    }, 
    url : appurl+"v1/users/quiz"
    })
    .done(function(data, status){
        
    localStorage.setItem('data_user_elearning_gsm', JSON.stringify(data.data))
    var data = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
    var role = data.role 
    if(role == "user"){
        $("#halamanAssessor").remove()
    }
    var length = data.quiz.length
    var dataQuiz = data.quiz
    var enrolled = 0
    var answered = 0
    var scored = 0
    for(var i = 0 ; i < length ; i++){
        if(dataQuiz[i].flag == "enrolled"){
            enrolled += 1
        }else if(dataQuiz[i].flag == "answered"){
            answered += 1 
        }else if(dataQuiz[i].flag == "scored"){
            scored += 1
        }
    }

    document.getElementById('jumlahQuiz').innerHTML = enrolled
    document.getElementById('jumlahQuizDiNilai').innerHTML = scored
    if(data.quiz.length == 0){
        document.getElementById('ayoMulaiSection').style.display="block"
    }else{
        document.getElementById('welcomeBack').style.display="block"
    }

    $('#owl-multi-2').owlCarousel({
        loop:true,
        margin:20,
        nav:false,
        autoplay:false,
        responsive:{
            0:{
                items:2
            },
            480:{
                items:2
            },
            700:{
                items:3
            },
            1000:{
                items:3
            },
            1100:{
                items:4
            }
        }
    })

    })
    .fail(function(error){
        swal("Terjadi Kesalahan", "Cek koneksi internet Anda dan ulangi");
    })

    $('#owl-multi').owlCarousel({
        loop:true,
        margin:20,
        nav:false,
        autoplay:false,
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
                items:4
            },
            1100:{
                items:4
            }
        }
    })
})
</script>
@endsection