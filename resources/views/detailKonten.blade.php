@extends('layout.form')
@section('content')
<div class="content-page">
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
    <footer class="footer text-right">
        © 2019. All rights reserved.
    </footer>
</div>
<script>
$(document).ready(function(){
    var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
    var idUser = dataUser._id
    var url_string = window.location.href
    var idKonten = getId(url_string)
    var appurl = localStorage.getItem("url_elearning_gsm")
    $.ajax({
        url: appurl+'v1/article/'+idKonten,
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
                                            '<i class="mdi md-favorite" id="likeIcon-1" onclick="likeKonten(\''+idKonten+'\',\''+1+'\')"></i> <span id="jumlahLike-1">'+jumlahLike+'</span>'+
                                        '</a>'+
                                        '<a href="javascript:void(0)">'+
                                            '<i class="mdi md-comment" onclick="seecomments(\''+idKonten+'\')"></i> <span id="jumlahKomentar-1">'+jumlahKomentar+'</span>'+
                                        '</a>'+
                                        '<a href="javascript:void(0)">'+
                                        '<i class="md md-archive" id="saveIcon-1" onclick="savepost(\''+idKonten+'\',\''+1+'\')"></i><span id="jumlahSave-1">'+jumlahSave+'</span>'+
                                        '</a>'+
                                        '<a href="javascript:void(0)">'+
                                            '<i class="mdi md-share" id="shareIcon-1" onclick="shareKonten(\''+idKonten+'\', \'' +authorId+ '\')"></i>'+
                                            '<input type="text" style="z-index:-100;position:relative" value="'+urlImage+'/publickonten?id='+idKonten+'&idAuthor='+authorId+'" id="sharedLink"></input>'+    
                                        '</a>'+
                                    '</div>'+
                                '</div>'+
                                '<div class="col-xs-6 text-right">'+
                                    // '<a href="" class="btn btn-sm waves-effect btn-white" style="margin-right:10px">Share</a>'+
                                    // '<a href="" class="btn btn-sm waves-effect btn-white">Add people to edit</a>'+
                                '</div>'+
                                '<div style="margin-top:10px" class="col-md-11 text-right komentar">'+
                                    '<input class="form-control" placeholder="Input Komentar" type="text" id="inputKomentar-'+1+'">'+
                                '</div>'+
                                '<div class="col-md-1 text-right buttonKirim komentar">'+
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
        // Untuk mendeteksi apakah sudah di like user itu sendiri    
        var dataLike = kontenBerbagi.liked
        var likedStatus1 = dataLike.find(function(element) {
                            return element._id ==idUser ;
                            });
        if(likedStatus1 !==undefined){
            document.getElementById("likeIcon-1").style.color = "red"
        }

        // Untuk mendeteksi apakah sudah di simpan user itu sendiri    
        var dataSave = kontenBerbagi.favorite
        var savedStatus1 = dataSave.find(function(element) {
                            return element._id ==idUser ;
                            });
        if(savedStatus1 !==undefined){
            document.getElementById("saveIcon-1").style.color = "#66ccff"
        }

        var liblogslider = ''
        var listSlide = ''
        for(var x = 0 ; x < imageLenght ; x++){
            if(x == 0){
                liblogslider += '<li data-target="#blog-slider" data-slide-to="'+x+'" style="margin:5px" class="active"></li>'
                listSlide += '<div class="item active">'
                listSlide +=  '<img style="margin:auto" src="'+urlImage+'/storage/images/'+image[x].filename+'" class="img-responsive"   />'
                listSlide += '</div>'
            }else{
                liblogslider +='<li data-target="#blog-slider" data-slide-to="'+x+'" style="margin:5px"></li>'
                listSlide += '<div class="item">'
                listSlide += '<img style="margin:auto"  src="'+urlImage+'/storage/images/'+image[x].filename+'" class="img-responsive"    />'
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

    function shareKonten(idKonten, idUser){
    console.log(idKonten)
    var link = document.getElementById('sharedLink')
    console.log(link)
    link.select()
    document.execCommand("copy");
    swal("Link Konten disalin", "Bagikan link tersebut ke teman-teman Anda")
    }

function muatkomentar(){
    $('#listKomentar')
    .find('p')
    .remove()

    var comments = JSON.parse(localStorage.getItem("comments"))
    var jumlahKomentar = comments.length
    if(document.getElementById("komentarLimit").value ==""){
        
        var value =  jumlahKomentar - 5
        if(value > 0){
            document.getElementById("komentarLimit").value = jumlahKomentar - 5
        }else{
            document.getElementById("komentarLimit").value = jumlahKomentar
        }
    }
    var valueY = parseInt(document.getElementById("komentarLimit").value, 10) - 5
    console.log("Ini Value Y")
    console.log(valueY)
    console.log("------------------------------------------------")
    if(valueY > 0){
        var y = valueY
        var val = y
    }else{
        var y = parseInt(document.getElementById("komentarLimit").value, 10) - parseInt(document.getElementById("komentarLimit").value, 10)
        var val = y
    }
    
    var komentar = ''
        for(y ; y < comments.length ; y++){
            // console.log(y)
            komentar += '<p><span><b>'+comments[y].name+'</b></span> '+comments[y].body+'</p>'
        }
        
        $('#listKomentar').append(
            komentar
        )
        console.log("Ini jumlah val")
        console.log(val)
        console.log("------------------------------------------------")

        console.log("Ini Komentar List Awal")
        document.getElementById("komentarLimit").value = val
        if(val == 0){
            document.getElementById("muatKomentar").style.display = "none"
        }
        console.log("------------------------------------------------")
        console.log("")
        console.log("")
}
</script>
<style>
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
    .headerText{
        font-size:12px
    }
    .komentar{
        margin-top:40px
    }
    .dateKonten{
        margin-top:-10px
    }
    }

    </style>
@endsection