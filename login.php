<?php
require_once("config_normal.php");
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Aydın İl Milli Eğitim Müdürlüğü</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="assets/vuejs/vue.js"></script>
    <script src="assets/axios/axios.min.js"></script>
    
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <script src="assets/bootstrap/js/jquery-3.3.1.slim.min.js"></script>
    <script src="assets/bootstrap/js/popper.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>


</head>
<body>

    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="http://www.meb.gov.tr/">MEB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Ana Sayfa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/sinavlar">Sınavlar</a>
            </li>  
            <li class="nav-item">
                <a class="nav-link" href="/login">Giriş</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/logout">Çıkış</a>
            </li>  
            </ul>
        </div>  
    </nav>
    <br>



    <div class="container" id="app">
        
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="alert alert-success">
                    {{message.message}}
                </div>
                <br>
                <div class="form-group form-group-sm">
                    <label for="ilce">İlçeniz:</label>
                    <select v-model="seciliIlce" class="form-control" @change="onChangeIlce($event)">
                        <option disabled value="0"> Lütfen ilçenizi seçiniz </option>
                        <option v-for="item in ilceler" :value="item">
                            {{ item.ilceAdi }}
                        </option>
                    </select>
                </div>
                <div class="form-group form-group-sm">
                    <label for="ilce">Okul Kademeniz:</label>
                    <select v-model="seciliOkulTuru" class="form-control" @change="onChangeOkulTuru($event)">
                        <option disabled value="0"> Lütfen ilçenizi seçiniz </option>
                        <option v-for="item in okulTuru" :value="item">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group form-group-sm">
                    <label for="okul">Okulunuz:</label>
                    <select v-model="seciliOkul" class="form-control" @change="onChangeOkul($event)">
                        <option disabled value="0"> Lütfen okulunuzu seçiniz </option>
                        <option v-for="item in okullar" :value="item">
                            {{ item.kurumAdi }}
                        </option>
                    </select>
                </div>  
                <div class="form-group">
                    <label for="uname">Okul Numaranız:</label>
                    <input type="text" class="form-control" v-model="ogrencino" placeholder="Kullanıcı Adınız" name="username" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Şifreniz:</label>
                    <input type="password" class="form-control" v-model="password" placeholder="Şifreniz" name="password" required>
                </div>
                <button v-on:click="giris" class="btn btn-primary">Giriş yap</button>
            </div>
            <div class="col-md-3"></div>
        </div>

        <br>
        <br>

    </div>

    

   

    <script type="application/javascript">
        

        var app = new Vue({
            el: '#app',
            data: {
                message: {"message": "Lütfen tüm alanları doldurunuz."},
                seciliOkul: "",
                seciliIlce: "",
                ilceler: [],
                okullar: [],
                okulTuru: [{"name":"İlkokul","v":1},{"name":"Ortaokul","v":2},{"name":"Lise","v":3,}],
                seciliOkulTuru: "1",
                isauth: false,
                ogrencino: "",
                password: ""
            },

            computed:{
            },

            methods: {
                onChangeIlce: function(e){
                    this.seciliOkul = "";
                },
                onChangeOkulTuru: function(e){
                    console.log(this.seciliOkulTuru);
                    var vm = this;
                    axios.post('apis/Kurumlar/KurumlarList.php',{
                        ilceID: vm.seciliIlce.ilceID,
                        tur: vm.seciliOkulTuru.v 
                    })
                    .then(function (response) {
                        vm.okullar = response.data;
                    })
                    .catch(function (error) {
                        window.location.replace("/");
                    });
                },
                onChangeOkul: function(e){
                    console.log(this.seciliOkul);
                },
                giris: function(){
                    var vm = this;
                    axios.post('apis/Ogrenci/OgrenciLogin.php',{
                        kurumKodu: vm.seciliOkul.kurumKodu,
                        ogrenciNo: vm.ogrencino,
                        password:  vm.password
                    })
                    .then(function (response) {
                        vm.message = response.data.message;
                        if(vm.message === "Logged"){
                            window.location.replace("sinavlar.php");
                        }
                    })
                    .catch(function (error) {
                        window.location.replace("/");
                    });
                }
            },
            
            created: function(){
                var vm = this;
                axios.get('apis/Ilceler/IlcelerList.php')
                .then(function (response) {
                    vm.ilceler = response.data;
                })
                .catch(function (error) {
                    window.location.replace("index.php");
                });
            },
            beforeDestroy () {
            },
        });

    </script>
    <noscript>
        Tarayıcınız javascript desteklemiyor. 
        Lütfen javascript'i aktif hale getirin.
        Yada başka bir cihazdan giriş yapın.
    </noscript>

</body>
</html>