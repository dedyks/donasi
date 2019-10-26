@extends('dashboard.layouts.master')

@section('title')
  <title>Admin Dashboard GSM - Format Rapor</title>
@endsection

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                    <div class="col-sm-12">
                            <h4 class="page-title">Create Format Rapor</h4>
                            <ol class="breadcrumb">
                                <li>
                                  <a href="{{ url('dashboard/') }}">Home</a>
                                </li>
                                <li>
                                    Rapor
                                </li>
                                <li class="active">
                                  Create Format 
                                </li>
                            </ol>
                        </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                  <div class="card-box">
                    <div class="row" style="text-align:center;display:none" id="firstMessage" >
                      <p>Belum ada format laporan yang pernah dibuat</p>
                      <button style="margin-top:10px;" class="btn btn-purple waves-effect waves-light" onclick="openFormat()">Buat Sekarang</button>
                    </div>
                    <div class="row" id="createFormat1" style="display:none">
                      <div class="col-md-12">
                        <p>Buatlah format dengan memilih aspek dan isilah formatnya</p>
                        <select name="aspect" class="selectpicker" id="aspect" data-live-search="true" data-style="btn-white" required>
                            <option value="Lingkungan Positif dan Etis">Lingkungan Positif dan Etis</option>
                            <option value="Penumbuhan Karakter">Penumbuhan Karakter</option>
                            <option value="Pembelajaran Bebasis Problem dan Riset">Pembelajaran Bebasis Problem dan Riset</option>
                            <option value="Konektifitas Sekolah">Konektifitas Sekolah</option>
                        </select>
                        <input style="margin-top:10px" type="text" class="form-control" id="inputFormat" name="inputFormat" placeholder="Masukkan formatnya" required>
                        <button style="margin-top:10px;float:right" class="btn btn-purple waves-effect waves-light" onclick="addFormat()">Add to list</button>
                       

                      </div>
                      <div class="col-md-12">
                          <p>Berikut ini list format yang Anda buat sebelum disubmit</p>
                          <div class="row" id="listFormat" style="padding:10px">
                          </div>
                          <div id="buttonSubmit">
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <p style="display:none" id="createFormat2">Format yang telah Anda submit sebelumnya : 
              </p>
              <div style="display:none;margin-bottom:15px" id="deleteButtonClicked"></div>
              <div class="row" id="daftarAspek" style="display:none">
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
              </div>
          </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/js/rapor.js')}}"></script>
<script>
$(document).ready(function(){
  getKerangkaRapor()
})
</script>
@endsection