function likeKonten(id, no){
    var colorLikeIcon = document.getElementById("likeIcon-"+no).style.color
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user=getCookie("token_login_user_gsm")
    if(colorLikeIcon == "red"){
        document.getElementById("likeIcon-"+no).style.color="#98a6ad"
        var number1 = parseInt(document.getElementById("jumlahLike-"+no).innerHTML, 10)
        var number2 = number1 - 1
        document.getElementById("jumlahLike-"+no).innerHTML = number2
        $.ajax({
            url: appurl+'v1/users/article/unliked/'+id,
            type: 'POST',
            headers : {
                "Accept" : "application/json", 
                "Authorization" : "Bearer "+token_user
            }
        })
        .done(function(data, status){
            // swal("Berhasil", "Menyukai konten berbagi")
        })
        .fail(function(data, status){
            swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
        })
    }else{
        document.getElementById("likeIcon-"+no).style.color="red"
            var number1 = parseInt(document.getElementById("jumlahLike-"+no).innerHTML, 10)
            var number2 = number1 + 1
            document.getElementById("jumlahLike-"+no).innerHTML = number2
        $.ajax({
            url: appurl+'v1/users/article/liked/'+id,
            type: 'POST',
            headers : {
                "Accept" : "application/json", 
                "Authorization" : "Bearer "+token_user
            }
        })
        .done(function(data, status){
            // swal("Berhasil", "Menyukai konten berbagi")
        })
        .fail(function(data, status){
            // console.log(data)
            swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
        })
    }
}

function savepost(id, no){
    var number1 = parseInt(document.getElementById("jumlahSave-"+no).innerHTML, 10)
    var number2 = number1 + 1
    document.getElementById("jumlahSave-"+no).innerHTML = number2
    document.getElementById("saveIcon-"+no).style.color = "#66ccff"
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user=getCookie("token_login_user_gsm")
    $.ajax({
        url: appurl+'v1/users/article/favorite/'+id,
        type: 'POST',
        headers : {
            "Accept" : "application/json", 
            "Authorization" : "Bearer "+token_user
        }
    })
    .then(function(data, status){
        swal("Berhasil", "Menyimpan konten berbagi")
    })
    .fail(function(data, status){
        swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
    })
}

    function uploadBerbagi(){
        var appurl = localStorage.getItem("url_elearning_gsm")
        var token_user=getCookie("token_login_user_gsm")
        var formData = new FormData();
        formData.append('title', document.getElementById("title").value);
        formData.append('content', document.getElementById("content").value);
        formData.append('kupon', document.getElementById("selectedKupon").value);

        // formData.append('deskripsi', document.getElementById("deskripsi_tantangan").value);
        var jumlah_gambar = document.getElementById('fotoBerbagi').files.length;
        for (var x = 0; x < jumlah_gambar; x++) {
            formData.append("image[]", document.getElementById('fotoBerbagi').files[x]);
        }
        document.getElementById("uploadText").style.display="none"
        document.getElementById("uploadLoadingIcon").style.display="block"
        $.ajax({
            url: appurl+'v1/article/store',
            data: formData,
            type: 'POST',
            headers : {
                "Accept" : "application/x-www-form-urlencoded", 
                "Authorization" : "Bearer "+token_user
            }, 
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
        })
        .done(function(data, status){
            
            document.getElementById("uploadText").style.display="block"
            document.getElementById("uploadLoadingIcon").style.display="none"
            swal("Selamat", "Berhasil mengupload")
            window.location = "createkontenberbagi"
        })
        .fail(function(response){
            document.getElementById("uploadText").style.display="block"
            document.getElementById("uploadLoadingIcon").style.display="none"
            swal("Terjadi kesalahan", "Anda mengupload gambar dengan ukuran lebih dari 2MB")
        })
    }

    function comment(id, number){
        document.getElementById("uploadLoadingIconKonten").style.display="block"
        document.getElementById("kirimText").style.display="none"

        var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
        var usernameComment = dataUser.name
        var appurl = localStorage.getItem("url_elearning_gsm")
        var token_user=getCookie("token_login_user_gsm")
            var data = {
                "comment_body" : document.getElementById("inputKomentar-"+number).value,
                "article_id" : id
            }

            var number1 = parseInt(document.getElementById("jumlahKomentar-"+number).innerHTML, 10)
                var number2 = number1 + 1
                document.getElementById("jumlahKomentar-"+number).innerHTML = number2
                $('#listKomentar').append(
                    '<p><span><b>'+usernameComment+'</b></span> '+document.getElementById("inputKomentar-"+number).value+'</p>'
                )

            $.ajax({
                url: appurl+'v1/comment/store',
                data: data,
                type: 'POST',
                headers : {
                    "Accept" : "application/x-www-form-urlencoded", 
                    "Authorization" : "Bearer "+token_user
                }
            })
            .done(function(data, status){
                document.getElementById("uploadLoadingIconKonten").style.display="none"
                document.getElementById("kirimText").style.display="block"
        
            })
            .fail(function(data, status){
                document.getElementById("uploadLoadingIconKonten").style.display="none"
                document.getElementById("kirimText").style.display="block"
        
                swal("Maaf", "Terjadi kesalahan, komentar yang sudah Anda masukan tidak akan disimpan")
            })
            document.getElementById("inputKomentar-"+number).value=""
        }

        function seecomments(id){
            localStorage.setItem("idKonten", id)
            window.location = "detailkonten?id="+id
        }

        function listcomments(dataKomentar, jumlahKomentar){
            if(jumlahKomentar < 5){
                var y = 0
            }else{
                var y = jumlahKomentar-5
            }
            var komentar = ''
                for(y ; y < jumlahKomentar ; y++){
                    komentar += '<p><span><b>'+dataKomentar[y].name+'</b></span> '+dataKomentar[y].body+'</p>'
                }
                $('#listKomentar').append(
                    komentar
                )
        }

        function gotouserpage(id){
            window.location="pageuser?id="+id
        }

        function shareKonten(idKonten, idUser){
            var link = document.getElementById('sharedLink-'+idKonten)
            link.select();
            document.execCommand("copy");
            swal("Link Konten disalin", "Bagikan link tersebut ke teman-teman Anda")
        }

        function mountArtikel(numPage, id, urlImage, kategori){
            var appurl = localStorage.getItem("url_elearning_gsm")
            var token_user=getCookie("token_login_user_gsm")
            switch(kategori){
                case "filterKonten" :
                var provinsi = document.getElementById('provinsi').value
                var kabupaten = document.getElementById('kabupaten').value
                var sekolah = document.getElementById('sekolah').value
                var workshop = document.getElementById('workshop').value
                var page = document.getElementById('pagePagination').value
                
                var url = appurl+'v1/article/filter/by?propinsi='+provinsi+'&bentuk='+sekolah+'&kabupaten_kota='+kabupaten+'&kupon='+workshop+'&page='+page
                var headers = {
                    "Content-Type" : "application/json"
                }
                break; 

                case "allKonten" :
                var url = appurl+'v1/article?page='+numPage
                var headers = {
                    "Content-Type" : "application/json"
                }
                break;

                case "kontenByUser" :      
                var url = appurl+'v1/article/by-user/'+id+'?page='+numPage
                var headers = {
                    "Content-Type" : "application/json"
                }
                break;

                
                case "kontenByOtherUser" :      
                var url = appurl+'v1/article/by-user/'+id+'?page='+numPage
                var headers = {
                    "Content-Type" : "application/json"
                }
                break;

                case "kontenDisukai" :
                var url = appurl+'v1/users/article/liked?page='+numPage
                var headers = {
                    "Content-Type" : "application/json", 
                    "Authorization" : "Bearer "+token_user
                }
                break;

                case "kontenDisimpan" :
                var url = appurl+'v1/users/article/favorite?page='+numPage
                var headers = {
                    "Content-Type" : "application/json", 
                    "Authorization" : "Bearer "+token_user
                }
                break;

                case "kontenById" : 
                var url = appurl+'v1/article/'+id
                var headers = {
                    "Content-Type" : "application/json"
                }
                break;
            }
            $.ajax({
                url: url,
                type: 'GET',
                headers : headers
            })
            .done(function(data, status){
                console.log(data)

                document.getElementById("loadText").style.display="block"
                document.getElementById("uploadLoadingIconKonten").style.display="none"
                if(data.data.next_page_url == null){
                    document.getElementById("loadMore").style.display ="none"
                }else{
                    document.getElementById("nextPage").value = parseInt(document.getElementById("nextPage").value, 10) + 1
                }
                // console.log(data.data.next_page_url)
                var bulan_string = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]
                var kontenBerbagi = data.data.data
                var jumlahKonten = kontenBerbagi.length
                console.log(jumlahKonten)
                if(jumlahKonten == 0){
                    $('#dibagi').append(
                        '<div class="col-md-12" style="text-align:center" id="noPost">'+
                        '<p>'+
                        'Belum ada postingan apapun yang dapat ditampilkan'+
                        '</p>'+
                        '</div>'
                    )
                }
                var paginationStart= parseInt(document.getElementById("pagePagination").value, 10) 
                for( var i = 0 ; i < jumlahKonten ; i++){
                    console.log(kontenBerbagi[i].user)
                    var date = new Date(kontenBerbagi[i].created_at)
                    var getDate = date.getDate()
                    var getMonth = date.getMonth()
                    var getYear = date.getFullYear()
                    var dateKonten = getDate+' '+bulan_string[getMonth]+' '+getYear
                    var authorName = kontenBerbagi[i].author
                    var kupon = kontenBerbagi[i].kupon
                    var titleKonten = kontenBerbagi[i].title
                    var konten = kontenBerbagi[i].content
                    var authorId = kontenBerbagi[i].user_id
                    var idKonten = kontenBerbagi[i]._id
                    var image = kontenBerbagi[i].image
                    var imageLenght = image.length
                    var jumlahKomentar = kontenBerbagi[i].comments.length
                    var jumlahLike = kontenBerbagi[i].liked.length
                    var jumlahSave = kontenBerbagi[i].favorite.length
                    var lengthphoto = kontenBerbagi[i].user.photo_profile.length
                    // console.log(lengthphoto)
                    if(lengthphoto == 0){
                        var photo2 ='<img  src="'+urlImage+'/assets/images/users/avatar.png" class="img-circle authorImage"  />'
                     }else{
                        var photo2 =  '<img  src="'+urlImage+'/storage/images/500/'+kontenBerbagi[i].user.photo_profile[0].filename+'"   class="img-circle authorImage"  />'
                    }
                    $('#dibagi').append(
                        '<div class="blog-box-one">'+
                        '<div class="post-info">'+
                            '<div class="meta-container" style="margin-left:-55px;" >'+
                            '<i class="fa fa-trash-o" id="displayIconDelete-'+idKonten+'" style="float:right;cursor:pointer;color:red;display:none" onclick="modalDelete(\''+idKonten+'\')" data-toggle="modal" data-target=".bs-example-modal-sm"></i>'+
                            photo2+
                                '<span style="cursor:pointer" onclick="gotouserpage(\''+authorId+'\')">'+
                                    '<h4 class="text-overflow m-t-0">'+authorName+'</h4>'+
                                '</span>'+
                                
                                '<div class="font-13">'+
                                    '<span class="meta">'+dateKonten+'</span>'+
                                '</div>'+
                            '</div>'+
                            
                        '</div>'+
                            
                            '<div class="cover-wrapper">'+
                                '<div id="blog-slider-'+paginationStart+i+'" class="carousel slide">'+
                                    '<ol  class="carousel-indicators m-b-0" id="ol-'+paginationStart+i+'">'+
                                    '</ol>'+
                                    '<div class="carousel-inner" role="listbox" id="listSlide-'+paginationStart+i+'" >'+
                                    '</div>'+
                                    '<a href="#blog-slider-'+paginationStart+i+'" role="button" data-slide="prev" class="left carousel-control"> <span aria-hidden="true" class="fa fa-angle-left"></span> <span class="sr-only">Previous</span> </a>'+
                                    '<a href="#blog-slider-'+paginationStart+i+'" role="button" data-slide="next" class="right carousel-control"> <span aria-hidden="true" class="fa fa-angle-right"></span> <span class="sr-only">Next</span> </a>'+
                                '</div>'+
        
                            '</div>'+
                            '<div class="post-info">'+
                            '<div id="workshopStatus-'+i+'"></div>'+
                                '<p class="text-muted m-b-0">'+konten+'</p>'+
        
                                    '<div class="row">'+
                                            '<div class="col-md-6">'+
                                                '<div class="m-t-10 blog-widget-action">'+
                                                    '<a href="javascript:void(0)">'+
                                                        '<i class="mdi md-favorite" id="likeIcon-'+paginationStart+i+'" onclick="likeKonten(\''+idKonten+'\', \'' +paginationStart+i+ '\')"></i> <span id="jumlahLike-'+paginationStart+i+'">'+jumlahLike+'</span>'+
                                                    '</a>'+
                                                    '<a href="javascript:void(0)">'+
                                                        '<i class="mdi md-comment"  onclick="seecomments(\''+idKonten+'\')"></i> <span>'+jumlahKomentar+'</span>'+
                                                    '</a>'+
                                                    
                                                    '<a href="javascript:void(0)">'+
                                                    '<i class="md md-archive" id="saveIcon-'+paginationStart+i+'" onclick="savepost(\''+idKonten+'\',\''+paginationStart+i+'\')"></i><span id="jumlahSave-'+paginationStart+i+'">'+jumlahSave+'</span>'+
                                                    '</a>'+

                                                    '<a href="javascript:void(0)">'+
                                                        '<i class="mdi md-share" id="shareIcon-'+paginationStart+i+'" onclick="shareKonten(\''+idKonten+'\', \'' +authorId+ '\')"></i>'+
                                                        '<input type="text" style="position:absolute;z-index:-1000" value="'+urlImage+'/publickonten?id='+idKonten+'&idAuthor='+authorId+'" id="sharedLink-'+idKonten+'"></input>'+    
                                                    '</a>'+
                                                '</div>'+
                                            '</div>'+
                                            '<div class="col-xs-6 text-right">'+
                                            '</div>'+
                                        '</div>'+   
        
                            '</div>'+
                        '</div>'
                    )

                    if(kupon !=="elearning"){
                        $("#workshopStatus-"+i).append(
                            '<p style="color:rgb(162, 0, 255);margin-top:-10px" class="text-muted m-b-0">Workshop : '+kupon+' </p>'
                        )
                    }
        
                    // Untuk mendeteksi apakah sudah di like user itu sendiri   
                    var dataLike = kontenBerbagi[i].liked
                    var likedStatus1 = dataLike.find(function(element) {
                                        return element._id ==id ;
                                       });
                    if(likedStatus1 !==undefined){
                        document.getElementById("likeIcon-"+paginationStart+i).style.color = "red"
                    }
        
                    // Untuk mendeteksi apakah sudah di simpan user itu sendiri    
                    var dataSave = kontenBerbagi[i].favorite
                    var savedStatus1 = dataSave.find(function(element) {
                                        return element._id ==id ;
                                        });
                    if(savedStatus1 !==undefined){
                        document.getElementById("saveIcon-"+paginationStart+i).style.color = "#66ccff"
                    }
                    
                    var liblogslider = ''
                    var listSlide = ''
                    for(var x = 0 ; x < imageLenght ; x++){
                        if(x == 0){
                            liblogslider += '<li data-target="#blog-slider-'+paginationStart+i+'" data-slide-to="'+x+'" style="margin:5px" class="active"></li>'
                            listSlide += '<div class="item active">'
                            listSlide += '<img style="margin:auto" alt="Blog-img" src="'+urlImage+'/storage/images/'+image[x].filename+'" class="img-responsive"/>'
                            listSlide += '</div>'
                        }else{
                            liblogslider +='<li data-target="#blog-slider-'+paginationStart+i+'" data-slide-to="'+x+'" style="margin:5px"></li>'
                            listSlide += '<div class="item">'
                            listSlide += '<img style="margin:auto" alt="Blog-img" src="'+urlImage+'/storage/images/'+image[x].filename+'" class="img-responsive"/>'
                            listSlide += '</div>'
                        }
                    }
                    $('#ol-'+paginationStart+i).append(
                        liblogslider
                    )
                    $('#listSlide-'+paginationStart+i).append(
                        listSlide
                    )
                    if(kategori == 'kontenByUser'){
                        document.getElementById('displayIconDelete-'+idKonten).style.display="block"
                    }
                }
                document.getElementById("pagePagination").value = i -1 
            })
            .fail(function(data, status){
                // console.log(data)
                document.getElementById("loadText").style.display="block"
                document.getElementById("uploadLoadingIconKonten").style.display="none"
                swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
            })
        }

        function modalDelete(idKonten){
            $('#buttonDelete')
            .find('button')
            .remove()
            $('#buttonDelete').append(
                '<button type="button" class="btn btn-danger waves-effect waves-light" onclick="deleteKonten(\''+idKonten+'\')">Ya, Hapus</button>'
            )
        }

        function deleteKonten(idKonten){
            var appurl = localStorage.getItem("url_elearning_gsm")
            var token_user=getCookie("token_login_user_gsm")        
            var data = {
                "article_id" : idKonten
            }
            $.ajax({
                url: appurl+'v1/article/delete',
                type: 'DELETE',
                data : data,
                headers : {
                    "Content-Type" : "application/x-www-form-urlencoded", 
                    "Authorization" : "Bearer "+token_user
                }
            })
            .done(function(data, status){
                swal("Berhasil", "Menghapus konten berbagi Anda")
                location.reload(); 
            })
            .fail(function(data, status){
                console.log(data)
                swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
            })
        }

