@extends('layout.form')
@section('content')

<style>
.title{
    text-align:center;
    font-size:50px;
    font-family: 'Passion One', cursive;
    letter-spacing: 3px;
}
.date{
    float: left;
    border-bottom: 3px solid #71b6f9;
}
.day {
    font-size: 22px;
    color: #333;
    font-weight: 600;
    line-height: 22px;
}

.month {
    text-transform: uppercase;
    text-align: center;
    width: 100%;
    display: inline-block;
}
.tes{
    margin-left:-20px
}
@media only screen and (max-width: 600px) {
.title{
    font-size:30px;
}
.tes{
    margin-left:50px
}
}

@media only screen and (max-width: 400px) {
h5{
    font-size: 12px!important
}

.col-xs-6 > p {
    font-size:12px!important
}
}


</style>
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
                                                <h3 class="panel-title">Detail User</h3>
                                            </div>
                                            <div class="panel-body">
                                            <div class="col-sm-4" style="text-align:center" id="fotoUser">
                                             </div>
                                             <div class="col-md-4 col-xs-6">
                                                <h5><b>Nama :</b></h5>
                                                <p class="text-muted m-b-15 font-13" id="name">
                                                    Loading
                                                </p>

                                                <h5><b>Tempat Lahir :</b></h5>
                                                <p class="text-muted m-b-15 font-13" id="birthplace">
                                                    Loading
                                                </p>
                                                <h5><b>Tanggal Lahir :</b></h5>
                                                <p class="text-muted m-b-15 font-13" id="birthdate">
                                                    Loading
                                                </p>
                                                <h5><b>Nomor WA :</b></h5>
                                                <p class="text-muted m-b-15 font-13" id="phone">
                                                    Loading
                                                </p>
                                             </div>
                                             <div class="col-md-4 col-xs-6">
                                                <h5><b>Sudah Ikut Workshop :</b></h5>
                                                <p class="text-muted m-b-15 font-13" id="attendedWorkshop">
                                                    Loading
                                                </p>
                                                <h5><b>Gender :</b></h5>
                                                <p class="text-muted m-b-15 font-13" id="gender">
                                                    Loading
                                                </p>
                                                <h5><b>Posisi di Sekolah :</b></h5>
                                                <p class="text-muted m-b-15 font-13" id="position">
                                                    Loading
                                                </p>
                                                <h5><b>Pendidikan Terakhir :</b></h5>
                                                <p class="text-muted m-b-15 font-13" id="lastEducation">
                                                    Loading
                                                </p>
                                                <input type="text" id="id" style="display:none">
                                           </div>
                                        <a href="{{ url('/editprofile') }}">
                                            <button style="float:right" type="button" class="btn btn-default waves-effect waves-light">Edit</button>
                                           </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row" >
                                    <div class="col-md-4">
                                    <div class="panel panel-color panel-custom">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Modul Sedang Dipelajari</h3>
                                            </div>
                                            <div class="panel-body" style="height: 300px;overflow: auto;" id="list_modul_enrolled">
                                                {{-- Block Code --}}
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="panel panel-color panel-custom">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Tantangan Modul Dijawab</h3>
                                                </div>
                                                <div class="panel-body" style="height: 300px;overflow: auto;" id="list_modul_answered">
                                                   {{-- Block Code --}}
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="col-md-4">
                                            <div class="panel panel-color panel-custom">
                                                    <div class="panel-heading">
                                                        <h3 class="panel-title">Tantangan Modul Dinilai</h3>
                                                    </div>
                                                    <div class="panel-body" style="height: 300px;overflow: auto;" id="list_modul_scored">
                                                        {{-- Block Code --}}
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
             $(document).ready(function(){
            var urlImage = {!! json_encode(url('/')) !!}
            var linkfoto = localStorage.getItem("fotoUser")
            if(linkfoto !== null){
            $('#fotoUser').append(
            '<img  src="'+urlImage+'/storage/images/'+linkfoto+'"  class="img-rounded"  width="200"/>'
            )
            }else{
            $('#fotoUser').append(
            '<img  src="{{asset('assets/images/users/avatar.png')}}" class="img-rounded"  width="200"/>'
            )
            }
            var data_diri = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
            document.getElementById('id').value= data_diri._id
            var id = data_diri._id
            
            var token_user=getCookie("token_login_user_gsm")
            var appurl = localStorage.getItem("url_elearning_gsm")
            getUserActivity(appurl,token_user)
             axios.get(appurl+'v1/users/'+id)
            .then(function (response) {
                localStorage.setItem('data_user_profile', JSON.stringify(response.data))
                    var data_user_profile = JSON.parse(localStorage.getItem("data_user_profile"))
                    document.getElementById('name').innerHTML = data_user_profile.name
                    document.getElementById('birthplace').innerHTML = data_user_profile.detail.birthplace
                    document.getElementById('birthdate').innerHTML = data_user_profile.detail.birthdate
                    document.getElementById('position').innerHTML = data_user_profile.detail.position
                    document.getElementById('phone').innerHTML = data_user_profile.detail.phone
                    if(data_user_profile.attendedWorkshop){
                        var attendedWorkshop = "Sudah Pernah"
                    }else{
                        var attendedWorkshop = "Belum Pernah"
                    }
                    document.getElementById('attendedWorkshop').innerHTML = attendedWorkshop
                    document.getElementById('lastEducation').innerHTML = data_user_profile.detail.lastEducation
                    document.getElementById('gender').innerHTML = data_user_profile.detail.gender
            })
            .catch(function (error) {
                swal("Beberapa data belum diupdate", "Silhakan update profil Anda di halaman edit profil")
            })
            .finally(function () {
                // always executed
            });
        })
            </script>
        @endsection