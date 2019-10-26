
/**
* Theme: Ubold Admin Template
* Author: Coderthemes
* SweetAlert
*/



!function ($) {
    "use strict";
    

    var SweetAlert = function () {
    };

    //examples
    SweetAlert.prototype.init = function () {
        

        //Basic
        $('#sa-basic').click(function () {
            swal("Here's a message!");
        });

        //A title with a text under
        $('#sa-title').click(function () {  
            swal("Here's a message!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat, tincidunt vitae ipsum et, pellentesque maximus enim. Mauris eleifend ex semper, lobortis purus sed, pharetra felis")
        });

        $('#update').click(function(){
            var appurl = localStorage.getItem("url_elearning_gsm")
            var id = document.getElementById('id').value
            console.log(appurl)
            console.log(id)
            var data = {
                "name" : document.getElementById('nama').value, 
                "attendedWorkshop" : document.getElementById('workshop').value, 
                "detail" : {
                    "birthplace" : document.getElementById('tempat_lahir').value,
                    "birthdate" : document.getElementById("datepicker-autoclose").value,
                    "gender" : document.getElementById('gender').value,
                    "position" : document.getElementById('posisi').value,
                    "lastEducation" : document.getElementById('pendidikan').value,
                    "phone" : document.getElementById('no_wa').value
                }
            } 
            console.log(data)
            var data_2 = JSON.stringify(data)
            console.log(data_2)
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
            var token_user = getCookie("token_login_user_gsm")
            
            
            $(document).ajaxStart(function() { Pace.restart(); });
            $.ajax({
                type: 'POST',
                url: appurl+'v1/user/'+id,
                data: data_2,
                headers: {
                    "Authorization" : "Bearer "+token_user,
                    "Content-Type": "application/json",
                },
                
                })
                .done(function(data, status){
                    if(status){
                        swal("Bagus", "Data berhasil diperbarui")
                    }
                })
                .fail(function(data, status){
                    if(status){
                        swal("Terjadi Kesalahan", "Pastikan koneksi internet Anda berjalan dengan benar")
                    }
                })
        })

        $('#lupapassword').click(function(){
            document.getElementById('loading').style.display = "block"
            var appurl = localStorage.getItem("url_elearning_gsm")
            $(document).ajaxStart(function() { Pace.restart(); });
            if(document.getElementById('email').value == ""){
                swal("Maaf", "Isilah field email yang ada")
            }else{
            var formData = new FormData()
            formData.append("email",  document.getElementById('email').value )
            $.ajax({
                type: 'POST',
                url: appurl+'v1/password/create',
                data: formData,
                processData: false,
                contentType: false
                })
                .done(function(data, status){
                    if(status){
                        document.getElementById('loading').style.display = "none"
                        document.getElementById('inputEmailMessage').style.display ="none"
                        document.getElementById('resetPasswordMessage').style.display ="block"
                        swal("Cek Email", "Kami  mengirimkan email berisi link untuk mereset password. Silahkan cek spam bila bila tidak menemukannya")
                    }
                })
                .fail(function(data, status){
                    console.log(data)
                    console.log(status)
                    if(status){
                        document.getElementById('loading').style.display = "none"
                        swal("Terjadi Kesalahan", "Pastikan koneksi internet dan alamat email Anda benar")
                    }
                })
            }
            
        })
         //Tombol login dengan id=login menjalankan fungsinya ketika diklik
        $('#login').click(function(){
            // Menampilkan loading image sebagai petunjuk untuk user bahwa proses sedang berlangsung
            var x = document.getElementById("loading")
            x.style.display = "inline"
            // Mengambil base url dari local storage yang telah disimpan ketika halaman dimuat pertama kali
            var appurl = localStorage.getItem("url_elearning_gsm")
            // Mendeteksi input yang masih kosong   
            if(document.getElementById('email').value == "" ||
            document.getElementById('password').value == ""
            ){
                // Peringatan bila ada input yang masih kosong
                swal("Isilah semua field yang ada")
            }else{
                // Mengambil data dari semua field input yang ada
               var data = {
                    email : document.getElementById('email').value,
                    password : document.getElementById('password').value,
                    fcm_token : localStorage.getItem("tokenFCM")
                }
                // Memulai request ke API yang ditentukan menggunakan AJAX request 
                $(document).ajaxStart(function() { Pace.restart(); });
                console.log("hello")
                $.ajax({
                    type: 'POST',
                    url: appurl+'v1/login',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "Accept"      : "application/x-www-form-urlencoded"
                    },
                    data: data
                    })
                     // Function yang dijalankan ketika request berhasil
                    .done(function(data, status){
                    var x = document.getElementById("loading")
                     x.style.display = "none"
                     swal("Selamat", "Anda berhasil login")   
                     localStorage.setItem('assessorId2', data.data.assessor_id)                 
                     localStorage.setItem('data_user_elearning_gsm', JSON.stringify(data.data))
                     if(data.data.photo_profile.length>0){
                        localStorage.setItem('fotoUser', data.data.photo_profile[0].filename)
                     }
                    // Menjalankan function untuk menyimpan token yang diberikan sebagai token cookies
                     setCookie("token_login_user_gsm", data.token, 30)
                     function setCookie(cname,cvalue,exdays) {
                     var d = new Date();
                     d.setTime(d.getTime() + (exdays*24*60*60*1000));
                     var expires = "expires=" + d.toGMTString();
                     document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                     }
                     // Menjalankan function untuk mengambil token cookies
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
                     window.location="elearning"
                    })
                     // Function yang dijalankan ketika request gagal
                    .fail(function(data,status){
                        console.log(data)
                        var x = document.getElementById("loading")
                     x.style.display = "none"
                        swal("Maaf", "Terjadi kesalahan, Pastikan data diinputkan dengan benar atau cek koneksi internet Anda")
                    })
            }
        })

        //Tombol daftar dengan id=”daftar” menjalankan fungsinya ketika diklik
        $('#daftar').click(function () {
            var url_string = window.location.href
            var url = new URL(url_string);
            var invitedBy = url.searchParams.get("invitedBy");
            if(invitedBy !== null){
                var idPengajak = invitedBy
            }else{  
                var idPengajak = ''
            }
            // Mengambil base url dari local storage yang telah disimpan ketika halaman dimuat pertama kali
            var appurl = localStorage.getItem("url_elearning_gsm")
            // Mendeteksi input yang masih kosong
            if(document.getElementById('nama').value=="" || 
               document.getElementById('email').value=="" || 
               document.getElementById('password').value=="" || 
               document.getElementById('repeat_password').value=="" ||
               document.getElementById('sekolah').value=="" ||
               $('input[name=workshop]:checked').val() == undefined
            ){
                // Peringatan bila ada input yang masih kosong
                swal("Maaf", "Isilah semua data yang ada")
            }else{
                // Kondisi if bila input password dan confirm password sudah cocok
                if(document.getElementById('password').value==document.getElementById('repeat_password').value){
                    // Mengambil data dari semua field input yang ada
                    var workshop = $('input[name=workshop]:checked').val()
                    var data = {
                        name : document.getElementById('nama').value, 
                        reg_coupon : document.getElementById('kupon').value, 
                        password : document.getElementById('password').value, 
                        c_password :document.getElementById('repeat_password').value, 
                        email : document.getElementById('email').value, 
                        attendedWorkshop : workshop, 
                        invited_by : idPengajak, 
                        school : {
                            propinsi: document.getElementById('propinsi').value ,
                            kode_kab_kota: document.getElementById('kode_kab_kota').value   ,
                            kabupaten_kota: document.getElementById('kabupaten/kota').value ,
                            kode_kec: document.getElementById('kode_kec').value ,
                            kecamatan: document.getElementById('kecamatan').value  ,
                            npsn: document.getElementById('npsn').value ,
                            sekolah: document.getElementById('sekolah').value  ,
                            bentuk: document.getElementById('bentuk').value,
                            status: document.getElementById('status').value ,
                            alamat_jalan: document.getElementById('alamat_jalan').value,
                            lintang: document.getElementById('lintang').value,
                            bujur: document.getElementById('bujur').value
                        }
                        }
                        console.log(data)
                        // Menampilkan loading image sebagai petunjuk untuk user bahwa proses sedang berlangsung
                        var x = document.getElementById("loading")
                        x.style.display = "inline"
                        // Memulai request ke API yang telah ditentukan menggunakan AJAX request
                        $(document).ajaxStart(function() { Pace.restart(); });
                        $.ajax({
                            type: 'POST',
                            url: appurl+'v1/register',
                            headers: {
                                "Content-Type": "application/x-www-form-urlencoded",
                                "Accept"      : "application/x-www-form-urlencoded"
                            },
                            data: data
                            })
                            // Function yang dijalankan ketika request berhasil
                            .done(function(response, status){
                                swal("Selamat", "Anda berhasil mendaftar, silahkan masukan email dan password di halaman login ")
                                window.location="login"
                                var x = document.getElementById("loading")
                                x.style.display = "none"
                            })
                            // Function yang dijalankan ketika request gagal
                            .fail(function(response,status){
                                console.log(response)
                                if(response.status == 500){
                                    swal("Maaf", "Anda memasukan email yang tidak terdaftar, coba ulangi lagi")
                                }else if(response.responseJSON[0].email[0] == "The email has already been taken."){
                                    swal("Maaf", "Email ini sudah terdaftar, gunakan email lain")
                                }
                                var x = document.getElementById("loading")
                                x.style.display = "none"                                
                            })
                // Peringatan yang akan muncul bila input password dan confirm password masih salah
                }else{
                    swal("Maaf", "Password dan Ulangi Password tidak sama, perbaiki kembali")
                }
            }      
        });

    

        //Success Message
        $('#sa-success').click(function () {
            swal("Good job!", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed lorem erat, tincidunt vitae ipsum et, pellentesque maximus enim. Mauris eleifend ex semper, lobortis purus sed, pharetra felis", "success")
        });

        //Warning Message
        $('#sa-warning').click(function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-warning',
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                swal("Deleted!", "Your imaginary file has been deleted.", "success");
            });
        });

        //Parameter
        $('#sa-params').click(function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel plx!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                }
            });
        });

        //Custom Image
        $('#sa-image').click(function () {
            swal({
                title: "Sweet!",
                text: "Here's a custom image.",
                imageUrl: "assets/plugins/bootstrap-sweetalert/thumbs-up.jpg"
            });
        });

        //Auto Close Timer
        $('#sa-close').click(function () {
            swal({
                title: "Auto close alert!",
                text: "I will close in 2 seconds.",
                timer: 2000,
                showConfirmButton: false
            });
        });

        //Primary
        $('#primary-alert').click(function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "info",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-primary btn-md waves-effect waves-light',
                confirmButtonText: 'Primary!'
            });
        });

        //Info
        $('#info-alert').click(function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "info",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-info btn-md waves-effect waves-light',
                confirmButtonText: 'Info!'
            });
        });

        //Success
        $('#success-alert').click(function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "success",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-success btn-md waves-effect waves-light',
                confirmButtonText: 'Success!'
            });
        });

        //Warning
        $('#warning-alert').click(function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-warning btn-md waves-effect waves-light',
                confirmButtonText: 'Warning!'
            });
        });

        //Danger
        $('#danger-alert').click(function () {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this imaginary file!",
                type: "error",
                showCancelButton: true,
                cancelButtonClass: 'btn-white btn-md waves-effect',
                confirmButtonClass: 'btn-danger btn-md waves-effect waves-light',
                confirmButtonText: 'Danger!'
            });
        });


    },
        //init
        $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),

//initializing
    function ($) {
        "use strict";
        $.SweetAlert.init()
    }(window.jQuery);