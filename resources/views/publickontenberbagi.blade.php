@extends('layout.publickonten')
@section('content')
<div id="wrapper">
    <!-- Top Bar Start -->
    <div class="topbar">

        <!-- LOGO -->
        <div class="topbar-left">
            <div class="text-center">
                <a href="/" class="logo"><span>E-Learning GSM</span></a>
                <!-- Image Logo here -->
                <!--<a href="index.html" class="logo">-->
                    <!--<i class="icon-c-logo"> <img src="assets/images/logo_sm.png" height="42"/> </i>-->
                    <!--<span><img src="assets/images/logo_light.png" height="20"/></span>-->
                <!--</a>-->
            </div>
        </div>

        <!-- Button mobile view to collapse sidebar menu -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="">


                    <ul class="nav navbar-nav navbar-right pull-right" style="margin:20px;">
                        <li style="color:white;letter-spacing: 1px" class="dropdown top-menu-item-xs"> <b> <a  href="{{ url('/login') }}" style="color:white"> LOGIN</a></b></li>
                        <li style="color:white;letter-spacing: 1px" class="dropdown top-menu-item-xs"> <b> <span style="color:white"> &nbsp;&nbsp; | &nbsp;&nbsp; </span></b></li>
                        <li style="color:white;letter-spacing: 1px" class="dropdown top-menu-item-xs"> <b> <span  style="color:white;cursor:pointer" onclick="daftar()"> DAFTAR</span></b></li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
    </div>
    <!-- Top Bar End -->
    <div class="content-page" style="margin-left:0px">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-color panel-custom">
                            <div class="panel-heading">
                                <h3 class="panel-title">Detail Konten Berbagi</h3>
                            </div>
                            <div class="panel-body" id="konten">
    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer text-right"  style="left:0px">
            © 2019. All rights reserved.
        </footer>
    </div>
</div>

<script>
$(document).ready(function(){
    // var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
    // var idUser = dataUser._id
    var url_string = window.location.href
    var idKonten = getId(url_string)
    var appurl ={!! json_encode(url('/')) !!}
    $.ajax({
        url: appurl+'/api/v1/article/'+idKonten,
        type: 'GET',
        headers : {
            "Accept" : "application/x-www-form-urlencoded"
        }
    })
    .done(function(data, status){
        console.log(data)
        var bulan_string = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]
        var kontenBerbagi = data.data
        var date = new Date(kontenBerbagi.created_at)
        var getDate = date.getDate()
        var getMonth = date.getMonth()
        var getYear = date.getFullYear()
        var dateKonten = getDate+' '+bulan_string[getMonth]+' '+getYear
        var authorName = kontenBerbagi.author
        var kupon =  kontenBerbagi.kupon
        var titleKonten = kontenBerbagi.title
        var konten = kontenBerbagi.content
        var authorId = kontenBerbagi.user_id
        var idKonten = kontenBerbagi._id
        var image = kontenBerbagi.image
        var imageLenght = image.length
        var jumlahKomentar = kontenBerbagi.comments.length
        var jumlahLike = kontenBerbagi.liked.length
        var jumlahSave = kontenBerbagi.favorite.length
        var lengthphoto = kontenBerbagi.user.photo_profile.length
        var urlImage = {!! json_encode(url('/')) !!}
        if(lengthphoto == 0){
           var photo2 ='<img  src="{{asset('assets/images/users/avatar.png')}}"   class="img-circle authorImage"  />'
        }else{
           var photo2 =  '<img  src="'+urlImage+'/storage/images/500/'+ kontenBerbagi.user.photo_profile[0].filename+'"   class="img-circle authorImage"  />'
        }
        localStorage.setItem("comments",JSON.stringify( kontenBerbagi.comments))
        $('#konten').append(
            '<div class="blog-box-one">'+
            '<div class="post-info">'+
                '<div class="meta-container" style="margin-left:-55px;" >'+
                    photo2+
                    '<span  style="cursor:pointer" onclick="gotouserpage(\''+authorId+'\')">'+
                        '<h4 class="text-overflow m-t-0 headerText">'+authorName+'</h4>'+
                    '</span>'+
                    '<div class="font-13 dateKonten">'+
                        '<span class="meta headerText ">'+dateKonten+'</span>'+
                    '</div>'+
                '</div>'+
            '</div>'+
                
                '<div class="cover-wrapper">'+
                    '<div id="blog-slider" class="carousel slide">'+
                        '<ol class="carousel-indicators m-b-0" id="ol">'+
                        '</ol>'+
                        '<div class="carousel-inner" role="listbox" id="listSlide" >'+
                        '</div>'+
                        '<a href="#blog-slider" role="button" data-slide="prev" class="left carousel-control"> <span aria-hidden="true" class="fa fa-angle-left"></span> <span class="sr-only">Previous</span> </a>'+
                         '<a href="#blog-slider" role="button" data-slide="next" class="right carousel-control"> <span aria-hidden="true" class="fa fa-angle-right"></span> <span class="sr-only">Next</span> </a>'+

                    '</div>'+

                '</div>'+
                '<div class="post-info">'+
                    '<div id="workshopStatus"></div>'+
                    '<p  class="text-muted m-b-0">'+konten+'</p>'+

                        '<div class="row">'+
                                '<div class="col-xs-6">'+
                                    '<div class="m-t-10 blog-widget-action">'+
                                        '<a href="javascript:void(0)">'+
                                            '<i class="mdi md-favorite" id="likeIcon-1" onclick="actionPublic()"></i> <span id="jumlahLike-1">'+jumlahLike+'</span>'+
                                        '</a>'+
                                        '<a href="javascript:void(0)">'+
                                            '<i class="mdi md-comment" onclick="actionPublic()"></i> <span id="jumlahKomentar-1">'+jumlahKomentar+'</span>'+
                                        '</a>'+
                                        '<a href="javascript:void(0)">'+
                                        '<i class="md md-archive" id="saveIcon-1" onclick="actionPublic()"></i><span id="jumlahSave-1">'+jumlahSave+'</span>'+
                                        '</a>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xs-6 text-right">'+
                                    // '<a href="" class="btn btn-sm waves-effect btn-white" style="margin-right:10px">Share</a>'+
                                    // '<a href="" class="btn btn-sm waves-effect btn-white">Add people to edit</a>'+
                                '</div>'+
                                '<div style="margin-top:10px;display:none" class="col-md-11 text-right komentar">'+
                                    '<input class="form-control" placeholder="Input Komentar" type="text" id="inputKomentar-'+1+'">'+
                                '</div>'+
                                '<div style="display:none" class="col-md-1 text-right buttonKirim komentar">'+
                                    '<button class="btn btn-default" onclick="comment(\'' +idKonten+ '\',\''+1+'\')"><span id="kirimText">Kirim</span>'+
                                    '<i id="uploadLoadingIconKonten" style="display:none" class="fas fa-spinner fa-spin"></i></button>'+
                                '</div>'+
                                '<div class="col-md-12"><p style="color:#d0d0d0;cursor:pointer;display:none" id="muatKomentar" onclick="muatkomentar()">Muat komentar sebelumnya</p></div>'+
                                '<div class="col-md-12" id="listKomentar">'+
                                    
                                '</div>'+
                                '<input type="text" style="display:none" value="" id="komentarLimit" />'+
                            '</div>'+  
                            
                            
                '</div>'+
            '</div>'
        )
        if(kupon !=="elearning"){
            $("#workshopStatus").append(
                '<p style="color:rgb(162, 0, 255);margin-top:-10px" class="text-muted m-b-0">Workshop : '+kupon+' </p>'
            )
        }

        var liblogslider = ''
        var listSlide = ''
        for(var x = 0 ; x < imageLenght ; x++){
            if(x == 0){
                liblogslider += '<li data-target="#blog-slider" data-slide-to="'+x+'" style="margin:5px" class="active"></li>'
                listSlide += '<div class="item active">'
                listSlide +=  '<img style="margin:auto"  src="'+urlImage+'/storage/images/'+image[x].filename+'" class="img-responsive"   />'
                listSlide += '</div>'
            }else{
                liblogslider +='<li data-target="#blog-slider" data-slide-to="'+x+'" style="margin:5px"></li>'
                listSlide += '<div class="item">'
                listSlide += '<img style="margin:auto" src="'+urlImage+'/storage/images/'+image[x].filename+'" class="img-responsive"    />'
                listSlide += '</div>'
            }
        }
        var dataKomentar = kontenBerbagi.comments
        listcomments(dataKomentar, jumlahKomentar)
        if(jumlahKomentar >5){
            document.getElementById("muatKomentar").style.display = "block"
        }
        $('#ol').append(
            liblogslider
        )
        $('#listSlide').append(
            listSlide
        )
        // console.log(status)
    })
    .fail(function(data, status){
    })
})

function daftar(){
    var url_string = window.location.href
    var url = new URL(url_string);
    var idAuthor = url.searchParams.get("idAuthor");
    window.location= 'daftar?invitedBy='+idAuthor
}
function actionPublic(){
    swal("Maaf", "Anda harus terdaftar terlebih dahulu. Login atau register sekarang")
}


</script>

<style>
@media only screen and (max-width: 400px) {
.authorImage{
    float:left;margin-right:15px;width:40px;height:40px
}

}

.authorImage{
    float:left;margin-right:15px;width:50px;height: 50px;
}
</style>
@endsection