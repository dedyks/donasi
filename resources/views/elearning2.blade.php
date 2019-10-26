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
    @media only screen and (max-width: 600px) {
      .title{
        font-size:30px;
      }
    }
  </style>
      <!-- ============================================================== -->
      <!-- Start right Content here -->
      <!-- ============================================================== -->
      <div class="content-page">
          <!-- Start content -->
          <div class="content">
              <div class="container">
                      <div class="row">
                        <div class="col-lg-12">
                            <div style="margin-top:-30px" class="card-box">
                                <br>
                                <h1 class="title"><font color="#eb3986">Selamat Datang di E-learning GSM</font></h1>
                                <hr>
                                <p style="text-align:center;">
                                  Selamat datang peserta, ini adalah halaman pribadi Anda.<br>
                                  Aktivitas Anda terkait pelatihan ditampilkan di halaman ini.<br>
                                  Jika Anda belum pernah mengambil modul pelatihan, silahkan pilih modul <br>
                                  yang anda inginkan di halaman <a href="{{ url('/materibasic') }}">Modul Pelatihan</a>.<br>
                                  Jika Anda membutuhkan bantuan, silahkan menuju ke halaman <a href="#">FAQ & Bantuan</a>.<br>
                                </p>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-4 col-sm-6">
                            <div class="widget-panel widget-style-2 bg-white">
                                <i class="md  md-assignment text-primary"></i>
                                <h2 class="m-0 text-dark counter font-600" id="sum_ikut">?</h2>
                                <div class="text-muted m-t-5">Modul Sedang Diikuti</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="widget-panel widget-style-2 bg-white">
                                <i class="md  md-assignment-returned text-warning"></i>
                                <h2 class="m-0 text-dark counter font-600" id="sum_tunggu">?</h2>
                                <div class="text-muted m-t-5">Modul Menunggu Penilaian</div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="widget-panel widget-style-2 bg-white">
                                <i class="md  md-assignment-turned-in text-success"></i>
                                <h2 class="m-0 text-dark counter font-600" id="sum_selesai">?</h2>
                                <div class="text-muted m-t-5">Modul Telah Dinilai</div>
                            </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="panel panel-color panel-custom">
                            <div class="panel-heading">
                              <h3 class="panel-title">Modul yang Sedang Anda Ikuti</h3>
                            </div>
                            <div class="panel-body" id="modulIkut">

                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="panel panel-color panel-custom">
                            <div class="panel-heading">
                              <h3 class="panel-title">Modul yang Telah Anda Ikuti dan Dinilai</h3>
                            </div>
                            <div class="panel-body" id="modulSelesai">

                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-lg-12">
                          <div class="panel panel-color panel-custom">
                            <div class="panel-heading">
                              <h3 class="panel-title">Rekomendasi Modul Terbaru</h3>
                            </div>
                            <div class="panel-body" id="modulTerbaru">
                              
                            </div>
                          </div>
                        </div>
                      </div>

                  <!-- end row -->
              </div> <!-- container -->

          </div> <!-- content -->

          <footer class="footer text-right">
              © 2016. All rights reserved.
          </footer>

      </div>
      <script>
          $(document).ready(function(){
              requestPermission()
              var appurl = localStorage.getItem("url_elearning_gsm")
              var token_user=getCookie("token_login_user_gsm")
              var data_diri = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
              var assesorId = data_diri.assessor_id
              if(assesorId!==null){
                  var assesorId2 = { "user_id_lawan" : assesorId}
                  showthread2users(appurl, token_user, assesorId2)
              }
              var data_user_elearning_gsm = JSON.parse(localStorage.getItem('data_user_elearning_gsm'))
              var countIkut = 0; var countTunggu = 0; var countSelesai = 0;
              for (var i=0;i<data_user_elearning_gsm.quiz.length;i++){
                if (data_user_elearning_gsm.quiz[i].flag == 'enrolled') countIkut++
                else if (data_user_elearning_gsm.quiz[i].flag == 'answered') countTunggu++
                else if (data_user_elearning_gsm.quiz[i].flag == 'scored') countSelesai++
              }
              document.getElementById('sum_ikut').innerHTML = countIkut;
              document.getElementById('sum_tunggu').innerHTML = countTunggu;
              document.getElementById('sum_selesai').innerHTML = countSelesai;

              $.ajax({
                type: 'GET',
                url: "{{ url('/') }}/api/v1/users/home",
                headers: {"Authorization": "Bearer " + token_user}
              })
              .done(function(data, status){
                console.log(status)

                for (var i=0;i<data.quizIkut.length;i++){
                  if (i==4){
                    $('#modulIkut').append(
                      '<div class="row" style="text-align: right">'+
                        '<a class="btn btn-primary" href="{{ url("/detailuser") }}">Lainnya</a>'+
                      '</div>'
                    )
                    break;
                  } else {
                    var modul_deskripsi = data.quizIkut[i].modul.description
                    var modul_deskripsi_cut = modul_deskripsi.length > 100 ? modul_deskripsi.substring(0, 100-3)+"..." : modul_deskripsi
                    if ('image[0]' in data.quizIkut[i].modul) var modul_image = data.quizIkut[i].modul.image[0].filename
                    else var modul_image = 'modul.jpg'
                    $('#modulIkut').append(
                      '<div class="col-md-3" style="cursor:pointer" onclick=gotomodul("'+data.quizIkut[i].modul_id+'")>'+
                      '<div class="panel">'+
                        '<div class="panel-heading">'+
                          '<img class="img img-responsive" src="{{ url("/storage/images") }}/245/'+modul_image+'">'+
                        '</div>'+
                        '<div class="panel-body">'+
                          '<h3 class="post-title">'+data.quizIkut[i].modul.title+'</h3>'+
                          '<p style="font-size: 10px">'+modul_deskripsi_cut+'</p>'+
                        '</div>'+
                      '</div>'+
                    '</div>'
                    )
                  }
                }

                for (var i=0;i<data.quizSelesai.length;i++){
                  if (i==4){
                    $('#modulSelesai').append(
                      '<div class="row" style="text-align: right">'+
                        '<a class="btn btn-primary" href="{{ url("/detailuser") }}">Lainnya</a>'+
                      '</div>'
                    )
                    break;
                  } else {
                    var modul_deskripsi = data.quizSelesai[i].modul.description
                    var modul_deskripsi_cut = modul_deskripsi.length > 100 ? modul_deskripsi.substring(0, 100-3)+"..." : modul_deskripsi
                    console.log(data.quizSelesai[i].modul.image[0])
                    if ('image[0]' in data.quizSelesai[i].modul) var modul_image = data.quizSelesai[i].modul.image[0].filename
                    else var modul_image = 'modul.jpg'
                    $('#modulSelesai').append(
                      '<div class="col-md-3" style="cursor:pointer" onclick=gotomodul("'+data.quizSelesai[i].modul_id+'")>'+
                      '<div class="panel">'+
                        '<div class="panel-heading">'+
                          '<img class="img img-responsive" src="{{ url("/storage/images") }}/245/'+modul_image+'">'+
                        '</div>'+
                        '<div class="panel-body">'+
                          '<h3 class="post-title">'+data.quizSelesai[i].modul.title+'</h3>'+
                          '<p style="font-size: 10px">'+modul_deskripsi_cut+'</p>'+
                        '</div>'+
                      '</div>'+
                    '</div>'
                    )
                  }
                }

                for (var i=0;i<data.modulTerbaru.length;i++){
                  if (i==4){
                    $('#modulTerbaru').append(
                      '<div class="row" style="text-align: right">'+
                        '<a class="btn btn-primary" href="{{ url("/materibasic") }}">Lainnya</a>'+
                      '</div>'
                    )
                    break;
                  } else {
                    var modul_deskripsi = data.modulTerbaru[i].description
                    var modul_deskripsi_cut = modul_deskripsi.length > 100 ? modul_deskripsi.substring(0, 100-3)+"..." : modul_deskripsi
                    if ('image[0]' in data.modulTerbaru[i]) var modul_image = data.modulTerbaru[i].image[0].filename
                    else var modul_image = 'modul.jpg'
                    $('#modulTerbaru').append(
                      '<div class="col-md-3">'+
                      '<div class="panel">'+
                        '<div class="panel-heading">'+
                          '<img class="img img-responsive" src="{{ url("/storage/images") }}/245/'+modul_image+'">'+
                        '</div>'+
                        '<div class="panel-body">'+
                          '<h3 class="post-title">'+data.modulTerbaru[i].title+'</h3>'+
                          '<p style="font-size: 10px">'+modul_deskripsi_cut+'</p>'+
                          '<hr>'+
                          '<div class="row" style="text-align: right">'+
                            '<a class="btn btn-primary" onclick=enroll("'+data.modulTerbaru[i]._id+'")>Pelajari</a>'+
                            '</div>'+
                        '</div>'+
                      '</div>'+
                    '</div>'
                    )
                  }
                }

              })
          })
      </script>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
      integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
      crossorigin=""/>
      <!-- Make sure you put this AFTER Leaflet's CSS -->
      <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
      integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
      crossorigin=""></script>
      <script src="{{asset('assets/js/gsm.js')}}"></script>


      <!-- ============================================================== -->
      <!-- End Right content here -->
      <!-- ============================================================== -->
@endsection
