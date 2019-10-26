@extends('layout.form')
@section('content')
            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->                      
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                            <div class="panel panel-color panel-custom">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">Kupon Workshop</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <p>Anda punya Kupon dari workshop? Kirimkan di sini </p>
                                                    <div class="col-md-10"  style="margin-left:-10px;margin-top:5px">
                                                            <input type="text"  class="form-control" id="kupon" name="kupon" placeholder=""> 
                                                    </div>
                                                    <div class="col-md-2" style="margin-top:5px;margin-left:-10px">
                                                            <button style="float:left" type="button" onclick="uploadKupon()" class="btn btn-default waves-effect waves-light">
                                                                Kirim
                                                            </button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="panel panel-color panel-custom">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Tulis Konten Berbagi</h3>
                                            </div>
                                            <div class="panel-body">
                                            <div class="col-md-12 form-group">
                                                <br>
                                                <label class="control-label">Upload Foto</label>
                                                <p>Tidak dapat mengupload foto dengan ukuran lebih dari 5 MB</p>
                                                <input type="file" class="filestyle" multiple id="fotoBerbagi" data-buttonname="btn-white">
                                            </div>
                                            <div class="col-md-12 form-group" style="display:none">
                                                <label class="control-label">Judul</label>
                                                <input type="text"  class="form-control" id="title" value="-" name="judul" placeholder="Boleh dikosongkan"> 
                                            </div>
                                            <div class="col-md-12 form-group">
                                                    <label class="control-label">Kupon Workshop</label>
                                                    <p>Pilih kupon yang sudah Anda kirim sebelumnya (optional)</p>
                                                    <select name=""  data-live-search="true" data-style="btn-white" class="selectpicker" id="selectedKupon">
                                                            <option value="" selected>-</option>
                                                    </select>
                                                </div>
                                            <div class="col-md-12 form-group">
                                                    <label class="control-label">Tuliskan Cerita Anda</label>
                                                    <p>Deskripsi cerita Anda </p>
                                                    <textarea id="content" class="form-control"rows="2" placeholder=""></textarea>
                                            </div>
                                            
                                           <div class="col-md-12">
                                                <button style="float:right" type="button" onclick="uploadBerbagi()" class="btn btn-default waves-effect waves-light">
                                                    <span id="uploadText" style="">Upload</span>
                                                    <i id="uploadLoadingIcon" style="display:none" class="fa fa-spin fa-spinner"></i>
                                                    {{-- <img src="assets/images/ajax-loader.gif" alt="image" style="margin-bottom:10px;width:50%" class="img-rounded"/> --}}
                                                </button>
                                            </div>

                                            </div>
                                        </div>
                                    </div>

                                    

                                    <div class="col-lg-12" >
                                        <div class="panel panel-color panel-custom">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Timeline Berbagi Anda</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-lg-12" style="margin-bottom:15px">
                                                        <ul class="nav nav-tabs tabs">
                                                                <li class="active tab" onclick="changetab('kontenByUser')">
                                                                    <a href="#kontenBerbagi" id="hrefdibagi" data-toggle="tab" aria-expanded="false"> 
                                                                        <span class="visible-xs"><i class="fa fa-share-alt"></i></span> 
                                                                        <span class="hidden-xs">Dibagi</span> 
                                                                    </a> 
                                                                </li> 
                                                                <li class="tab" onclick="changetab('kontenDisukai')"> 
                                                                    <a href="#" id="hrefdisukai" data-toggle="tab" aria-expanded="false"> 
                                                                        <span class="visible-xs"><i class="fa fa-heart"></i></span> 
                                                                        <span class="hidden-xs">Disukai</span> 
                                                                    </a> 
                                                                </li> 
                                                                <li class="tab" onclick="changetab('kontenDisimpan')"> 
                                                                    <a href="#" id="hrefdisimpan" data-toggle="tab" aria-expanded="true"> 
                                                                        <span class="visible-xs"><i class="md md-archive"></i></span> 
                                                                        <span class="hidden-xs">Disimpan</span> 
                                                                    </a> 
                                                                </li> 
                                                            </ul> 
                                                </div>


                                                <div class="tab-content">
                                                        <div class="tab-pane active" id="kontenBerbagi"> 
                                                            <input type="number" value="1" id="pagePagination" autocomplete="off" style="display:none" />
                                                            <input type="number" value="1" id="nextPage" autocomplete="off" style="display:none" />
                                                            <input type="text" value="kontenByUser" id="kontenTerpilih" autocomplete="off" style="display:none" />

                                                            <!-- blog content -->
                                                                <div  id="dibagi"></div>
                                                                <div class="col-md-12" style="text-align:center">
                                                                <button style="text-align:center;" id="loadMore" type="button" onclick="loadMore()" class="btn btn-default waves-effect waves-light">
                                                                <span id="loadText"> Load More </span>
                                                                <i id="uploadLoadingIconKonten" style="display:none" class="fa-spin fa-spinner"></i>
                                                                </button>
                                                            </div>
                                                        </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                              
                    </div> <!-- container -->
                </div> <!-- content -->
                
                {{-- Modal --}}
                <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title" id="mySmallModalLabel">Delete Konten</h4>
                            </div>
                            <div class="modal-body">
                              <p>Apakah Anda yakin ingin menghapus konten ?</p>
                              <div id="buttonDelete" class="col-md-12" style="text-align:center"></div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <footer class="footer text-right">
                    © 2019. All rights reserved.
                </footer>

            </div>
            <script>
            $(document).ready(function(){
                var page = parseInt(document.getElementById("nextPage").value, 10)
                var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                var id = dataUser._id
                var urlImage =  {!! json_encode(url('/')) !!}
                mountArtikel(page, id, urlImage, "kontenByUser" )

                // Get All Kupon 
                var appurl = localStorage.getItem("url_elearning_gsm")
                var token_user=getCookie("token_login_user_gsm")
                axios.get(appurl+'v1/users/kupon/list', {headers : {
                    "Authorization" : "Bearer "+token_user
                }})
                .then(res=>{
                    console.log(res)
                    var kupon = ''
                    for(var i = 0; i < res.data.data.length; i ++){
                        kupon += '<option value="'+res.data.data[i]+'">'+res.data.data[i]+'</option>'
                    }
                    $("select[id='selectedKupon']").append(kupon)
                    $("select[id='selectedKupon']").selectpicker("refresh");
                })
                .catch(err=>{
                    swal("Terjadi Kesalahan", "Silahkan cek koneksi internet Anda")
                })
            })
            function uploadKupon(){
                var appurl = localStorage.getItem("url_elearning_gsm")
                var token_user=getCookie("token_login_user_gsm")
                var formData = new FormData();
                formData.append('kode_kupon', document.getElementById("kupon").value);
                axios.post(appurl+'v1/users/kupon/add', formData , {headers:{
                    "Content-Type" : "application/json", 
                    "Authorization" : "Bearer "+token_user
                }})
                .then(res=>{
                    swal("Berhasil", "Kupon telah ditambahkan")
                    window.location = 'createkontenberbagi'
                })
                .catch(err=>{
                    swal("Terjadi Kesalahan", "Silahkan cek koneksi internet Anda")
                })
            }

            function changetab(param){
                $('#dibagi')
                .find('div')
                .remove()
                document.getElementById("nextPage").value = 1
                document.getElementById("pagePagination").value = 1
                var page = parseInt(document.getElementById("nextPage").value, 10)
                var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                var id = dataUser._id
                var urlImage =  {!! json_encode(url('/')) !!}
                document.getElementById("hrefdibagi").href = "#kontenBerbagi"
                document.getElementById("hrefdisukai").href = "#kontenBerbagi"
                document.getElementById("hrefdisimpan").href = "#kontenBerbagi"
                if(param == "kontenByUser"){
                    mountArtikel(page, id, urlImage, param )
                    document.getElementById('kontenTerpilih').value = param
                }else if(param == "kontenDisukai"){
                    mountArtikel(page, id, urlImage, param )
                    document.getElementById('kontenTerpilih').value = param
                }else if(param ==  "kontenDisimpan"){
                    mountArtikel(page, id, urlImage, param )
                    document.getElementById('kontenTerpilih').value = param
                }
            }

            function loadMore(){
                document.getElementById("loadText").style.display="none"
                document.getElementById("uploadLoadingIconKonten").style.display="block"
                var page = parseInt(document.getElementById("nextPage").value, 10)
                var dataUser = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
                var id = dataUser._id
                var urlImage =  {!! json_encode(url('/')) !!}
                mountArtikel(page, id, urlImage, document.getElementById('kontenTerpilih').value )
            }
            </script>
            
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->
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

            }

            </style>
@endsection