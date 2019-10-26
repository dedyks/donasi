@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Detail Rapor User</title>
@endsection

@section('css')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-editable/datatables.css')}}">
@endsection

@section('content')
  <div class="content-page">
      <div class="content">
          <div class="container">
              <div class="row">
                <div class="col-sm-12">
                  <h4 class="page-title">Detail Rapor User</h4>
                  <ol class="breadcrumb">
                    <li>
                      <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                      <a href="{{ url('/dashboard/rapor/sekolah') }}">Rapor Sekolah</a>
                    </li>
                    <li>
                      <a href="{{ url('/dashboard/rapor/sekolah/list-rapor') }}?id=">List Rapor</a>
                    </li>
                    <li class="active">
                      Detail Rapor User
                    </li>
                  </ol>
                </div>
              </div>

              <div class="panel panel-color panel-custom">
                  <div class="panel-heading">
                    <h3 class="panel-title">Profil User</h3>
                  </div>
                  <div class="panel-body">
                      <div class="col-sm-3">
                        <img src="{{ asset('assets/images/avatar-3.png') }}" alt="image" class="img-responsive img-rounded" width="200" style="margin: auto">
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Nama:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="name">
                            -
                        </p>
                        <h5><b>Jenis kelamin:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="gender">
                            -
                        </p>
                        <h5><b>Tempat Lahir:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="birthplace">
                            -
                        </p>
                        <h5><b>Tanggal Lahir:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="birthdate">
                            -
                        </p>
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Jabatan:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="position">
                            -
                        </p>
                        <h5><b>Pernah Ikut Workshop GSM:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="attendedWorkshop">
                            -
                        </p>
                        <h5><b>Role:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="role">
                            -
                        </p>
                      </div>
                      <div class="col-sm-3">
                        <h5><b>Pendidikan Terakhir:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="lastEducation">
                            -
                        </p>
                        <h5><b>Email:</b></h5>
                        <p class="text-muted m-b-15 font-13" id="email">
                            -
                        </p>
                        <h5><b>No. HP (WA):</b></h5>
                        <p class="text-muted m-b-15 font-13" id="phone">
                            -
                        </p>
                      </div>
                  </div>
              </div>

              <div class="row">
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Lingkungan Positif dan Etis</h3>
                    </div>
                    <div class="panel-body" style="height:200px;overflow:auto" id="aspek-lingkungan-positif-dan-etis">

                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Penumbuhan Karakter</h3>
                    </div>
                    <div class="panel-body" style="height:200px;overflow:auto" id="aspek-penumbuhan-karakter">

                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Pembelajaran Berbasis Problem & Riset</h3>
                    </div>
                    <div class="panel-body" style="height:200px;overflow:auto" id="aspek-pembelajaran-berbasis-problem-dan-riset">

                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Aspek Konektifitas Sekolah</h3>
                    </div>
                    <div class="panel-body" style="height:200px;overflow:auto" id="aspek-konektifitas-sekolah">

                    </div>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="panel panel-color panel-custom">
                    <div class="panel-heading">
                      <h3 class="panel-title">Gambar yang diupload</h3>
                    </div>
                    <div class="panel-body" style="height:300px;overflow:auto" id="aspek-konektifitas-sekolah">
                      <div class="row">

                      </div>
                      <div class="row" id="uploadedImage" style="margin-bottom:20px">

                      </div>
                    </div>
                  </div>
                </div>
              </div>

          </div>
      </div>
  </div>
@endsection


@section('js')
  <script>
    $(document).ready(function(){
      var x = getCookie('token_login_user_gsm');

      var id = new URLSearchParams(document.location.search.substring(1));
      var id_rapor = id.get("id");

      $.ajax({
        type: 'GET',
        url: "{{ url('/') }}/api/v1/admin/rapor/id/"+id_rapor,
        headers: {"Authorization": "Bearer " + x}
      })
      .done(function(data, status){
        console.log(status)

        document.getElementById('name').innerHTML = data.data.user.name;
        if (data.data.user.attendedWorkshop) {
          document.getElementById('attendedWorkshop').innerHTML = "Pernah"
        } else {
          document.getElementById('attendedWorkshop').innerHTML = "Tidak pernah";
        }
        document.getElementById('email').innerHTML = data.data.user.email;
        document.getElementById('role').innerHTML = data.data.user.role;

        if ('detail' in data.data.user) {
          if ('gender' in data.data.user.detail) document.getElementById('gender').innerHTML = data.data.user.detail.gender;
          if ('birthplace' in data.data.user.detail) document.getElementById('birthplace').innerHTML = data.data.user.detail.birthplace;
          if ('birthdate' in data.data.user.detail) document.getElementById('birthdate').innerHTML = data.data.user.detail.birthdate;
          if ('position' in data.data.user.detail) document.getElementById('position').innerHTML = data.data.user.detail.position;
          if ('lastEducation' in data.data.user.detail) document.getElementById('lastEducation').innerHTML = data.data.user.detail.lastEducation;
          if ('phone' in data.data.user.detail) document.getElementById('phone').innerHTML = data.data.user.detail.phone;
        }

        if ('image' in data.data){
          var jumlahGambar = data.data.image.length
          var gambar = data.data.image
          var urlImage = {!! json_encode(url('/')) !!}

          for(var x= 0; x< jumlahGambar; x++){
            $("#uploadedImage").append(
              '<div class="col-md-4">'+
                  '<img src="'+urlImage+'/storage/images/'+gambar[x].filename+'" alt="image" class="img-responsive img-rounded" width="100%"/>'+
              '</div>'
            )
          }
        }

        var response = data.data.laporan
        var length =  response.length
          for(var i = 0; i<length; i++){
              var aspek = response[i].aspek
              var response2 = response
              switch(aspek){
                  case "Lingkungan Positif dan Etis":
                      var id_namePanel = 'aspek-lingkungan-positif-dan-etis'
                      var id_nameList = 'listLPdE'
                      appendListRapor(aspek, response2, i, id_namePanel, id_nameList )

                  break;
                  case "Penumbuhan Karakter":
                          var id_namePanel = 'aspek-penumbuhan-karakter'
                          var id_nameList = 'listPK'
                          appendListRapor(aspek, response2, i, id_namePanel, id_nameList )

                  break;
                  case "Pembelajaran Berbasis Problem dan Riset":
                          var id_namePanel = 'aspek-pembelajaran-berbasis-problem-dan-riset'
                          var id_nameList = 'listPBPdR'
                          appendListRapor(aspek, response2, i, id_namePanel, id_nameList )

                  break;
                  case "Konektifitas Sekolah":
                      var id_namePanel = 'aspek-konektifitas-sekolah'
                      var id_nameList = 'listKS'
                      appendListRapor(aspek, response2, i, id_namePanel, id_nameList )
                  break;
              }
          }
      })
      .fail(function(data, status){
        console.log(status);
        var err_message = data.responseText;
        var fix_message = err_message.length > 100 ? err_message.substring(0, 100 - 3) + "..." : err_message;
        swal({
          title: "Maaf",
          text: "Pastikan koneksi internet anda lancar. \n\n Message: "+fix_message,
          type: "error",
          allowOutsideClick: true
        })
      })
    })

    function appendListRapor(aspek, response, i, id_namePanel, id_nameList ){
      if(response[i].cek == true){
            var checked = "checked"
        }else{
            var checked =""
        }
        $("#"+id_namePanel).append(
            '<div class="row" id="'+id_nameList+i+'">'+
            '<div class="col-md-12">'+
            '<p>'+response[i].poin+'</p>'+
            '</div>'+
            '<div class="col-md-6">'+
            '<div  class="checkbox checkbox-custom">'+
            '<input id="checkbox'+i+'" type="checkbox" '+checked+' disabled>'+
            '<label for="checkbox'+i+'">'+
                'Cek'+
            '</label>'+
            '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
            '<p style="margin-top:9px">Skor : '+response[i].skor+'</p>'+
            '</div>'+
            '<div class="col-md-12">'+
            '<p> <b>Bukti Perubahan</b> : <span>'+response[i].evaluasi+'</span></p>'+
            '</div>'+
            '<div class="col-md-12">'+
            '<hr>'+
            '</div>'+
            '</div>'
        )
    }
  </script>
@endsection
