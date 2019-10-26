@extends('assessor.layouts.master')
@section('css')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-editable/datatables.css')}}">
@endsection

@section('title')
  <title>Assessor Dashboard GSM -  Rapor</title>
@endsection

@section('content')
<div class="content-page">
        <div class="content">
            <div class="container">
                <div class="row">
                <div class="col-sm-12">
                        <h4 class="page-title">Rapor</h4>
                        <ol class="breadcrumb">
                            <li>
                                <a href="{{ url('assessor/') }}">Home</a>
                            </li>
                            <li>
                                Rapor
                            </li>
                            <li>
                                <a href="{{ url('assessor/rapor/listuser/') }}">List User</a>
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
                                            <th>Jumlah Rapor</th>
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
        populateDataTable(response.data.data)
    })
    .catch(function(response){
        console.log(response)
    })
})

function populateDataTable(data) {
    $("#datatable-fixed-header").DataTable().clear();
    var length = data.length;
    // Perulangan for untuk memasukan data ke variable, akan diulang sekian kali sesuai length nya
    for (var i = 0; i < length; i++) {
    var a=data[i].name;
    var b=data[i].schoolgsm.sekolah;
    var c = data[i].schoolgsm.kabupaten_kota;
    var d = data[i].countLaporan;
    var action = '<button  style="margin:5px" class="btn btn-default waves-effect waves-light" onclick="listrapor(\'' + data[i]._id + '\',\'' + data[i].name + '\')">Lihat rapor</button>'+ 
    '<button  style="margin:5px" class="btn btn-primary waves-effect waves-light" onclick="createrapor(\'' + data[i]._id + '\',\'' + data[i].name + '\')">Buat rapor</button>'
    $('#datatable-fixed-header').dataTable().fnAddData([
    a, b, c, d, action
    ]);
    }
}

function listrapor(id, name){
   localStorage.setItem("id_usernya_assessor", id)
   localStorage.setItem("user_name", name)
   window.location =  "{{ url('/assessor/rapor/listraporuser') }}"

//    window.location = '/elearning/public/assessor/rapor/listraporuser'

}

function createrapor(id, name){
   localStorage.setItem("id_usernya_assessor", id)
   localStorage.setItem("user_name", name)
   window.location = "{{ url('/assessor/rapor/createrapor') }}"

//    window.location = '/elearning/public/dashboard/raporbyassessor/listraporuser'
}
</script>
  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>

@endsection
