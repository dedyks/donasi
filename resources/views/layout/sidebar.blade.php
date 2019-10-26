 <!-- ========== Left Sidebar Start ========== -->

 <div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
            <li>
                <a href="javascript:void(0);"><i class=" ti-home"></i><span>Homepage</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/elearning') }}">Welcome Page</a></li>
                    <li><a href="{{ url('/berita') }}">Berita GSM</a></li>
                    <li><a href="{{ url('/persebaran') }}">Persebaran GSM</a></li>
                </ul>
            </li>
            <li>
                <a href="javascript:void(0);"><i class="ti-user"></i><span>Profil User</span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/detailuser') }}">Detail User</a></li>
                    <li><a href="{{ url('/editprofile') }}">Edit Profil</a></li>
                </ul>
            </li>
            <li class="has_sub">
                <a href="javascript:void(0);" class="waves-effect"><i class="ti-agenda"></i> <span> Materi Pelatihan </span><span class="menu-arrow"></span></a>
                <ul class="list-unstyled">
                    <li style="display:none" id="modulSpesial"><a href="{{ url('/detailmateri') }}">Modul Spesial</a></li>
                    <li id="modulBasic"><a href="{{ url('/materibasic') }}">Level Basic</a></li>
                    <li id="modulAdvanced"><a href="{{ url('/materiadvanced') }}">Level Advanced</a></li>
                </ul>
            </li>
            <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-link"></i> <span> Berbagi </span><span class="menu-arrow"></span></a>
                    <ul class="list-unstyled">
                            <li><a href="{{ url('/createkontenberbagi') }}">Buat Konten Berbagi</a></li>
                            <li><a href="{{ url('/linimasaberbagi') }}">Linimasa Berbagi</a></li>
                        </ul>
                </li>
            <li class="has_sub">
                <a href="{{ url('/pendampingan') }}"  class="waves-effect"><i class="fa fa-comment-o"></i> <span>Pendampingan</span><span class="label label-primary pull-right" style="display:none" id="unreadMessage"></span></a>
                {{-- <ul class="list-unstyled">
                    <li><a href="{{ url('/pendampingan') }}">Chat dengan Assessor</a></li>
                </ul> --}}
            </li>
            
           
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script>
$(document).ready(function(){
    var appurl = localStorage.getItem("url_elearning_gsm")
    var token_user=getCookie("token_login_user_gsm")
    var data_diri = JSON.parse(localStorage.getItem("data_user_elearning_gsm"))
    console.log(data_diri.quiz.length)
    if(data_diri.quiz.length == 0 ){
        document.getElementById('modulSpesial').style.display = "block"
        document.getElementById('modulBasic').style.display = "none"
        document.getElementById('modulAdvanced').style.display = "none"
    }
    var assesorId = localStorage.getItem('assessorId2')
    if(assesorId !==null){
        var threadId = localStorage.getItem("thread_id")
    var data = {}
    $.ajax({
    type: 'GET',
    url: appurl+'v1/pendampingan/count/'+threadId,
    headers: {
        "Authorization" : "Bearer "+token_user,
        "Content-Type" : "application/x-www-form-urlencoded", 
        "Accept" : "application/x-www-form-urlencoded"
    },
    data: data
    })
    .done(function(response){
        if(response.data > 0){
            document.getElementById('unreadMessage').style.display = "block"
            document.getElementById('unreadMessage').innerHTML= response.data
        }
        // console.log(response)
    })
    .fail(function(response){
        // console.log(response)
    })
    }
    

})
</script>
<!-- Left Sidebar End --> 