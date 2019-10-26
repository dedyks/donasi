@extends('layout.form')
@section('content')
<style>
.title{
    text-align:center;
    font-size:50px;
    font-family: 'Passion One', cursive;
    letter-spacing: 3px;
}
.buttonKirim{
    margin-left:-10px;margin-top:12px;text-align:left
}

.authorImage{
    float:left;margin-right:15px;width:50px;height: 50px;
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
                                    <div  style="margin-top:-20px" class="col-sm-12">
                                        <div class="card-box widget-inline" style="padding:10px">
                                            <div class="row" style="padding:15px">
                                                <div class="col-md-3" style="margin-bottom:10px">
                                                    <label style="font-size:15px;color: #505458"><i style="margin-right:5px;color:blueviolet" class="fa  fa-graduation-cap" aria-hidden="true"></i>Sekolah</label>
                                                    <select name="" onchange="selectSekolah()" data-live-search="true" data-style="btn-white" class="selectpicker" id="sekolah">
                                                        <option value="" selected>-</option>
                                                        <option  value="TK">TK</option>
                                                        <option  value="KB">KB</option>
                                                        <option  value="TPA">TPA</option>
                                                        <option  value="SPS">SPS</option>
                                                        <option  value="SD">SD</option>
                                                        <option  value="SMP">SMP</option>
                                                        <option  value="SDLB">SDLB</option>
                                                        <option  value="SMPLB">SMPLB</option>
                                                        <option  value="MI">MI</option>
                                                        <option  value="MTs">MTs</option>
                                                        <option  value="Paket A">Paket A</option>
                                                        <option  value="Paket B">Paket B</option>
                                                        <option  value="SMA">SMA</option>
                                                        <option  value="SMLB">SMLB</option>
                                                        <option  value="SMK">SMK</option>
                                                        <option  value="MA">MA</option>
                                                        <option  value="MAK">MAK</option>
                                                        <option  value="Paket C">Paket C</option>
                                                        <option  value="Akademik">Akademik</option>
                                                        <option  value="Politeknik">Politeknik</option>
                                                        <option  value="Sekolah Tinggi">Sekolah Tinggi</option>
                                                        <option  value="Institut">Institut</option>
                                                        <option  value="Universitas">Universitas</option>
                                                        <option  value="SLB">SLB</option>
                                                        <option  value="Kursus">Kursus</option>
                                                        <option  value="Keaksaraan">Keaksaraan</option>
                                                        <option  value="TBM">TBM</option>
                                                        <option  value="PKBM">PKBM</option>
                                                        <option  value="Life Skill">Life Skill</option>
                                                        <option  value="Satap TK SD">Satap TK SD</option>
                                                        <option  value="Satap SD SMP">Satap SD SMP</option>
                                                        <option  value="Satap TK SD SMP">Satap TK SD SMP</option>
                                                        <option  value="Satap SD SMP SMA">Satap SD SMP SMA</option>
                                                        <option  value="RA">RA</option>
                                                        <option  value="SMP Terbuka">SMP Terbuka</option>
                                                        <option  value="SMPTK">SMPTK</option>
                                                        <option  value="SMTK">SMTK</option>
                                                        <option  value="SDTK">SDTK</option>
                                                        <option  value="SPK PG">SPK PG</option>
                                                        <option  value="SPK TK">SPK TK</option>
                                                        <option  value="SPK SD">SPK SD</option>
                                                        <option  value="SPK SMP">SPK SMP</option>
                                                        <option  value="SPK SMA">SPK SMA</option>
                                                        <option  value="Pondok Pesantren">Pondok Pesantren</option>
                                                        <option  value="SMAg.K">SMAg.K</option>
                                                        <option  value="SKB">SKB</option>
                                                        <option  value="Taman Seminari">Taman Seminari</option>
                                                        <option  value="TKLB">TKLB</option>
                                                        <option  value="Pratama W P">Pratama W P</option>
                                                        <option  value="Adi W P">Adi W P</option>
                                                        <option  value="Madyama W P">Madyama W P</option>
                                                        <option  value="Utama W P">Utama W P</option>
                                                        <option  value="SMAK">SMAK</option>     
                                                    </select>
                                                </div>
                                                <div class="col-md-3" style="margin-bottom:10px">
                                                        <label style="font-size:15px;color: #505458"><i style="margin-right:5px;color:rgb(92, 192, 250)" class="fa  fa-home" aria-hidden="true"></i>Provinsi</label>
                                                        <select name="" onchange="selectProvinsi()" data-live-search="true" data-style="btn-white" class="selectpicker" id="provinsi"><option value="" selected >-</option>
                                                        </select>
                                                 </div>
                                                <div class="col-md-3" style="margin-bottom:10px">
                                                        <label style="font-size:15px;color: #505458"><i style="margin-right:5px;color:rgb(241, 60, 100)" class="fa fa-map" aria-hidden="true"></i>Kabupaten</label>
                                                        <select name="" onchange="selectKabupaten()" data-live-search="true" data-style="btn-white" class="selectpicker" id="kabupaten"><option value="" selected >-</option>
                                                        </select>    
                                                 </div>
                                                <div class="col-md-3" style="margin-bottom:10px">
                                                        <label style="font-size:15px;color: #505458"><i style="margin-right:5px;color:rgb(43, 226, 119)" class="fa  fa-institution" aria-hidden="true"></i>Workshop</label>
                                                        <select name="workshop" onchange="selectWorkshop()" data-live-search="true" data-style="btn-white" class="selectpicker" id="workshop"><option value="" selected>-</option>
                                                        </select>
                                                 </div>
                                                 <div class="col-md-12">
                                                        <button type="button" style="width:100%" class="btn btn-white waves-effect" onclick="terapkanFilter()" >Terapkan Filter</button>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="panel panel-color panel-custom">
                                            <div class="panel-body">
                                                    <input type="number" value="1" id="pagePagination" autocomplete="off" style="display:none" />
                                                    <input type="number" value="1" id="nextPage" autocomplete="off" style="display:none" />
                                                     <div  id="dibagi"></div>
                                                     <div class="col-md-12" style="text-align:center">
                                                        <button style="text-align:center;" id="loadMore" type="button" onclick="loadMore()" class="btn btn-default waves-effect waves-light">
                                                        <span id="loadText"> Load More </span>
                                                        <i id="uploadLoadingIconKonten" style="display:none" class="fa-spin fa-spinner"></i>
                                                        </button>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                    </div> <!-- container -->
                </div> <!-- content -->
                <footer class="footer text-right">
                    © 2019. All rights reserved.
                </footer>
            </div>

            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

            <script>
            $(document).ready(function(){
                var page = parseInt(document.getElementById("nextPage").value, 10)
                var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                var id = dataUser._id
                var urlImage =  {!! json_encode(url('/')) !!}
                getprov()
                mountArtikel(page, id, urlImage, "allKonten" )
                getkupon()
            })

            function terapkanFilter(){
                document.getElementById('pagePagination').value = 1
                document.getElementById('nextPage').value = 1
                $("#dibagi")
                .find('div')
                .remove()
                var page = parseInt(document.getElementById("nextPage").value, 10)
                var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                var id = dataUser._id
                var urlImage =  {!! json_encode(url('/')) !!}
                mountArtikel(page, id, urlImage, "filterKonten" )
            }

            function getkupon(){
                var appurl = localStorage.getItem("url_elearning_gsm")
                axios.get(appurl+"v1/article/kupon/list")
                .then(res=>{
                    console.log(res)
                    var jumlahKupon = res.data.data.length
                    var kupon = ''
                    for(var i = 0 ; i<jumlahKupon ; i++ ){
                        kupon += '<option value="'+res.data.data[i]+'"'+'>' +res.data.data[i]+'</option>'
                    }
                    $("select[id='workshop']").append(kupon);
                    $("select[id='workshop']").selectpicker("refresh");
                })
                .catch(err=>{
                    console.log(err)
                })
            }

            function getprov(){
                var appurl = localStorage.getItem("url_elearning_gsm")
                axios.get(appurl+"v1/article/filter/propinsi")
                .then(res=>{
                    var jumlahProv = res.data.data.length
                    var prov = ''
                    for(var i = 0; i<jumlahProv;i++){
                        prov += '<option value="'+res.data.data[i]+'"'+'>' +res.data.data[i]+'</option>'
                    }
                    $("select[id='provinsi']").append(prov);
                    $("select[id='provinsi']").selectpicker("refresh");
                  
                })
                .catch(err=>{
                    console.log(err)
                })
            }

            function loadMore(){
                document.getElementById("loadText").style.display="none"
                document.getElementById("uploadLoadingIconKonten").style.display="block"
                var page = parseInt(document.getElementById("nextPage").value, 10)
                var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                var id = dataUser._id
                var urlImage =  {!! json_encode(url('/')) !!}
                mountArtikel(page, id, urlImage, "allKonten")
            }

            function selectSekolah(){
                console.log(document.getElementById('sekolah').value)
            }

            function selectProvinsi(){
                $('#kabupaten')
                .find('option')
                .remove()
                $("#kabupaten").selectpicker("refresh");
                var provinsi = document.getElementById('provinsi').value
                $(document).ajaxStart(function() { Pace.restart(); });
                $.ajax({
                    url: appurl+'v1/article/filter/kabupaten?propinsi='+provinsi,
                    type: 'GET'
                })
                .done(function(data, status){
                    console.log(data)
                    var jumlahKab = data.data.length
                    var kab = '<option  selected value="">-</option>'
                    for(var i = 0; i<jumlahKab;i++){
                        kab += '<option value="'+data.data[i]+'"'+'>' +data.data[i]+'</option>'
                    }
                    $("select[id='kabupaten']").append(kab);
                    $("select[id='kabupaten']").selectpicker("refresh");

                })
                .fail(function(data, status){
                    // console.log(data)
                    swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
                })
            }

            function selectKabupaten(){
                console.log(document.getElementById('kabupaten').value)
            }   

            function selectWorkshop(){
                console.log(document.getElementById('workshop').value)
            }
            </script>
        @endsection