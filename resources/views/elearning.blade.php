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
                                            <h1 class="title"> <b> <font color="#eb3986">SELAMAT</font> <font color="#eb3986">DATANG</font></b> </h1>
                                            <p  style="text-align:center;">Lorem ipsum dolor sit amet, id suas scripta efficiendi pri. </p>   
                                            <div style="margin-top:30px" id="carousel-example-captions" data-ride="carousel" class="carousel slide">
                                                    <ol class="carousel-indicators">
                                                        <li data-target="#carousel-example-captions" data-slide-to="0" class="active"></li>
                                                        <li data-target="#carousel-example-captions" data-slide-to="1"></li>
                                                        <li data-target="#carousel-example-captions" data-slide-to="2"></li>
                                                    </ol>
                                                    <div role="listbox" class="carousel-inner">
                                                        <div class="item active">
                                                            <img src="{{asset('assets/images/gsm_slide_welcome_page_1.jpg')}}" alt="First slide image">
                                                            <div class="carousel-caption">
                                                                <h3 class="text-white font-600">First slide label</h3>
                                                                <p>
                                                                    Nulla vitae elit libero, a pharetra augue mollis interdum.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <img src="{{asset('assets/images/gsm_slide_welcome_page_2.jpg')}}" alt="Second slide image">
                                                            <div class="carousel-caption">
                                                                <h3 class="text-white font-600">Second slide label</h3>
                                                                <p>
                                                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="item">
                                                            <img src="{{asset('assets/images/gsm_slide_welcome_page_3.jpg')}}" alt="Third slide image">
                                                            <div class="carousel-caption">
                                                                <h3 class="text-white font-600">Third slide label</h3>
                                                                <p>
                                                                    Praesent commodo cursus magna, vel scelerisque nisl consectetur.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="#carousel-example-captions" role="button" data-slide="prev" class="left carousel-control"> <span aria-hidden="true" class="fa fa-angle-left"></span> <span class="sr-only">Previous</span> </a>
                                                    <a href="#carousel-example-captions" role="button" data-slide="next" class="right carousel-control"> <span aria-hidden="true" class="fa fa-angle-right"></span> <span class="sr-only">Next</span> </a>
                                                </div>                     			
                                        </div>     
                                                          
                                    </div>
                                </div>

                                <div class="row">
                                        <div class="col-md-12" style="text-align:center;display:block;" id="loading">
                                                <img src="assets/images/ajax-loader.gif" alt="image" style="" class="img-rounded" width="50"/>
                                            </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="widget-panel widget-style-2 bg-white">
                                            <i class="md  md-account-balance text-primary"></i>
                                            <h2 class="m-0 text-dark counter font-600"><span id="sekolah_gsm"></span></h2>
                                            <div class="text-muted m-t-5">Sekolah GSM</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="widget-panel widget-style-2 bg-white">
                                            <i class="md  md-store-mall-directory text-pink"></i>
                                            <h2 class="m-0 text-dark counter font-600"><span id="sekolah_terdaftar"></span></h2>
                                            <div class="text-muted m-t-5">Sekolah Terdaftar</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="widget-panel widget-style-2 bg-white">
                                            <i class="md  md-assignment-ind text-info"></i>
                                            <h2 class="m-0 text-dark counter font-600"><span id="user"></span></h2>
                                            <div class="text-muted m-t-5">User</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-sm-6">
                                        <div class="widget-panel widget-style-2 bg-white">
                                            <i class="md md-account-child text-custom"></i>
                                            <h2 class="m-0 text-dark counter font-600"><span id="assesor"></span></h2>
                                            <div class="text-muted m-t-5">assessor</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card-box">
                                            <h4 class="text-dark header-title m-t-0">Peta Persebaran Sekolah Model GSM & Terdaftar</h4>
                                            <img src="{{asset('assets/images/flag_yellow.png')}}" alt=""> <span> : Sekolah Model GSM</span>
                                            <br>
                                            <br>
                                            <img src="{{asset('assets/images/flag.png')}}" style="width:20px" alt=""> <span> : Sekolah Jejaring GSM</span>
                                            <br>
                                            <br>
                                            <div id="mapid" class="row" style="width: 100%; height: 400px;"></div>
                     			
                                            <!-- end row -->                      			
                                        </div>                              
                                    </div>
                                </div>
                        

                        <div class="col-lg-4">
                        		<div class="card-box p-0">
                        			<div class="profile-widget text-center">
			                            <div class="bg-custom bg-profile"></div>
			                            <img src="assets/images/users/avatar-1.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
			                            <h4>Arga Wirawan</h4>
                                        <p class="text-muted">SD Negeri 1 Caturtunggal</p>
			                            <p class="m-t-10 text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
                                        <a href="#" class="btn btn-sm btn-primary m-b-20">View User</a>
			                        </div>
                        		</div>
                            </div> <!-- end col -->

                            
                        <div class="col-lg-4">
                        		<div class="card-box p-0">
                        			<div class="profile-widget text-center">
			                            <div class="bg-custom-green bg-profile"></div>
			                            <img src="assets/images/users/avatar-2.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
			                            <h4>Dedy Kurniawan S</h4>
                                        <p class="text-muted">SD Negeri 2 Caturtunggal</p>
			                            <p class="m-t-10 text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
                                        <a href="#" class="btn btn-sm btn-primary m-b-20">View User</a>
			                        </div>
                        		</div>
                            </div> <!-- end col -->

                            
                        <div class="col-lg-4">
                        		<div class="card-box p-0">
                        			<div class="profile-widget text-center">
			                            <div class="bg-custom-pink bg-profile"></div>
			                            <img src="assets/images/users/avatar-3.jpg" class="thumb-lg img-circle img-thumbnail" alt="img">
			                            <h4>Ahmadi Ammar A.R</h4>
                                        <p class="text-muted">SD Negeri 3 Caturtunggal</p>
			                            <p class="m-t-10 text-muted p-20">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas lobortis magna quis ante auctor commodo.</p>
                                        <a href="#" class="btn btn-sm btn-primary m-b-20">View User</a>
			                        </div>
                        		</div>
                            </div> <!-- end col -->
                            
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
                    if(assesorId !==null){
                        // console.log("assessor id tidak null")
                        var assesorId2 = { "user_id_lawan" : assesorId}
                        showthread2users(appurl, token_user, assesorId2)
                    }else{
                        document.getElementById('loading').style.display="none"
                        // console.log("assessor id null")
                    }
                    var data_user_elearning_gsm = JSON.parse(localStorage.getItem('data_user_elearning_gsm'))
                    
                    $.ajax({
                    type: 'GET',
                    url :appurl+"v1/elearning/analytic"

                    }).done(function(data, status){
                        document.getElementById('sekolah_gsm').innerHTML = data.sekolahGsm
                        document.getElementById('sekolah_terdaftar').innerHTML = data.sekolahTerdaftar
                        document.getElementById('assesor').innerHTML = data.jumlahassessor
                        document.getElementById('user').innerHTML = data.jumlahUser
                    }).fail(function(data,status){
                        swal("Terjadi Kesalahan", "Mohon cek koneksi internet Anda")
                        // console.log(status)
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
<script>

	


		// .bindPopup("<b>Test</b><br />Maps").openPopup();
        var appurl = "{{env('APP_URL')}}"
        var baseurl = "{{env('APP_BASEURL')}}"

        $.ajax({
           type: 'GET',
           

           url :appurl+"v1/school-gsm/map"

           }).done(function(datas, status){
            var mymap = L.map('mapid').setView([-7.7, 110.3], 4);
               L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox.streets'
	}).addTo(mymap);

                var blueIcon = L.icon({
                                iconUrl: baseurl+'assets/images/flag.png',
                                iconSize: [25, 25],
                                popupAnchor:[10, -13],                                
                            });
                var yellowIcon = L.icon({
                    iconUrl: baseurl+'assets/images/flag_yellow.png',
                    iconSize: [25, 25],
                    iconAnchor: [-10, 13],                    
                });              
               var school_pengikut_gsm = []
               for(i=0;i<datas.SekolahTerdaftar.length;i++){
                school_pengikut_gsm += '["'
                school_pengikut_gsm += datas.SekolahTerdaftar[i].sekolah
                school_pengikut_gsm += '",'
                school_pengikut_gsm += datas.SekolahTerdaftar[i].lokasi[1]
                school_pengikut_gsm += ','
                school_pengikut_gsm += datas.SekolahTerdaftar[i].lokasi[0]
                school_pengikut_gsm += ',"'
                school_pengikut_gsm += datas.SekolahTerdaftar[i].propinsi
                school_pengikut_gsm += '","'
                school_pengikut_gsm += datas.SekolahTerdaftar[i].kabupaten_kota
                school_pengikut_gsm += '","'
                school_pengikut_gsm += datas.SekolahTerdaftar[i].kecamatan
                school_pengikut_gsm += '","'
                school_pengikut_gsm += datas.SekolahTerdaftar[i].alamat_jalan
                school_pengikut_gsm += '","'

                school_pengikut_gsm += datas.SekolahTerdaftar[i]._id
                school_pengikut_gsm += '"'

                school_pengikut_gsm += ']'
               if (i==datas.SekolahTerdaftar.length-1) {
                school_pengikut_gsm +=''
               }else {
                school_pengikut_gsm +=','
               }
               }
               var obj_1 = JSON.parse("["+school_pengikut_gsm+"]");
               var schools_pengikut_gsm = obj_1;
        
               
               for (var i = 0; i < schools_pengikut_gsm.length; i++) {
                   var school = schools_pengikut_gsm[i];
                   markers = new L.marker([school[1],school[2]]).bindPopup("<a href='"+baseurl+"sekolah/detail?id="+school[7]+"'><b>"+school[0]+"</a></b><br>"+school[3]+"<br>"+school[4]+"<br>"+school[5]+"<br>"+school[6]).addTo(mymap)
               }

               var school_gsm = []
               for(i=0;i<datas.SekolahModelGsm.length;i++){
                school_gsm += '["'
                school_gsm += datas.SekolahModelGsm[i].sekolah
                school_gsm += '",'
                school_gsm += datas.SekolahModelGsm[i].lokasi[1]
                school_gsm += ','
                school_gsm += datas.SekolahModelGsm[i].lokasi[0]
                school_gsm += ',"'
                school_gsm += datas.SekolahModelGsm[i].propinsi
                school_gsm += '","'
                school_gsm += datas.SekolahModelGsm[i].kabupaten_kota
                school_gsm += '","'
                school_gsm += datas.SekolahModelGsm[i].kecamatan
                school_gsm += '","'
                school_gsm += datas.SekolahModelGsm[i].alamat_jalan
                school_gsm += '","'

                school_gsm += datas.SekolahModelGsm[i]._id
                school_gsm += '"'

                school_gsm += ']'
               if (i==datas.SekolahModelGsm.length-1) {
                school_gsm +=''
               }else {
                school_gsm +=','
               }
               }
               var obj_2 = JSON.parse("["+school_gsm+"]");
               var schools_pengikut_gsm = obj_2;  
               
               for (var i = 0; i < schools_pengikut_gsm.length; i++) {
                   var school = schools_pengikut_gsm[i];
                   markers = new L.marker([school[1],school[2]],{icon: yellowIcon}).bindPopup("<a href='"+baseurl+"sekolah/detail?id="+school[7]+"'><b>"+school[0]+"</a></b><br>"+school[3]+"<br>"+school[4]+"<br>"+school[5]+"<br>"+school[6]).addTo(mymap)                  
               }
            //    L.marker([-6.1810,106.838]).addTo(mymap)

           })
           .fail(function(data, status){
            // console.log(data)
            console.log("Terjadi Kesalahan", "Cek koneksi internet Anda dan ulangi");
           })
           
	

	var popup = L.popup();

	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent("You clicked the map at " + e.latlng.toString())
			.openOn(mymap);
	}

	
</script>

            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
        @endsection