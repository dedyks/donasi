<script src="{{asset('assets/js/gsm.js')}}"></script>
<!-- basic stylesheet -->
<link rel="stylesheet" href="{{asset('assets/plugins/royalslider/royalslider.css')}}">

<!-- skin stylesheet (change it if you use another) -->
<link rel="stylesheet" href="{{asset('assets/plugins/royalslider/skins/default/rs-default.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/royalslider/minimal-white/rs-minimal-white.css')}}"> 

<!-- Plugin requires jQuery 1.8+, use the latest version  -->
<!-- If you already have jQuery on your page, you shouldn't include it second time. -->
<script src="{{asset('assets/plugins/royalslider/jquery-1.8.3.min.js')}}"></script>

<!-- Main slider JS script file -->
<!-- Create it with slider online build tool for better performance. -->
<script src="{{asset('assets/plugins/royalslider/jquery.royalslider.min.js')}}"></script>

<html>
<head>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
</head>
<body>


<div id="mapid" style="width: 100%; height: 100%;"></div>
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



<div class="royalSlider rsDefault">
    <!-- simple image slide -->
    <img class="rsImg" data-rsVideo="https://youtu.be/drzo0ZPNq_k" alt="image desc" />

    <img class="rsImg" data-rsVideo="https://youtu.be/Gpam94b3j_s" alt="image desc" />

    <img class="rsImg" data-rsVideo="https://youtu.be/9mySpVum4Ug" alt="image desc" />

    <img class="rsImg" data-rsVideo="https://youtu.be/eamiOJRDoy8" alt="image desc" />

    <!-- lazy loaded image slide -->
    <a class="rsImg"  href="https://dimsemenov.com/plugins/royal-slider/img/paintings/700x500/2.jpg">image desc <img src="https://dimsemenov.com/plugins/royal-slider/img/paintings/700x500/2.jpg" class="rsTmb" /></a>

    <!-- HTML content slide -->

    <!-- image and content -->
    <div>
        <img class="rsImg" src="https://dimsemenov.com/plugins/royal-slider/img/paintings/700x500/2.jpg" data-rsVideo="https://youtu.be/fqdZTAEZIP4" />
    </div>

    <!-- HTML content -->
  

    <!-- HTML content (100% with and height) -->

</div>	

<script>
    jQuery(document).ready(function($) {
        $(".royalSlider").royalSlider({
            // options go here
            // as an example, enable keyboard arrows nav
            keyboardNavEnabled: true,
            controlsInside: true,
            fullscreen: {
                // fullscreen options go gere
                enabled: true,
                nativeFS: false
                },
            // visibleNearby: {
            //     enabled: true,
            //     centerArea: 0.5,
            //     center: true,
            //     breakpoint: 650,
            //     breakpointCenterArea: 0.64,
            //     navigateByCenterClick: true
            // },
            autoScaleSlider: true,
            controlNavigation: 'thumbnails',
            thumbs: {
                spacing: 10,
                arrowsAutoHide: true
            }   

        });  
    });
</script>


</body>
</html>