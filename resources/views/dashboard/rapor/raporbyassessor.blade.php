@extends('dashboard.layouts.master')
@section('css')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-editable/datatables.css')}}">
@endsection

@section('title')
  <title>Admin Dashboard GSM - Rapor Oleh Assessor</title>
@endsection

@section('content')
<div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                        <div class="col-sm-12">
                                <h4 class="page-title">Rapor Oleh Assessor</h4>
                                <ol class="breadcrumb">
                                    <li>
                                      <a href="{{ url('dashboard/') }}">Home</a>
                                    </li>
                                    <li>
                                        Rapor
                                    </li>
                                    <li class="active">
                                       <a href="{{ url('dashboard/raporbyassessor/listassessor') }}">List Assessor</a> 
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
                                            <th>Sekolah</th>
                                            <th>Kabupaten/Kota</th>
                                            <th>Kuota</th>
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
    var token_user=getCookie("token_login_user_gsm")
    var headers = {
        headers : {
        "Content-Type" : "application/json", 
        "Authorization" : "Bearer "+token_user
        }
    }
    axios.get(appurl+'v1/users/choose/assessor', headers)
    .then(function(response){
        // console.log(response)
        populateDataTable(response.data.data)
    })
    .catch(function(response){
        swal("Maaf", "Terjadi kesalahan, cek koneksi internet Anda")
      console.log(response)
    })
})

function populateDataTable(data) {
    $("#datatable-fixed-header").DataTable().clear();
    var length = data.length;
    // Perulangan for untuk memasukan data ke variable, akan diulang sekian kali sesuai length nya
    for (var i = 0; i < length; i++) {
    var a=data[i].name;
    var b=data[i].school_gsm.sekolah;
    var c = data[i].school_gsm.sekolah;
    var d = data[i].assessor_kuota_now+"/25" ;
    var id = data[i]._id
    var nama = data[i].name
    var action = '<button style="margin-left:10px" class="btn btn-default waves-effect waves-light" onclick="viewuser(\'' + id + '\',\'' + nama + '\')">Lihat usernya</button>';
    $('#datatable-fixed-header').dataTable().fnAddData([
    a, b, c, d, action
    ]);
    }
}

function viewuser(id, nama){
   localStorage.setItem("id_assessor", id)
   localStorage.setItem("assessor_name", nama)
   window.location = "{{ url('dashboard/raporbyassessor/listuser')}}"
}
</script>
  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>

@endsection
