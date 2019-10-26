@extends('layout.welcomepage')
@section('content')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="{{asset('assets/css/welcomepage.css')}}">   
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->                      
<div class="content-page" style="padding-top:50px;margin-left:0px;background:white">
  <div class="col-md-12">
    <div class="row">
        <h1 class="welcomePageTitleUtama" style="text-align:center;color: rgb(10, 219, 209)" >Gerakan Sekolah Menyenangkan</h1>
        <p class="welcomePageTitleUtama2"> <b>This Is The Future School</b></p>    
    <div class="col-md-7 col-xs-12" id="videoDisplay">
    </div>
    <div class="col-md-5 col-xs-12">
        <div class="row" style="max-height:380px;overflow: auto">
            <div class="col-md-12 col-xs-12 listYoutube mb10">
                <div class="thumbnailYouTube">
                  <a href="{{url('/?videoParam=iv1_Va1SAOo')}}">
                      <img style="width:100%" class="staticImage" src="https://i.ytimg.com/vi/iv1_Va1SAOo/hqdefault.jpg?sqp=-oaymwEjCNACELwBSFryq4qpAxUIARUAAAAAGAElAADIQj0AgKJDeAE=&rs=AOn4CLC4eKNG2NSU9RQ9SHh6wydS_JB-vQ" alt="">
                  </a>
                </div>
                <div class="youTubeMeta">
                  <div class="ml15">
                  <a href="{{url('/?videoParam=iv1_Va1SAOo')}}">
                        <span style="color:black"><b>Gerakan Sekolah Menyenangkan dan Gerakan Literasi</b></span>
                    </a>
                      <br>
                      <span style="color:rgb(121, 121, 121)">Oleh : <a href="https://www.youtube.com/user/MrMrWidi" target="_blank">All About Education</a></span>
                  </div>
                </div>
            </div>
            
          <div class="col-md-12 col-xs-12 listYoutube mb10" >
            <div class="thumbnailYouTube">
              <a href="{{url('/?videoParam=ZoPY_e1dOXw')}}">
                <img style="width:100%" class="staticImage" src="https://i.ytimg.com/vi/ZoPY_e1dOXw/hqdefault.jpg?sqp=-oaymwEjCNACELwBSFryq4qpAxUIARUAAAAAGAElAADIQj0AgKJDeAE=&rs=AOn4CLDaLNl6jLh74XD5xY-T7LZYoWn9Ig" alt="">
              </a>
              </div>
            <div class="youTubeMeta">
              <div class="ml15">
                <a href="{{url('/?videoParam=ZoPY_e1dOXw')}}">
                    <span style="color:black"><b>Gerakan Sekolah Menyenangkan</b></span>
                </a>
                  <br>
                  <span style="color:rgb(121, 121, 121)">Oleh : <a href="https://www.youtube.com/channel/UCjo3WLJ7HYxM4fnCes0vA_A" target="_blank">Perdana Saputra</a></span>
              </div>
            </div>
          </div>
    
          <div class="col-md-12 col-xs-12 listYoutube mb10"  >
              <div class="thumbnailYouTube">
                  <a href="{{url('/?videoParam=D3GB1YzF9x4')}}">
                    <img style="width:100%" class="staticImage" src="https://i.ytimg.com/vi/D3GB1YzF9x4/hqdefault.jpg?sqp=-oaymwEZCNACELwBSFXyq4qpAwsIARUAAIhCGAFwAQ==&rs=AOn4CLDweApwqxJWoS7dWYHVFAuhWvzDKg" alt="">
                  </a>
                </div>
              <div class="youTubeMeta">
                <div class="ml15">
                    <span style="color:black"><b>GSM - Mengubah Paradigma Pendidikan Indonesia</b></span>
                    <br>
                    <a href="{{url('/?videoParam=D3GB1YzF9x4')}}">
                      <span style="color:rgb(121, 121, 121)">Oleh : <a href="https://www.youtube.com/channel/UCKAdVVqtvnqWjH_jScw2MZw" target="_blank">Gerakan Sekolah Menyenangkan</a> </span>
                    </a>
                    <br>
                </div>
              </div>
          </div>
    
          <div class="col-md-12 col-xs-12 listYoutube mb10" >
              <div class="thumbnailYouTube">
                  <a href="{{url('/?videoParam=7Evg7L3eiQk')}}">
                    <img style="width:100%" class="staticImage" src="https://i.ytimg.com/vi/7Evg7L3eiQk/hqdefault.jpg?sqp=-oaymwEjCNACELwBSFryq4qpAxUIARUAAAAAGAElAADIQj0AgKJDeAE=&rs=AOn4CLCH0M5vT_ujOiifPUkCiqzy4Xiq0Q" alt="">
                  </a>
                </div>
              <div class="youTubeMeta">
                <div class="ml15">
                    <a href="{{url('/?videoParam=7Evg7L3eiQk')}}">
                      <span style="color:black"><b>Gerakan Sekolah Menyenangkan (GSM) di SDN Rahayu tahun 2019</b></span>
                    </a>
                    <br>
                    <span style="color:rgb(121, 121, 121)">Oleh : <a href="https://www.youtube.com/watch?v=7Evg7L3eiQk" target="_blank">Rudy Saputro</a> </span>
                </div>
              </div>
          </div>

          <div class="col-md-12 col-xs-12 listYoutube mb10" >
            <div class="thumbnailYouTube">
                <a href="{{url('/?videoParam=rGrwTPR4328')}}">
                  <img style="width:100%" class="staticImage" src="https://i.ytimg.com/vi/rGrwTPR4328/hqdefault.jpg?sqp=-oaymwEjCNACELwBSFryq4qpAxUIARUAAAAAGAElAADIQj0AgKJDeAE=&rs=AOn4CLB64Lrtqlq-YMPZolxxXvXRd9Is0Q" alt="">
                </a>
              </div>
            <div class="youTubeMeta">
              <div class="ml15">
                  <a href="{{url('/?videoParam=rGrwTPR4328')}}">
                    <span style="color:black"><b>Gerakan Sekolah Menyenangkan</b></span>
                  </a>
                  <br>
                  <span style="color:rgb(121, 121, 121)">Oleh : <a href="https://www.youtube.com/channel/UCpvAZhzGuUBL2BbAd0Q2hvw" target="_blank">Azis Licht</a> </span>
              </div>
            </div>
        </div>    
        </div>
      </div>
    </div>
  </div>
  
  <div  class="col-md-12 mt20 testimoni">
    <div class="row" style="padding-bottom: 50px;text-align:center;background-color: rgba(255, 255, 255, 0.87);">
        <h1 class="welcomePageTitle">Lebih Dari 2000 Sekolah Telah Menerapkan GSM </h1>
        <p style="margin-bottom: 50px;">Lihat cerita dan pengalaman para guru, siswa dan orang tua berikut ini</p>    
        <div class="owl-carousel owl-theme" id="owl-multi" style="z-index: 100">
          <div class="item">
              <div class="col-md-12">
              <div class="card-box p-0">
                <div class="profile-widget text-center">
                    <div style="background: rgb(252, 185, 97)!important" class="bg-custom bg-profile"></div>
                    <img src="assets/images/users/avatar-1.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
                    <h4>Arga Wirawan</h4>
                    <p class="text-muted">Guru SD Negeri 1 Caturtunggal</p>
                    <p class="text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
                </div>
              </div>
              </div> 
          </div>
          <div class="item">
              <div class="col-md-12">
              <div class="card-box p-0">
                <div class="profile-widget text-center">
                    <div style="background: rgb(90, 188, 245)!important" class="bg-custom bg-profile"></div>
                    <img src="assets/images/users/avatar-2.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
                    <h4>Dedy Kurniawan S</h4>
                    <p class="text-muted">Guru SD Negeri 2 Sleman</p>
                    <p class=" text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
                </div>
              </div>
              </div> 
          </div>
          <div class="item">
              <div class="col-md-12">
              <div class="card-box p-0">
                <div class="profile-widget text-center">
                    <div style="background: rgb(132, 237, 100)!important" class="bg-custom bg-profile"></div>
                    <img src="assets/images/users/avatar-3.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
                    <h4>Ahmadi Ammar A.R</h4>
                    <p class="text-muted">Guru SD Negeri 1 Sleman</p>
                    <p class="text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
                </div>
              </div>
              </div> <!-- end col -->
          </div>
          <div class="item">
            <div class="col-md-12">
            <div class="card-box p-0">
              <div class="profile-widget text-center">
                  <div style="background: rgb(97, 252, 213)!important" class="bg-custom bg-profile"></div>
                  <img src="assets/images/users/avatar-1.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
                  <h4>Arga Wirawan</h4>
                  <p class="text-muted">Guru SD Negeri 1 Caturtunggal</p>
                  <p class="text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
              </div>
            </div>
            </div> 
        </div>
        <div class="item">
            <div class="col-md-12">
            <div class="card-box p-0">
              <div class="profile-widget text-center">
                  <div style="background: rgb(235, 245, 90)!important" class="bg-custom bg-profile"></div>
                  <img src="assets/images/users/avatar-2.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
                  <h4>Dedy Kurniawan S</h4>
                  <p class="text-muted">Guru SD Negeri 2 Sleman</p>
                  <p class=" text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
              </div>
            </div>
            </div> 
        </div>
        <div class="item">
            <div class="col-md-12">
            <div class="card-box p-0">
              <div class="profile-widget text-center">
                  <div style="background: rgb(250, 103, 135)!important" class="bg-custom bg-profile"></div>
                  <img src="assets/images/users/avatar-3.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
                  <h4>Ahmadi Ammar A.R</h4>
                  <p class="text-muted">Guru SD Negeri 1 Sleman</p>
                  <p class="text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
              </div>
            </div>
            </div> <!-- end col -->
        </div>
        </div>
        </div>
    </div>
    <div class="col-md-12 partnerBg">
      <div class="row" style="padding-bottom: 70px;text-align:center;background-color: rgba(138, 166, 218, 0.87);">
        <h1 class="welcomePageTitle" style="color: rgb(219, 10, 55)">Partner Kami</h1>
        <p style="margin-bottom: 50px;color:white">GSM Sudah Terbukti Kualitas dan Kerjasamanya</p>    
          <div class="owl-carousel owl-theme" id="owl-multi-2">
              <div class="item">
                <!-- <div class="col-md-4"> -->
                    <img style="width:50%!important" src="https://i.imgur.com/LRWTlV2.png" alt="">
                <!-- </div> -->
              </div>
              <div class="item">
                  <!-- <div class="col-md-4"> -->
                      <img style="width:45%!important" src="https://i.imgur.com/cmqUCDv.png" alt="">
                  <!-- </div> -->
                </div>
                <div class="item">
                    <!-- <div class="col-md-4"> -->
                        <img style="width:40%!important" src="https://seeklogo.com/images/K/Kabupaten_Sleman-logo-97E644BFE9-seeklogo.com.png" alt="">
                    <!-- </div> -->
                  </div>
                  <div class="item">
                      <!-- <div class="col-md-4"> -->
                          <img style="width:100%!important;margin-top:40px" src="https://i.imgur.com/IsrrbRC.png" alt="">
                      <!-- </div> -->
                    </div>
          </div>
      </div>
    </div>

    <div class="col-md-12">
        <div class="row" style="text-align:center">
          <h1 class="welcomePageTitle" style="color: rgb(10, 59, 219)">Kenapa Harus Mendaftar Elearning GSM</h1>
          <p style="margin-bottom: 50px;color:rgb(66, 66, 66)">Keuntungan Yang Anda Dapatkan</p>    
            <div class="owl-carousel owl-theme" id="owl-multi-3">
                <div class="item">
                  <!-- <div class="col-md-4"> -->
                      <img style="width:50%!important" src="https://image.flaticon.com/icons/svg/167/167752.svg" alt="">
                      <h3 style="color: rgb(245, 114, 39)"><b>Dibimbing Assessor</b></h3>
                      <!-- <p style="color:black">Anda dapat berinteraksi, bertanya dan berkomunikasi dengan Assessor Kami</p> -->
                  <!-- </div> -->
                </div>
                <div class="item">
                    <!-- <div class="col-md-4"> -->
                        <img style="width:50%!important;" src="https://image.flaticon.com/icons/svg/189/189093.svg" alt="">
                        <h3 style="color: rgb(255, 192, 20)"> <b>Biaya Gratis</b></h3>
                        <!-- <p style="color:black">Belajar di E-Learning GSM 100% gratis dan tidak dipungut biaya apapun</p> -->
                        <!-- </div> -->
                  </div>
                  <div class="item">
                      <!-- <div class="col-md-4"> -->
                          <img style="width:50%!important;" src="https://image.flaticon.com/icons/svg/148/148709.svg" alt="">
                          <h3 style="color:rgb(64, 115, 255)"><b>Materi Video</b></h3>
                          <!-- <p style="color:black">Materi disajikan dalam bentuk video yang tidak membuat Anda bosan</p> -->
                          <!-- </div> -->
                    </div>
                    <div class="item">
                        <!-- <div class="col-md-4"> -->
                            <img style="width:50%!important;" src="https://image.flaticon.com/icons/svg/1497/1497573.svg" alt="">
                            <h3 style="color: crimson"><b>Bagikan Konten</b> </h3>
                            <!-- <p style="color:black">Anda bisa membagikan konten kreatif dan melihat konten user lain </p> -->
                        <!-- </div> -->
                      </div>
            </div>
        </div>
      </div>

      <div class="col-md-12 daftarSekarang" style="text-align: center;margin-top: 50px">
        <div class="row" style="padding-bottom: 70px;text-align:center;background-color: rgba(255, 255, 255, 0.87);">
          <div class="col-md-12">
              <h1 class="welcomePageTitle" style="color: rgb(10, 219, 45)">Ayo Daftar Sekarang !!!</h1>
              <p style="margin-bottom: 50px;color:rgb(66, 66, 66)">Tunggu Apalagi? Langsung Tekan Tombol Dafatar Ini</p>    
              <a  href="{{ url('/daftar') }}" > 
                <button class="btn btn-default waves-effect waves-light"> <span style="color:white" class="welcomePageTitle">Daftar Sekarang</span></button>    
              </a>
          </div>
        </div>
      </div>


  </div>

    <footer class="footer text-right" style="left:0px;">
        © 2019. All rights reserved.
    </footer>
</div>   

<script src="{{asset('assets/plugins/owl.carousel/dist/owl.carousel.min.js')}}"></script>
<script>
$(document).ready(function(){
  var url_string = window.location.href
  var url = new URL(url_string);
  var videoParam = url.searchParams.get("videoParam");
  if(videoParam == null){
    $("#videoDisplay").append(
      '<iframe src="https://www.youtube.com/embed/iv1_Va1SAOo" width="100%" height="380" frameborder="0" allowfullscreenid="you_tube"></iframe>'+
      '<h4 style="color:rgb(250, 86, 214)"><b>Gerakan Sekolah Menyenangkan dan Gerakan Literasi</b></h4>'+
      '<p style="color:rgb(88, 88, 88)">Oleh : <a href="https://www.youtube.com/user/MrMrWidi" target="_blank"> All About Education</a></p>'
    )
  }else{
    switch(videoParam){
    case "iv1_Va1SAOo" :
    $("#videoDisplay").append(
      '<iframe src="https://www.youtube.com/embed/iv1_Va1SAOo" width="100%" height="380" frameborder="0" allowfullscreenid="you_tube"></iframe>'+
      '<h4 style="color:rgb(250, 86, 214)"><b>Gerakan Sekolah Menyenangkan dan Gerakan Literasi</b></h4>'+
      '<p style="color:rgb(88, 88, 88)">Oleh : <a href="https://www.youtube.com/user/MrMrWidi" target="_blank"> All About Education</a></p>'
    )
    break; 

    case "ZoPY_e1dOXw" :
    $("#videoDisplay").append(
      '<iframe src="https://www.youtube.com/embed/ZoPY_e1dOXw" width="100%" height="380" frameborder="0" allowfullscreenid="you_tube"></iframe>'+
      '<h4 style="color:rgb(250, 86, 214)"><b>Gerakan Sekolah Menyenangkan </b></h4>'+
      '<p style="color:rgb(88, 88, 88)">Oleh : <a href="https://www.youtube.com/channel/UCjo3WLJ7HYxM4fnCes0vA_A" target="_blank"> Perdana Saputra</a></p>'
    )
    break; 

    case "D3GB1YzF9x4" :
    $("#videoDisplay").append(
      '<iframe src="https://www.youtube.com/embed/D3GB1YzF9x4" width="100%" height="380" frameborder="0" allowfullscreenid="you_tube"></iframe>'+
      '<h4 style="color:rgb(250, 86, 214)"><b>GSM - Mengubah Paradigma Pendidikan Indonesia </b></h4>'+
      '<p style="color:rgb(88, 88, 88)">Oleh : <a href="https://www.youtube.com/channel/UCKAdVVqtvnqWjH_jScw2MZw" target="_blank">Gerakan Sekolah Menyenangkan</a></p>'
    )
    break; 

    case   "7Evg7L3eiQk" :
    $("#videoDisplay").append(
      '<iframe src="https://www.youtube.com/embed/7Evg7L3eiQk" width="100%" height="380" frameborder="0" allowfullscreenid="you_tube"></iframe>'+
      '<h4 style="color:rgb(250, 86, 214)"><b>Gerakan Sekolah Menyenangkan (GSM) di SDN Rahayu tahun 2019 </b></h4>'+
      '<p style="color:rgb(88, 88, 88)">Oleh : <a href="https://www.youtube.com/channel/UCImwsVcHeh89Cypuw6ssjUw" target="_blank">Rudy Saputro</a></p>'
    )
    break; 

    case   "rGrwTPR4328" :
    $("#videoDisplay").append(
      '<iframe src="https://www.youtube.com/embed/rGrwTPR4328" width="100%" height="380" frameborder="0" allowfullscreenid="you_tube"></iframe>'+
      '<h4 style="color:rgb(250, 86, 214)"><b>Gerakan Sekolah Menyenangkan</b></h4>'+
      '<p style="color:rgb(88, 88, 88)">Oleh : <a href="https://www.youtube.com/channel/UCpvAZhzGuUBL2BbAd0Q2hvw" target="_blank">Azis Licht</a></p>'
    )
    break; 
  }
  }
  

  //Owl-Multi
  $('#owl-multi-3').owlCarousel({
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
				            items:3
				        },
				        1000:{
				            items:3
				        },
				        1100:{
				            items:3
				        }
				    }
				})

  $('#owl-multi-2').owlCarousel({
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
				            items:5
				        }
				    }
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
				            items:3
				        },
				        1100:{
				            items:5
				        }
				    }
				})
})
</script>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->
@endsection