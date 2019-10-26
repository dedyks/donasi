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
    .buttonKirim{
        margin-left:-10px;margin-top:12px;text-align:left
    }

    .authorImage{
        float:left;margin-right:15px;width:50px;height: 50px;
    }

    @media only screen and (max-width: 400px) {
    .buttonKirim{
        margin-left:0px;text-align:left
    }

    .authorImage{
        float:left;margin-right:15px;width:40px;height:40px
    }

    }
    </style>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <div class="content-page">
        <div class="content">
            <div class="container">
                    <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-color panel-custom">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Profile</h3>
                                    </div>
                                    <div class="panel-body">
                                    <div class="col-sm-4" id="fotoUser">
                                     </div>
                                     <div class="col-md-4">
                                        <h5><b>Nama :</b></h5>
                                        <p class="text-muted m-b-15 font-13" id="name">
                                            Belum Diisi
                                        </p>

                                        <h5><b>Tempat Lahir :</b></h5>
                                        <p class="text-muted m-b-15 font-13" id="birthplace">
                                            Belum Diisi
                                        </p>
                                        <h5><b>Tanggal Lahir :</b></h5>
                                        <p class="text-muted m-b-15 font-13" id="birthdate">
                                            Belum Diisi
                                        </p>
                                        <h5><b>Nomor WA :</b></h5>
                                        <p class="text-muted m-b-15 font-13" id="phone">
                                            Belum Diisi
                                        </p>
                                     </div>
                                     <div class="col-md-4">
                                        <h5><b>Sudah Ikut Workshop :</b></h5>
                                        <p class="text-muted m-b-15 font-13" id="attendedWorkshop">
                                            Belum Diisi
                                        </p>
                                        <h5><b>Gender :</b></h5>
                                        <p class="text-muted m-b-15 font-13" id="gender">
                                            Belum Diisi
                                        </p>
                                        <h5><b>Posisi di Sekolah :</b></h5>
                                        <p class="text-muted m-b-15 font-13" id="position">
                                            Belum Diisi
                                        </p>
                                        <h5><b>Pendidikan Terakhir :</b></h5>
                                        <p class="text-muted m-b-15 font-13" id="lastEducation">
                                            Belum Diisi
                                        </p>
                                        <input type="text" id="id" style="display:none">
                                   </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                    <div class="panel panel-color panel-custom">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Timeline Berbagi User</h3>
                                        </div>
                                        <div class="panel-body">
                                            <input type="number" value="1" id="pagePagination" autocomplete="off" style="display:none" />
                                            <input type="number" value="1" id="nextPage" autocomplete="off" style="display:none" />

                                            <!-- blog content -->
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
            </div>
        </div>
        <footer class="footer text-right">
                © 2019. All rights reserved.
            </footer>
    </div>
    <script>
    $(document).ready(function(){
        var url_string = window.location.href
        var id = getId(url_string)
        var appurl = localStorage.getItem("url_elearning_gsm")
        axios.get(appurl+"v1/users/"+id, {headers : {
            "Content-Type" : "application/json"
        }})
        .then(res=>{
            var urlImage = {!! json_encode(url('/')) !!}
            if(res.data.photo_profile.length !== 0){
            $('#fotoUser').append(
            '<img  src="'+urlImage+'/storage/images/'+res.data.photo_profile[0].filename+'"  class="img-rounded"  width="200"/>'
            )
            }else{
            $('#fotoUser').append(
            '<img  src="{{asset('assets/images/users/avatar.png')}}" class="img-rounded"  width="200"/>'
            )
            }

            document.getElementById('name').innerHTML = res.data.name
            document.getElementById('birthplace').innerHTML = res.data.detail.birthplace
            document.getElementById('birthdate').innerHTML = res.data.detail.birthdate
            document.getElementById('position').innerHTML = res.data.detail.position
            document.getElementById('phone').innerHTML = res.data.detail.phone
            if(res.data.attendedWorkshop){
                var attendedWorkshop = "Sudah Pernah"
            }else{
                var attendedWorkshop = "Belum Pernah"
            }
            document.getElementById('attendedWorkshop').innerHTML = attendedWorkshop
            document.getElementById('lastEducation').innerHTML = res.data.detail.lastEducation
            document.getElementById('gender').innerHTML = res.data.detail.gender
        })
        .catch(err=>{
        })

        var page = parseInt(document.getElementById("nextPage").value, 10)
        var urlImage =  {!! json_encode(url('/')) !!}
        mountArtikel(page, id, urlImage, "kontenByOtherUser" )
    })

    function loadMore(){
        document.getElementById("loadText").style.display="none"
        document.getElementById("uploadBelum DiisiIconKonten").style.display="block"
        var page = parseInt(document.getElementById("nextPage").value, 10)
        var url_string = window.location.href
        var id = getId(url_string)
        var urlImage =  {!! json_encode(url('/')) !!}
        mountArtikel(page, id, urlImage, "kontenByOtherUser" )
    }
    </script>
@endsection