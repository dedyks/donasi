@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Home</title>
@endsection

@section('css')
  <style>
      #map {
          height: 400px;  /* The height is 400 pixels */
          width: 100%;  /* The width is the width of the web page */
      }
  </style>
@endsection
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
@section('content')
  <div class="content-page">
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h4 class="page-title">Home</h4>
            <ol class="breadcrumb">
              <li class="active">
                Home
              </li>
            </ol>
          </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="widget-panel widget-style-2 bg-white">
                    <i class="md  md-account-balance text-primary"></i>
                    <h2 class="m-0 text-dark counter font-600" id="sum_model">?</h2>
                    <div class="text-muted m-t-5">Sekolah<br>Model<br>GSM</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="widget-panel widget-style-2 bg-white">
                    <i class="md  md-store-mall-directory text-pink"></i>
                    <h2 class="m-0 text-dark counter font-600" id="sum_jejaring">?</h2>
                    <div class="text-muted m-t-5">Sekolah<br>Jejaring<br>GSM</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="widget-panel widget-style-2 bg-white">
                    <i class="md  md-assignment-ind text-info"></i>
                    <h2 class="m-0 text-dark counter font-600" id="sum_mentor">?</h2>
                    <div class="text-muted m-t-5">&nbsp<br>Mentor<br>&nbsp</div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="widget-panel widget-style-2 bg-white">
                    <i class="md md-account-child text-custom"></i>
                    <h2 class="m-0 text-dark counter font-600" id="sum_user">?</h2>
                    <div class="text-muted m-t-5">&nbsp<br>User<br>&nbsp</div>
                </div>
            </div>
        </div>

        <div class="row">
          <div class="col-lg-12">
          <div class="card-box" >
                                            <h4 class="text-dark header-title m-t-0">Peta Persebaran Sekolah Model GSM & Terdaftar</h4>
                                            <img src="{{asset('assets/images/flag_yellow.png')}}" alt=""> <span> : Sekolah Model GSM</span>
                                            <br>
                                            <br>
                                            <img src="{{asset('assets/images/flag.png')}}" style="width:20px" alt=""> <span> : Sekolah Jejaring GSM</span>
                                            <br>
                                            <br>
                                            <div id="mapid" class="row" style="width: 100%; height: 100%;"></div>
                     			
                                            <!-- end row -->                      			
                                        </div>   
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<!-- <script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 5,
            center: {lat: -2.5489, lng: 118.0149}
        });

        setMarkers(map);
    }

    function setMarkers(map) {
        var appurl = localStorage.getItem("url_elearning_gsm")
        $.ajax({
            type: 'GET',
            url :appurl+"v1/school-gsm/map"
        })
        .done(function(datas, status){
            console.log(status)

            var school_pengikut_gsm = []
            for(i=0;i<datas.SekolahTerdaftar.length;i++){
                school_pengikut_gsm += '["'
                school_pengikut_gsm += datas.SekolahTerdaftar[i].sekolah
                school_pengikut_gsm += '",'
                school_pengikut_gsm += datas.SekolahTerdaftar[i].lokasi[1]
                school_pengikut_gsm += ','
                school_pengikut_gsm += datas.SekolahTerdaftar[i].lokasi[0]
                school_pengikut_gsm += ']'
                if (i==datas.SekolahTerdaftar.length-1) {
                    school_pengikut_gsm +=''
                } else {
                    school_pengikut_gsm +=','
                }
            }

            var obj_1 = JSON.parse("["+school_pengikut_gsm+"]");
            //console.log(obj_1)
            var schools_pengikut_gsm = obj_1
            var image = {
                url: '{{asset('assets/images/flag.png')}}',
                size: new google.maps.Size(20, 32),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(0, 32)
            };
            var shape = {
                coords: [1, 1, 1, 20, 18, 20, 18, 1],
                type: 'poly'
            }
            for (var i = 0; i < schools_pengikut_gsm.length; i++) {
                var school = schools_pengikut_gsm[i];
                var marker = new google.maps.Marker({
                    position: {lat: school[1], lng: school[2]},
                    map: map,
                    icon: image,
                    shape: shape,
                    title: school[0],
                    zIndex: school[3]
                })
            }


            var school_gsm = []
            for(i=0;i<datas.SekolahModelGsm.length;i++){
                school_gsm += '["'
                school_gsm += datas.SekolahModelGsm[i].sekolah
                school_gsm += '",'
                school_gsm += datas.SekolahModelGsm[i].lokasi[1]
                school_gsm += ','
                school_gsm += datas.SekolahModelGsm[i].lokasi[0]
                school_gsm += ']'
                    if (i==datas.SekolahModelGsm.length-1) {
                school_gsm +=''
                } else {
                    school_gsm +=','
                }
            }

            var obj2 = JSON.parse("["+school_gsm+"]");
            //console.log(obj2)
            var schools_gsm = obj2
            var image = {
                url: '{{asset('assets/images/flag_yellow.png')}}',
                size: new google.maps.Size(20, 32),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(0, 32)
            };
            var shape = {
                coords: [1, 1, 1, 20, 18, 20, 18, 1],
                type: 'poly'
            };
            for (var i = 0; i < schools_gsm.length; i++) {
                var school = schools_gsm[i];
                var marker = new google.maps.Marker({
                    position: {lat: school[1], lng: school[2]},
                    map: map,
                    icon: image,
                    shape: shape,
                    title: school[0],
                    zIndex: school[3]
                })
            }
        })
        .fail(function(data, status){
            console.log(status)
        })
    }
    </script> -->
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
               console.log(datas)
              
             
         
               

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
                   console.log(school)
                   markers = new L.marker([school[1],school[2]],{icon: blueIcon}).bindPopup("<a href='"+baseurl+"sekolah/detail?id="+school[7]+"'><b>"+school[0]+"</a></b><br>"+school[3]+"<br>"+school[4]+"<br>"+school[5]+"<br>"+school[6]).addTo(mymap)

                  
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
                   console.log(school)
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

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAS6ZdI6zn_QX7ceEWJtdFzdCMuHQijNmc&callback=initMap">
    </script>
    <script>
      $(document).ready(function(){
        $.ajax({
          type: 'GET',
          url: "{{ url('/') }}/api/v1/elearning/analytic",
        })
        .done(function(data, status){
          console.log(status);

          document.getElementById('sum_model').innerHTML = data.sekolahGsm;
          document.getElementById('sum_jejaring').innerHTML = data.sekolahTerdaftar;
          document.getElementById('sum_mentor').innerHTML = data.jumlahassessor;
          document.getElementById('sum_user').innerHTML = data.jumlahUser;
        })
      })
    </script>
@endsection
