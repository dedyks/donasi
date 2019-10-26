@extends('layout.form')
@section('content')
<link href="{{asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-color panel-custom">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Update Profile</h3>
                                            </div>
                                            <div class="panel-body">                                         
                                                    <div class="col-md-4">
                                                        <h5><b>Nama lengkap :</b></h5>
                                                        <input type="text" class="form-control" id="nama" placeholder="Inputkan Nama">            
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h5><b>Tempat lahir :</b></h5>
                                                        <input type="text" id="tempat_lahir" class="form-control">            
                                                    </div>
                                                    <div class="col-md-4">
                                                            <h5><b>Tanggal lahir :</b></h5>
                                                            <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose">                                                    </div>
                                                    <div class="col-md-4">
                                                            <h5><b>Sudah Pernah ikut Workshop GSM ? </b></h5>
                                                            <select class="selectpicker" data-live-search="true"  data-style="btn-white" id="workshop">
                                                                <option selected disabled>Please Select</option>
                                                                <option value=true>Sudah Pernah</option>
                                                                <option value=false>Belum Pernah</option>
                                                            </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                            <h5><b>Gender :</b></h5>
                                                            <select class="selectpicker" data-live-search="true"  data-style="btn-white" id="gender">
                                                                <option selected disabled>Please Select</option>
                                                                <option value="Pria">Pria</option>
                                                                <option value="Wanita">Wanita</option>
                                                            </select>         
                                                    </div>
                                                    <div class="col-md-4">
                                                            <h5><b>Posisi di sekolah :</b></h5>
                                                            <select class="selectpicker" data-live-search="true"  data-style="btn-white" id="posisi">
                                                                <option selected disabled>Please Select</option>
                                                                <option value="Guru">Guru</option>
                                                                <option value="Kepala Sekolah">Kepala Sekolah</option>
                                                                <option value="Lainnya">Lainnya</option>
                                                            </select>               
                                                    </div>
                                                    <div class="col-md-4">
                                                            <h5><b>Pendidikan terakhir :</b></h5>
                                                            <select class="selectpicker" data-live-search="true"  data-style="btn-white" id="pendidikan">
                                                                <option selected >Please Select</option>
                                                                <option value="SMA">SMA</option>
                                                                <option value="S1">S1</option>
                                                                <option value="S2">S2</option>
                                                                <option value="S3">S3</option>
                                                            </select>                                                               </div>
                                                    <div class="col-md-4">
                                                            <h5><b>Nomor WA/HP :</b></h5>
                                                            <input type="text" class="form-control" id="no_wa">            
                                                        </div>
                                                        <input type="text" id="id" style="display:none">
                                                    <div class="col-md-4">
                                                        </div>
                                           <div class="col-md-12">
                                                <button style="float:right;margin-top:10px" type="button" class="btn btn-default waves-effect waves-light" id="update">Update</button>
                                            </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                            <div class="panel panel-color panel-custom">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Foto Profil Anda </h3>
                                                </div>
                                                <div class="panel-body">
                                                <div style="text-align:center;margin-bottom:20px" class="col-md-4" id="fotoUser">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="row">
                                                            <form class="form-horizontal m-t-20">
                                                            <div style="margin-top:-20px" class="col-md-8">
                                                                    <h5><b>Ubah Foto Profil</b></h5>
                                                                    <p>Tidak boleh melebihi 2 MB</p>
                                                                    <input type="file" class="filestyle" data-icon="false" id="foto_user" name="image" data-buttonname="btn-white">
                                                                </div>
                                                            </form>
                                                            <div style="margin-top:20px" class="col-md-8">                                                        
                                                                    <button style="float:left" type="button" class="btn btn-default waves-effect waves-light" onclick="updatefoto()"><i style="display:none" id="iconLoading" class="fa fa-spin fa-spinner"> </i><span id="sendText">Update Foto</span></button>
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
                    © 2016. All rights reserved.
                </footer>

            </div>
            
            
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
            <script>
            
            $(document).ready(function(){
                var urlImage = {!! json_encode(url('/')) !!}
                var token_user=getCookie("token_login_user_gsm")
                var linkfoto = localStorage.getItem("fotoUser")
                if(linkfoto !== null){
                $('#fotoUser').append(
                    '<img  src="'+urlImage+'/storage/images/'+linkfoto+'"  class="img-rounded"  width="200"/>'                )
                }else{
                $('#fotoUser').append(
                '<img  src="{{asset('assets/images/users/avatar.png')}}" class="img-rounded"  width="200"/>'
                )
                }
                var data_diri = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                document.getElementById('id').value= data_diri._id
                var id = data_diri._id
                        
            axios.get(appurl+'v1/users/'+id)
            .then(function (response) {
                localStorage.setItem('data_user_profile', JSON.stringify(response.data))
                    var data_user_profile = JSON.parse(localStorage.getItem("data_user_profile"))                    
                    document.getElementById('nama').value = data_user_profile.name
                    $('#workshop').val(data_user_profile.attendedWorkshop);
                    $('#workshop').change();
                    $('#workshop').selectpicker("refresh");
                    document.getElementById('tempat_lahir').value = data_user_profile.detail.birthplace
                    document.getElementById('datepicker-autoclose').value = data_user_profile.detail.birthdate
                    // document.getElementById('posisi').value = data_user_profile.detail.position
                    document.getElementById('no_wa').value = data_user_profile.detail.phone
                    
                    $('#posisi').val(data_user_profile.detail.position);
                    $('#posisi').change();
                    $('#posisi').selectpicker("refresh");

                    $('#pendidikan').val(data_user_profile.detail.lastEducation);
                    $('#pendidikan').change();
                    $('#pendidikan').selectpicker("refresh");

                    $('#gender').val(data_user_profile.detail.gender);
                    $('#gender').change();
                    $('#gender').selectpicker("refresh");
            })
            .catch(function (error) {
                // console.log(error)
                swal("Beberapa data belum diupdate", "Silhakan isi form di bawah ini dengan data yang sesuai")
            })     
            })

            </script>
                    <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>
                    <script src="{{asset('assets/plugins/timepicker/bootstrap-timepicker.js')}}"></script>
                    <script src="{{asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
                    <script src="{{asset('assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js')}}"></script>
                    <script src="{{asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>    
                    <script src="{{asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
                    <script src="{{asset('assets/pages/jquery.form-pickers.init.js')}}"></script>
                    <script src="{{asset('assets/plugins/bootstrap-sweetalert/sweet-alert.min.js')}}"></script>
                    <script src="{{asset('assets/pages/jquery.sweet-alert.init.js')}}"></script>
        @endsection