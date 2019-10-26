@extends('layout.dashboard')
@section('content')
<link rel="stylesheet" href="{{asset('assets/plugins/pace_master/themes/red/pace-theme-flash.css')}}">
<script src="{{asset('assets/plugins/pace_master/pace.js')}}" type="text/javascript"></script>
{{-- Table --}}
<link href="{{asset('assets/plugins/datatables/responsive.bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('assets/plugins/datatables/jquery.dataTables.min.css')}}" rel="stylesheet" type="text/css"/>
{{-- <link href="{{asset('assets/plugins/datatables/fixedColumns.dataTables.min.css')}}" rel="stylesheet" type="text/css"/> --}}
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>

{{-- <script src="{{asset('assets/plugins/datatables/dataTables.fixedHeader.min.js')}}"></script> --}}
{{-- <script src="{{asset('assets/plugins/datatables/dataTables.keyTable.min.js')}}"></script> --}}
<script src="{{asset('assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables/responsive.bootstrap.min.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/datatables/dataTables.fixedColumns.min.js')}}"></script> --}}
<script src="https://kit.fontawesome.com/c3094cfefd.js"></script>
<script src="{{asset('assets/pages/datatables.init.js')}}"></script>
       

<style>
.title{
    text-align:center;
    font-size:50px;
    font-family: 'Passion One', cursive;
    letter-spacing: 3px;
}

@media only screen and (max-width: 600px) {
    .title-1{
    padding-left: 10px;
    padding-right: 10px;
    font-size:25px;
    }

    .m-b-10{
        margin-bottom: 10px;
        margin-left:-10px
    }

    .descriptionText{
    font-size: 14px;
    padding-left:10px;
    padding-right:10px;
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
                                        <div class="card-box widget-inline">
                                            <div class="row">
                                                    <div style="text-align:center"class="col-md-12">
                                                    <h1 class="title-1"> 
                                                    <b>
                                                    Persebaran Sekolah Model GSM 
                                                    </b>
                                                    </h1>
                                                    <p class="descriptionText">Anda dapat melihat persebaran Sekolah Model GSM & user/sekolah jejaring di E-Learning ini</p>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-color panel-custom">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Tabel Persebaran Sekolah</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-md-4 m-b-10">
                                                    <p><b>Pilih Subjek</b></p>
                                                    <select class="selectpicker" data-live-search="true" id="sekolah"  data-style="btn-white" onchange="choose_sekolah(this.value)">
                                                            <option selected disabled>Please Select</option>
                                                            <option value="model-daerah">Sekolah Model GSM</option>
                                                            <option value="terdaftar-daerah">Sekolah Jejaring GSM</option> 
                                                        </select>
                                                </div>
                                                <div style="margin-bottom:20px" class="col-md-4 m-b-10">
                                                        <p><b>Pilih Lokasi Tersedia</b></p>
                                                        <select class="selectpicker" data-live-search="true" id="daerah" name="daerah[]" data-style="btn-white"  onchange="choose_daerah(this.value)">
                                                             <option selected disabled>Please Select</option>
                                                        </select>
                                                </div>

                                                <div class="row">
                                                        <div class="col-sm-12">
                                                                <p>Berikut ini adalah sekolah yang tersedia berdasarkan jenis sekolah dan daerah yang dipilih</p>
                                                            <br>
                                                            <div class="card-box table-responsive">
                                                                <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                            <th>Nama Sekolah</th>
                                                                            <th>Provinsi</th>
                                                                            <th>Kabupaten</th>
                                                                            <th>Kecamatan</th>
                                                                            <th>Alamat Jalan</th>
                                                                            <th>Status</th>
                                                                            <th>Maps</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
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
            <script>
            var choose_sekolah;
            var choose_daerah;
            $(document).ready(function(){
            
            choose_daerah = function(value){
                var appurl = localStorage.getItem("url_elearning_gsm")
                
                if(document.getElementById('sekolah').value == "terdaftar-daerah"){
                    var sekolah = "terdaftar"
                }else if(document.getElementById('sekolah').value == "model-daerah"){
                    var sekolah = "model-gsm"
                }
                var datas = {
                    "kabupaten_kota": value
                }

                $.ajax({
                    type: 'POST',
                    url : appurl+"v1/school-gsm/list/"+sekolah, 
                    headers: {
                        "Content-Type": "application/json"
                    },
                    data : JSON.stringify(datas)
                    }).done(function(data, status){
                        // Memasukan respon data dari api ke dalam variable baru : myJsonData
						myJsonData = data.data;
						
						// Ini memanggil fungsi populateDataTable dengan parameter yang diisi dengan data dari myJsonData 
						populateDataTable(myJsonData);
                        
                    }).fail(function(data, status){
                        swal("Terjadi Kesalahan", "Mohon cek koneksi internet Anda")
                    })
                    function populateDataTable(data) {
						$("#datatable-fixed-header").DataTable().clear();

						// Ini digunakan untuk menghitung jumlah data yang ada di parameter data, 
						// karena parameter data yang dimasukan adalah myJsonData maka jumlah data yang
						// akan dihitung adalah jumlah data myJsonData itu sendiri 
						var length = data.length;

						// Perulangan for untuk memasukan data ke variable, akan diulang sekian kali sesuai length nya
						for (var i = 0; i < length; i++) {
						
						// data name urutan ke i
						var a=data[i].sekolah;
						// data email sekolah urutan ke i
						var b=data[i].propinsi;
						// data asal sekolah urutan ke i
                        var c = data[i].kabupaten_kota;
                        var d = data[i].kecamatan
                        var e = data[i].alamat_jalan
                        if(data[i].status=="N"){
                            var status = "Negeri"
                        }else if(data[i].status == "S"){
                            var status = "Swasta"
                        }
                        var f = status
						
						// Ini membuat tombol edit yang diklik akan dialihkan ke page detail by id  dan tombol add to assesr yg ketika diklik dia akan memanggil fungsi add to assesor dengan parameternya id dari data itu sendiri
						var action = "<a href='http://maps.google.com/?q="+data[i].lokasi[1]+","+data[i].lokasi[0]+"' target='_blank'>Open</a>";
						$('#datatable-fixed-header').dataTable().fnAddData([
						a,
						b,
                        c,
                        d,
                        e,
                        f,
						action
						]);
						}
					}

            }
            choose_sekolah = function(value){
                var appurl = localStorage.getItem("url_elearning_gsm")
                $(document).ajaxStart(function() { Pace.restart(); });
                $("#daerah")
                .find('option')
                .remove()
                $("#daerah").selectpicker("refresh");
                $.ajax({
                    type: 'GET',
                    url :appurl+"v1/school-gsm/"+value
                    }).done(function(data, status){
                        swal("Cek", "Pilihan untuk lokasi tersedia");
                        var jumlah_daerah = data.data.length
                        var daerah = '<option  selected disabled>Please select</option>'
                        for(var i = 0; i<jumlah_daerah;i++){
                            daerah += '<option  id ="'+data.data[i]._id.kabupaten_kota+'"'+ 'value="'+data.data[i].kabupaten_kota +'"'+'>' +data.data[i].kabupaten_kota+'</option>'
                        }
                        $("select[name='daerah[]']").append(daerah);
                        $("select[name='daerah[]']").selectpicker("refresh");

                    }).fail(function(data, status){
                        swal("Terjadi Kesalahan", "Cek koneksi internet Anda dan ulangi");

                    })
                }
                })
            </script>
            
            
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


        @endsection