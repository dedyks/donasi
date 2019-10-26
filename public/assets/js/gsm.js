
var token_user = getCookie("token_login_user_gsm")
var appurl = localStorage.getItem("url_elearning_gsm")


// Fungsi ambil id di url parameter 

function getId(url_string){
    var url = new URL(url_string);
    var id = url.searchParams.get("id");
    return id
}

// Fungsi ambil cookie 
function getCookie(cname) {
   
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return "";
}

function setCookie(cname,cvalue,exdays) {
    console.log("Hello")
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

// Fungsi Enroll Modul 
function enroll(id_modul){
    // console.log(id_modul)
    var data_diri = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
    var id_user = data_diri._id
    var data = {
        "user_id" : id_user, 
        "modul_id" : id_modul
    }
    $.ajax({
            type: 'POST',
            url :appurl+"v1/users/modul/enroll", 
            headers: {
                        "Authorization" : "Bearer "+token_user,
                        "Content-Type": "application/json",
                        "Accept"      : "application/json"
                    },
            data : JSON.stringify(data)
            }).done(function(data, status){
                // console.log(data)
                swal("Membuka Materi");
                localStorage.setItem('id_materi', id_modul)
                window.location="detailmateri"
    })
}

// Ambil modul & quiz si user
function getAllQuizUser(){

$(document).ajaxStart(function() { Pace.restart(); });
$.ajax({
    type: 'GET',
    headers :{
        "Content-Type" : "application/json", 
        "Accept" : "application/json", 
        "Authorization" : "Bearer "+token_user
    }, 
    url : appurl+"v1/users/quiz"
    })
    .done(function(data, status){
        // console.log(data)
        localStorage.setItem('data_user_elearning_gsm', JSON.stringify(data.data))
        var data_user = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
        var banyak_quiz = data_user.quiz.length
        
        var enrolled = ''
        var answered = ''
        var scored = ''
        for(var i = 0; i<banyak_quiz ; i++){
            if(data_user.quiz[i].flag == "enrolled"){
                enrolled += '"'
                enrolled += data_user.quiz[i].modul_id
                enrolled += '"'
            if(i==banyak_quiz-1){
                enrolled += ''
            }else{
                enrolled += ','
            }
            }

            if(data_user.quiz[i].flag == "answered"){
                answered += '"'
                answered += data_user.quiz[i].modul_id
                answered += '"'
            if(i==banyak_quiz-1){
                answered += ''
            }else{
                answered += ','
            }
            }

            if(data_user.quiz[i].flag == "scored"){
                scored += '"'
                scored += data_user.quiz[i].modul_id
                scored += '"'
            if(i==banyak_quiz-1){
                scored += ''
            }else{
                scored += ','
            }
            }
        }
        // Modul Enrolled
        var enrolled2 = enrolled.replace(/^[,\s]+|[,\s]+$/g, '').replace(/,[,\s]*,/g, ',');
        var enrolled3 = '['+enrolled2+']'
        var enrolled4 = JSON.parse(enrolled3)

        // Modul Answered
        var answered2 = answered.replace(/^[,\s]+|[,\s]+$/g, '').replace(/,[,\s]*,/g, ',');
        var answered3 = '['+answered2+']'
        var answered4 = JSON.parse(answered3)

        // Modul Scored
        var scored2 = scored.replace(/^[,\s]+|[,\s]+$/g, '').replace(/,[,\s]*,/g, ',');
        var scored3 = '['+scored2+']'
        var scored4 = JSON.parse(scored3)
        var modul_status = {
            enrolled : enrolled4, 
            answered : answered4, 
            scored : scored4
        }
        // console.log(modul_status)
        localStorage.setItem("modul_status", JSON.stringify(modul_status))

    })
    .fail(function(error){
        swal("Terjadi Kesalahan", "Cek koneksi internet Anda dan ulangi");
    })
}


// Fungsi untuk memilih kategori pada materi 
function pilih_kategori(level, kategori){
    console.log(kategori)
    $('#pilih_kategori_materi').val(kategori);
    $('#pilih_kategori_materi').change();
    $('#pilih_kategori_materi').selectpicker("refresh");
    
    $('#list_materi')
    .find('div')
    .remove()
    // alert(document.getElementById('pilih_kategori_materi').value)
    $(document).ajaxStart(function() { Pace.restart(); });
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user = getCookie("token_login_user_gsm")
    $.ajax({
            type: 'GET',
            url : appurl+"v1/modul/aspect-grade/"+document.getElementById('pilih_kategori_materi').value+"/"+level,
            headers: {"Authorization": "Bearer " + token_user}
            }).done(function(data, status){
                var jumlah_materi = data.length
                if(jumlah_materi == 0){
                    $('#list_materi').append(
                        // '<div class="col-md-12" style="text-align:center">'+
                        '<div class="card-box" style="text-align:center">'+
                            '<p>'+
                                'Belum ada materi yang dapat ditampilkan'+
                            '</p>'+
                        '</div>'
                        // '</div>'
                    )
                }
                for(var i = 0; i<jumlah_materi;i++){
                    var judul = data[i].title  
                var title = judul.replace(/\b\w/g, l => l.toUpperCase())
                var category = document.getElementById('pilih_kategori_materi').value
                switch(category) {
                    case "ekosistem-positif":
                        // code block
                        var category_materi = "Penciptaan Ekosistem Positif di Sekolah"
                        break;
                    case "trisentra-pendidikan":
                        // code block
                        var category_materi = "Tri Sentra Pendidikan"
                        break;
                    case "pengembangan-karakter":
                        // code block
                        var category_materi = "Pengembangan Karakter"
                        break;
                    case "pembelajaran-riset":
                        // code block
                        var category_materi = "Pembelajaran Berbasis Riset"
                        break;
                    default:
                        // code block
                    } 
                $('#list_materi').append(
                        '<div class="card-box">'+
                        '<div class="bar-widget">'+
                            '<div class="table-box">'+
                                '<div class="table-detail">'+
                                    '<div class="col-md-12">'+
                                        '<div class="row">'+
                                        '<div class="col-md-12">'+
                                            '<p style="font-size:20px;float:left"> <b>'+title+'</b> </p>'+
                                            '<span class="statusMateri" id="'+data[i]._id+'">Anda belum mempelajari materi ini</span>'+
                                        '</div>'+
                                    '</div>'+
                                        '<p style="color:#5d9cec" class="categoryText">Category : '+category_materi+'</p>'+
                                        '<p>'+data[i].description.substr(0, 200)+'...</p>'+
                                    '</div>'+
                                    '<div class="col-md-12">'+
                                            '<button style="float:right" type="button" class="btn btn-default waves-effect waves-light" onclick=enroll("'+data[i]._id+'")>Pelajari</button>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>'
                    )
                }

                modulStatus(data, jumlah_materi)
            }).fail(function(data,status){
                swal("Terjadi Kesalahan", "Cek koneksi internet Anda dan ulangi");
            })
}

// Get Status modul 
function modulStatus(data, jumlah_materi){
    var modul_status = JSON.parse(localStorage.getItem("modul_status"))
    var data_id_enrolled = modul_status.enrolled
    var data_id_answered = modul_status.answered
    var data_id_scored = modul_status.scored
   
    for(var i = 0; i<jumlah_materi;i++){
        var enrolled = (data_id_enrolled.indexOf(data[i]._id) > -1);
        var answered = (data_id_answered.indexOf(data[i]._id) > -1);
        var scored = (data_id_scored.indexOf(data[i]._id) > -1);

        if(enrolled){
            document.getElementById(data[i]._id).innerHTML = "Anda sudah mempelajari materi ini"
        }else if(answered){
            document.getElementById(data[i]._id).innerHTML = "Anda sudah menjawab tantangan di materi ini"
        }else if(scored){
            document.getElementById(data[i]._id).innerHTML = "Tantangan yang Anda jawab sudah dinilai"
        }
    }
}

// upload modul 
function upload_tantangan(){
    showLoading()
    var appurl = localStorage.getItem("url_elearning_gsm")
    var formData = new FormData();
    formData.append('user_id', document.getElementById("id_user").value);
    formData.append('modul_id', document.getElementById("id_modul").value);
    formData.append('deskripsi', document.getElementById("deskripsi_tantangan").value);
    var jumlah_gambar = document.getElementById('foto_tantangan').files.length;
    for (var x = 0; x < jumlah_gambar; x++) {
        formData.append("image[]", document.getElementById('foto_tantangan').files[x]);
    }

    $.ajax({
        url: appurl+'v1/modul/tantangan/jawab',
        data: formData,
        type: 'POST',
        contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
        processData: false, // NEEDED, DON'T OMIT THIS
    })
    .done(function(status){
        hideLoading()
        swal("Selamat", "Anda berhasil mensubmit jawaban untuk tantangan ini ")
        window.location="detailmateri"
        getAllQuizUser()
    })
    .fail(function(status){
        swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")

    })
    }


// user activity 
function getUserActivity(appurl, token){
    var headers = {headers : {
        'Authorization' : 'Bearer '+token
    }}
    axios.get(appurl+'v1/users/activity', headers)
    .then(function(response){
        console.log(response)
        var lengthEnrolled =  response.data.modulDiambil.length
        var lengthAnswered = response.data.tantanganDijawab.length
        var lengthScored = response.data.tantanganDinilai.length

        var dataEnrolled = response.data.modulDiambil
        var dataAnswered = response.data.tantanganDijawab
        var dataScored = response.data.tantanganDinilai

        ModulOnUserAct('enrolled', '#list_modul_enrolled', lengthEnrolled, dataEnrolled)
        ModulOnUserAct('answered', '#list_modul_answered', lengthAnswered, dataAnswered)
        ModulOnUserAct('scored', '#list_modul_scored', lengthScored, dataScored)

       
    })
    .catch(function(error){
        console.log(error)
    })
}

function ModulOnUserAct(status, id, length, data){
    for(var i=0; i<length;i++){
        if(data[i].flag == status){
            switch(data[i].modul.aspect){
                case "ekosistem-positif":
                        // code block
                        var category_materi = "Penciptaan Ekosistem Positif di Sekolah"
                    break;
                case "trisentra-pendidikan":
                    // code block
                    var category_materi = "Tri Sentra Pendidikan"
                    break;
                case "pengembangan-karakter":
                    // code block
                    var category_materi = "Pengembangan Karakter"
                    break;
                case "pembelajaran-riset":
                    // code block
                    var category_materi = "Pembelajaran Berbasis Riset"
                    break;
            }
            $(id)
            .append(
                '<div class="row" style="margin-bottom:20px;cursor:pointer" onclick=gotomodul("'+data[i].modul._id+'")>'+
                    '<div class="col-md-12" style="font-size:12px">'+
                        '<p style="margin-bottom:1px"><b>'+data[i].modul.title+'</b></p>'+
                        '<p style="margin-top:0px" >Kategori : '+category_materi+'</p>'+
                        '<p style="margin-top:0px" >Level : '+data[i].modul.grade+'</p>'+
                    '</div>'+
                '</div>'+
                '<hr>'
            )
        }
    }
}

function gotomodul(id_modul){
    localStorage.setItem('id_materi', id_modul)
    window.location="detailmateri"
}

function delete_cookie( name ) {
    console.log(name)
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/ ';
    // document.cookie = "cookiename=cookievalue; expires= Thu, 21 Aug 2014 20:00:00 UTC; path=/ "
  }

function logout(){
    
    var token_user = getCookie("token_login_user_gsm")
    var appurl = localStorage.getItem("url_elearning_gsm")
    axios.get(appurl+"v1/logout", {headers : {
        "Content-Type" : "application/json", 
        "Accept" : "application/json", 
        "Authorization" : "Bearer "+token_user
    }})
    .then(function(response){
        console.log(response)
        if(response.data.message == "Logout success!"){
            
            swal("Berhasil Logout", "Mengalihkan ke halaman pembuka")
            window.location="login"
            localStorage.clear()
            localStorage.setItem("url_elearning_gsm",appurl)
            delete_cookie("token_login_user_gsm")
            deleteToken()
            
            
        }else{
            swal("Terjadi Kesalahan", "Mohon cek koneksi internet Anda")
        }
    })
}

function updatefoto(){
    showLoading()
    var token_user=getCookie("token_login_user_gsm")
    var appurl = localStorage.getItem("url_elearning_gsm")
    var formData = new FormData();
    formData.append('action', 'uploadImage');
    formData.append('image', document.getElementById('foto_user').files[0]);
    $.ajax({
    url: appurl+'v1/users/photo-profile',
    data: formData,
    type: 'POST',
    headers : {
        "Accept" : "application/x-www-form-urlencoded", 
        "Authorization" : "Bearer "+token_user
    }, 
    contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
    processData: false, // NEEDED, DON'T OMIT THIS
})
.done(function(response, status ){
    hideLoading()
    localStorage.setItem('fotoUser', response.data.photo_profile[0].filename)
    swal("Selamat", "Anda berhasil mengupdate foto")
    window.location="editprofile"
})
.fail(function(response,status){
    swal("Maaf", "Terjadi kesalahan, mohon cek koneksi internet Anda")
    console.log(response)
})
}

function showthread2users(appurl, token_user, assesorId2){
    $.ajax({
        type: 'POST',
        url: appurl+'v1/pendampingan/thread2users',
        headers: {
            "Authorization" : "Bearer "+token_user,
            "Content-Type" : "application/x-www-form-urlencoded", 
            "Accept" : "application/x-www-form-urlencoded"
        },
        data: assesorId2
        })
        .done(function(response){
            var x = document.getElementById("loading")
            x.style.display = "none"
            console.log(response)
            localStorage.setItem("thread_id", response.thread._id)
            var length = response.message.length
            for(var i = 0 ; i<length;i++){
                if(response.message[i].user.role == "assessor"){
                    var classChat = "clearfix"
                    var subject = "Assessor"
                    var message = response.message[i].body
                }else{
                    var classChat = "clearfix odd"
                    var subject = "Anda"
                    var message = response.message[i].body

                }
                $("#listChat").append(
                '<li class="'+classChat+'">'+
                    '<div class="chat-avatar">'+
                        '<img src="assets/images/users/avatar.png" alt="male">'+
                        
                    '</div>'+
                    '<div class="conversation-text">'+
                        '<div class="ctext-wrap">'+
                            '<i>'+subject+'</i>'+
                            '<p>'+message+'</p>'+
                        '</div>'+
                    '</div>'+
                '</li>'
            )
            }
           
        })
        .fail(function(response){
            console.log(response)
            var x = document.getElementById("loading")
            x.style.display = "none"
            
        })
}

function showLoading(){
    document.getElementById('iconLoading').style.display="block"
    document.getElementById('sendText').style.display="none"
}

function hideLoading(){
    document.getElementById('iconLoading').style.display="none"
    document.getElementById('sendText').style.display="block"
}