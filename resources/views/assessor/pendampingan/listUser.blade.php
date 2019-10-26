@extends('assessor.layouts.master')
@section('css')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-editable/datatables.css')}}">
@endsection

@section('title')
  <title>Assessor Dashboard GSM - Pendampingan</title>
@endsection

@section('content')
<div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                <div class="col-sm-12">
                        <h4 class="page-title">Pendampingan</h4>
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ url('assessor/') }}">Home</a>
                            </li>
                            <li>
                                Pendampingan
                            </li>
                            <li>
                                <a href="{{ url('assessor/pendampingan/listuser/') }}">List User</a>
                            </li>
                        </ol>
                </div>
            </div>
            <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                                <table id="datatable-fixed-header" class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Sekolah</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Unread Message</th>
                                            <th>Aksi</th>   
                                        </tr>
                                        </thead>
                                </table>
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
    var appurl = localStorage.getItem("url_elearning_gsm")
    console.log(appurl)
    var token_user=getCookie("token_login_user_gsm")
    console.log(token_user)
    var id = localStorage.getItem("id_assessor")
    console.log(id)

    var headers = {
        headers : {
        "Content-Type" : "application/json", 
        "Authorization" : "Bearer "+token_user
        }
    }
    axios.get(appurl+'v1/admin/assessor/user-list/'+id, headers)
    .then(function(response){
        console.log(response)
        var listuser = response.data.data
        axios.get(appurl+'v1/pendampingan/countAssessor', headers)
        .then(function(res){
            console.log(res)
            var pesan = res.data.pesan_baru
            populateDataTable( listuser, pesan)
        })
       .catch(function(err){
        console.log(err)
           swal("Terjadi Kesalahan", "Silahkan cek koneksi internet Anda")
       })
    })
    .catch(function(response){
        console.log(response)
    })
})

function populateDataTable(data, pesan) {
    $("#datatable-fixed-header").DataTable().clear();
    var length = data.length;
    console.log(data)
    // Perulangan for untuk memasukan data ke variable, akan diulang sekian kali sesuai length nya
    for (var i = 0; i < length; i++) {
    var a=data[i].name;
    var email = data[i].email
    if(data[i].schoolgsm == null){
        var b = 'Data Sekolah Kosong'
        var c = 'Data Sekolah Kosong'
    }else{
        var b=data[i].schoolgsm.sekolah;
        var c = data[i].schoolgsm.kabupaten_kota;
    }
    
    var d = pesan[i];
    var action = '<button  style="margin:5px" class="btn btn-default waves-effect waves-light" onclick="viewuser(\'' + data[i]._id + '\',\'' + data[i].name + '\')">View User</button>'
    $('#datatable-fixed-header').dataTable().fnAddData([
    a, email, b, c, d, action
    ]);
    }
}

function viewuser(id, name){
   localStorage.setItem("id_usernya_assessor", id)
   localStorage.setItem("user_name", name)
   window.location =  "{{ url('/assessor/pendampingan/pagependampingan') }}"
//    window.location = '/elearning/public/assessor/pendampingan/pagependampingan'
}


</script>
  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>

@endsection
