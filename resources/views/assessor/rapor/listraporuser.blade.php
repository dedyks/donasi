@extends('assessor.layouts.master')
@section('css')
  <link rel="stylesheet" href="{{asset('assets/plugins/jquery-datatables-editable/datatables.css')}}">
@endsection

@section('title')
  <title>Assessor Dashboard GSM - Rapor</title>
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
                                        <a href="{{ url('assessor/rapor/listuser') }}">List user</a> 
                                    </li>
                                    <li class="active">
                                            <a href="{{ url('assessor/rapor/listraporuser') }}">List rapor user : <span id="user_name"></span></a> 
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
                                            <th>Judul Rapor</th>
                                            <th>Created </th>
                                            <th>Updated</th>
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
<script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
<script>
$(document).ready(function(){
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user=getCookie("token_login_user_gsm")
    var id = localStorage.getItem("id_usernya_assessor")
    document.getElementById("user_name").innerHTML = localStorage.getItem("user_name")
    var headers = {
        headers : {
        "Content-Type" : "application/json", 
        "Authorization" : "Bearer "+token_user
        }
    }
    axios.get(appurl+'v1/admin/rapor/user/'+id, headers)
    .then(function(response){
        console.log(response)
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
    var a=data[i].judul;
    var b=data[i].created_at;
    var c = data[i].updated_at;
    var action = '<button  style="margin:5px" class="btn btn-default waves-effect waves-light" onclick="viewrapor(\'' + data[i]._id + '\')">Detail rapor</button>'+
    '<button  style="margin:5px" class="btn btn-danger waves-effect waves-light" onclick="deleterapor(\'' + data[i]._id + '\')">Delete Rapor</button>'
    $('#datatable-fixed-header').dataTable().fnAddData([
    a, b, c, action
    ]);
    }
}

function viewrapor(id_rapor){
    localStorage.setItem("id_rapor_user", id_rapor)
    window.location =  "{{ url('/assessor/rapor/detailrapor') }}"

    // window.location = '/elearning/public/assessor/rapor/detailrapor'
}

function deleterapor(id_rapor){
    swal({
    title: 'Hapus Rapor ?',
    text: 'Apkah Anda yakin untuk menghapusnya ?',
    showCancelButton: true,
    confirmButtonColor: 'red',
    confirmButtonText: 'Yes!',
    cancelButtonText: 'No.'
    }).then((result) => {
    if (result.value) {
        deleteraporconfirm(id_rapor)
    } else {
        // result.dismiss can be 'cancel', 'overlay', 'esc' or 'timer'
    }
    });
   

}

function deleteraporconfirm(id){
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user=getCookie("token_login_user_gsm")
    axios.delete(appurl+"v1/admin/rapor/id/"+id, {headers : {
        "Authorization" : "Bearer "+token_user
    }})
    .then(function(response){
        console.log(response)
        swal("Berhasil Dihapus")
        window.location = "{{url('/assessor/rapor/listraporuser')}}"
    })
    .catch(function(error){
        console.log(error)
    })
}
</script>
  <script src="{{asset('assets/plugins/jquery-datatables-editable/jquery.dataTables.js')}}"></script>
  <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/mindmup-editabletable.js')}}"></script>
  <script src="{{asset('assets/plugins/tiny-editable/numeric-input-example.js')}}"></script>
  <script src="{{asset('assets/pages/datatables.editable.init.js')}}"></script>

@endsection
