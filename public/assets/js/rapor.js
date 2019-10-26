function openFormat(){
    document.getElementById('firstMessage').style.display = "none"
    document.getElementById('createFormat1').style.display = "block"
    document.getElementById('createFormat2').style.display = "block"
}

function addFormat(){
    var aspect = document.getElementById('aspect').value
    var inputan = document.getElementById('inputFormat').value
    var no = document.getElementsByName('inputFormatKerangka').length
    console.log(no)
    $("#listFormat").append(
        '<div class="col-md-12" style="border:solid 1px #e8e8e8;border-radius:10px;margin-bottom:15px" id="listFormat'+no+'">'+
        '<div class="row">'+
        '<div class="col-md-10">'+
        '<p style="margin-top:5px"> <b>Aspek</b> : '+
        aspect+
        '</p>'+
        '<input type="text" name="aspek" style="display:none" value="'+aspect+'"></input>'+
        '<p> <b>Format</b> : '+
        inputan+
        '</p>'+
        '<input type="text" name="inputFormatKerangka"  style="display:none" value="'+inputan+'"></input>'+
        '</div>'+
        '<div class="col-md-2" style="margin-top:5px;text-align:right">'+
        '<span style="color:red;cursor:pointer" onclick="deleteList('+no+')">Delete</span>'+
        '</div>'+
        '</div>'+
        '</div>'
    )
}

function getKerangkaRapor(){
    var token_user = getCookie("token_login_user_gsm")
    var appurl = localStorage.getItem("url_elearning_gsm")
    console.log(appurl)
    axios.get(appurl+"v1/admin/rapor/kerangka", {headers : {
      "Authorization" : "Bearer "+token_user, 
      "Content-Type" : "application/json"
    }})
    .then(function(response){
        console.log(response)
      var length = response.data.data.kerangka.length
      if(length> 0){
        $("#buttonSubmit").append(
            '<button style="margin-top:10px;float:right" class="btn btn-purple waves-effect waves-light" onclick=updateFormat("'+response.data.data._id+'")>Submit</button>'
        )
        $("#deleteButtonClicked").append(
            '<span style="color:red">'+
            'Whooops, Anda menghapus salah satu atau beberapa list format yang ada, klik tombol berikut ini untuk mengupdate perubahan : <span style="cursor:pointer"  onclick=updateFormat("'+response.data.data._id+'")><u>UPDATE</u></span>'+
            '</span>'
        )
        document.getElementById('firstMessage').style.display = "none"
        document.getElementById('createFormat1').style.display = "block"
        document.getElementById('createFormat2').style.display = "block"
        document.getElementById('daftarAspek').style.display = "block"

        for(var i = 0; i<length; i++){
            var aspek = response.data.data.kerangka[i].aspek
            var response = response
            switch(aspek){
                case "Lingkungan Positif dan Etis":
                    var id_namePanel = 'aspek-lingkungan-positif-dan-etis'
                    var id_nameList = 'listLPdE'
                    appendList(aspek, response, i, id_namePanel, id_nameList )
                   
                break;
                case "Penumbuhan Karakter":
                        var id_namePanel = 'aspek-penumbuhan-karakter'
                        var id_nameList = 'listPK'
                        appendList(aspek, response, i, id_namePanel, id_nameList )
    
                break;
                case "Pembelajaran Berbasis Problem dan Riset":
                        var id_namePanel = 'aspek-pembelajaran-berbasis-problem-dan-riset'
                        var id_nameList = 'listPBPdR'
                        appendList(aspek, response, i, id_namePanel, id_nameList )

                break;
                case "Konektifitas Sekolah":
                    var id_namePanel = 'aspek-konektifitas-sekolah'
                    var id_nameList = 'listKS'
                    appendList(aspek, response, i, id_namePanel, id_nameList )
                break;
            }
        }
      }else{
        $("#buttonSubmit").append(
            '<button style="margin-top:10px;float:right" class="btn btn-purple waves-effect waves-light" onclick="createFormat("")">Submit</button>'
        )
        document.getElementById('firstMessage').style.display = "block"
        document.getElementById('createFormat1').style.display = "none"
        document.getElementById('createFormat2').style.display = "none"
      }
    })
    .catch(function(err){
        
      console.log(err.response)
      if(err.response.data.message =="Kerangka not found."){
        $("#buttonSubmit").append(
            '<button style="margin-top:10px;float:right" class="btn btn-purple waves-effect waves-light" onclick="createFormat("")">Submit</button>'
        )
        document.getElementById('firstMessage').style.display = "block"
        document.getElementById('createFormat1').style.display = "none"
        document.getElementById('createFormat2').style.display = "none"
      }else{
        swal("Maaf", "Terjadi kesalahan, cek koneksi internet Anda")
      }
    })
}

function appendList(aspek, response, i, id_namePanel, id_nameList ){
    $("#"+id_namePanel).append(
        '<div class="row" id="'+id_nameList+i+'">'+
        '<div class="col-md-11">'+
        '<p>'+response.data.data.kerangka[i].poin+'</p>'+
        '<input type="text" name="aspek" style="display:none" value="'+aspek+'"></input>'+
        '<input type="text" name="inputFormatKerangka"  style="display:none" value="'+response.data.data.kerangka[i].poin+'"></input>'+
        '</div>'+
        '<div class="col-md-1">'+
        '<span style="text-align:right;cursor:pointer;color:red" onclick=deletelistavailableformat("'+id_nameList+'",'+i+')>x</span>'+
        '</div>'+
        '<div class="col-md-12">'+
        '<hr>'+                        
        '</div>'+
        '</div>'
    )
}

function deletelistavailableformat( id_nameList ,no){
    document.getElementById('deleteButtonClicked').style.display="block"
    var element = document.getElementById(id_nameList+no)
    element.parentNode.removeChild(element);
}

function updateFormat(id){
    var id_rapor = "/"+id
    createFormat(id_rapor)
}

function createFormat(id){
    // Poin Inputan 
    var inputan = ''
    $("input[name='inputFormatKerangka']").each(function(){
        inputan += '{'
        inputan += '"poin" : "'
        inputan += this.value
        inputan += '"}, '
       })
    var inputan2 = JSON.parse('['+inputan.replace(/,\s*$/, "")+']')
    
    // Aspek
    var aspek = ''
    $("input[name='aspek']").each(function(){
        aspek += '{'
        aspek += '"aspek" : "'
        aspek += this.value
        aspek += '"}, '
       })
    var aspek2 = JSON.parse('['+aspek.replace(/,\s*$/, "")+']')
    var length = aspek2.length
    var kerangka = ''
    for(var i= 0;i<length;i++){
        kerangka += '{'
        kerangka += '"aspek" : "'
        kerangka += aspek2[i].aspek
        kerangka += '", "poin" : "'
        kerangka += inputan2[i].poin
        kerangka += '"}'
        if(i == length-1){
            kerangka += ''
        }else{
            kerangka += ','
        }
    }
    var kerangka2 = JSON.parse('['+kerangka.replace(/,\s*$/, "")+']')
    console.log(kerangka2)
    var data = {
        "kerangka" : kerangka2
    }
    console.log(data)
    var token_user = getCookie("token_login_user_gsm")
    var appurl = localStorage.getItem("url_elearning_gsm")
    $.ajax({
        method: "POST",
        url: appurl+"v1/admin/rapor/kerangka"+id,
        data: data,
        headers : {
            "Authorization" : "Bearer "+token_user, 
            "Content-Type" : "application/x-www-form-urlencoded"
        }  
        })
        .done(function (response) {
            //handle success
            console.log(response);
            window.location = 'rapor'
        })
        .fail(function (response) {
            //handle error
            console.log(response);
        });
}

function deleteList(no){
    var element = document.getElementById("listFormat"+no)
    element.parentNode.removeChild(element);
}