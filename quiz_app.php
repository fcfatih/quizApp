<?php
require_once("apis/Tools/validation.php");
require_once("apis/Tools/timeTools.php");
require_once("apis/Ogrenci/Ogrenci.php");
require_once("apis/Ogrenci/OgrenciSinavSure.php");
require_once("apis/Sinav/Sinav.php");

//require_once("config_require_login.php");

//echo("<pre>");
//var_dump($_SESSION);
//echo("</pre>");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <?php
        require_once("head.php");
    ?>
</head>
<body>
    <?php
        require_once("navigation.php");
    ?>
    <br>



    <div class="container" id="app">
        
        <!-- ---------------------------Select Ders section--------------------- -->
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group form-inline form-group-sm">
                    <label>Seçili Ders:  </label>
                    <select v-model="seciliDers" class="form-control form-control-sm" @change="eventDersSecimi($event)">
                        <option disabled value=""> Lütfen bir ders seçiniz </option>
                        <option v-for="item in sinav" v-bind:value="item">
                            {{ item.dersAdi }}
                        </option>
                    </select>
                </div>  
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-4 text-center">
                Kalan Süre: {{hours}} : {{minutes}} : {{seconds}}
            </div>
        </div>
        <!-- ----------------------Select Ders section END----------------------- -->
        
        
            <!-- ----------------------------Quiz question section---------------------------- -->
        <div class="row text-center">
            <div class="col-md-12">
                <img v-bind:src="aktifSoru.soruImg.src"></img>
            </div>
        </div>
        <!-- ----------------------------Quiz question section END------------------------ -->
        
        <hr>
        <div class="row">
            <div class="col-md-12 text-center">
                <h6>Cevabınız: </h6>
                <button type="button" v-on:click="cevapla(cevapButtons[0])" v-bind:class="cevapButtons[0].sitil">A</button>
                <button type="button" v-on:click="cevapla(cevapButtons[1])" v-bind:class="cevapButtons[1].sitil">B</button>
                <button type="button" v-on:click="cevapla(cevapButtons[2])" v-bind:class="cevapButtons[2].sitil">C</button>
                <button type="button" v-on:click="cevapla(cevapButtons[3])" v-bind:class="cevapButtons[3].sitil">D</button>
                <button type="button" v-on:click="cevapla(cevapButtons[4])" v-bind:class="cevapButtons[4].sitil">E</button>
            </div>
        </div>
        
        <hr>
        <div class="row text-center">
            <div class="col-md-2"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-sm">Önceki</button>
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-primary btn-sm">Kaydet</button>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-sm">Sonraki</button>
            </div>
            <div class="col-md-2"></div>
        </div>
        
        <hr>
        <div class="row text-center">
            <div class="col-sm-12">
                <button type="button" v-on:click="sinaviBitir" class="btn btn-danger btn-sm">Sınavı Bitir</button>
            </div>
        </div>
        
        <div class="row">
            <h6>Derse ait sorular:</h6>
            <div class="col-sm-12">
                <button v-for="item in seciliDers.sorular" v-bind:class="item.sitil">
                        {{ item.index }}
                </button>
            </div>
        </div>
        <hr>
        <br>
        <br>
        <!--<button v-on:click="degistir">degistir</button>-->
    </div>
    
    

   

    <script type="application/javascript">
        var supportsES6 = function() {
            try {
              new Function("(a = 0) => a")
              return true;
            }
            catch (err) {
              return false;
            }
        }()
        
        if (!supportsES6) {
            alert('Tarayıcınız ES6\'yı desteklemiyor')
            window.location.href('err_browser_not_supported.php');
        }
        
        window.onbeforeunload = function () {
            return 'Sayfadan ayrılırsanız bilgileriniz kaydedilmeyecektir';
        };
        
        
        var app = new Vue({
            el: '#app',
            data: {
                message: "mesajim burada",
                sinav: [],
                seciliDers: 0,
                aktifSoru: {soruImg: new Image(), soruID: "", kullaniciCevabi: null, sitil: ""},
                hours: 0,
                minutes: 0,
                seconds: 0,
                cevapButtons: [
                    {sitil: "btn btn-outline-primary btn-md", cevap: "A"},
                    {sitil: "btn btn-outline-primary btn-md", cevap: "B"},
                    {sitil: "btn btn-outline-primary btn-md", cevap: "C"},
                    {sitil: "btn btn-outline-primary btn-md", cevap: "D"},
                    {sitil: "btn btn-outline-primary btn-md", cevap: "E"}
                ]
            },

            computed:{
                
            },

            methods: {
                saatiBaslat: function(){
                    this.saat.setSeconds(this.saat.getSeconds() - 1);

                    this.hours = this.saat.getHours();
                    this.minutes = this.saat.getMinutes();
                    this.seconds = this.saat.getSeconds();

                    if(this.hours === 0 && this.minutes === 0 && this.seconds === 0){
                        alert("Sınav süreniz bitmiştir.");
                        this.sinaviBitir();
                    }
                },
                sinaviBitir: function(){
                    axios.get('apis/Sinav/SinavBitir.php')
                    .then(function (response) {
                        if(response.data.message == "FINISHED"){
                            window.location.replace("/");
                        }
                    })
                    .catch(function (error) {
                        //window.location.replace("/giris");
                        alert(error);
                    });
                    
                },
                cevapla: function(item){
                    if(item.sitil === "btn btn-outline-primary btn-md"){
                        item.sitil = "btn btn-primary btn-md";
                        this.aktifSoru.kullaniciCevabi = item.cevap;
                    }
                    else{
                        item.sitil = "btn btn-outline-primary btn-md";
                        this.aktifSoru.kullaniciCevabi = null;
                    }
                    
                    this.cevapButtons.forEach(function(loop_item){
                        if(loop_item.cevap !== item.cevap){
                            loop_item.sitil = "btn btn-outline-primary btn-md";
                        }
                    });
                },
                kaydet: function(){
                   alert(this.aktifSoru.soruID);
                },
                degistir: function(){
                    this.seciliDers.sorular[3].sitil = "btn btn-primary btn-sm";
                },
                eventDersSecimi: function(event){
                    this.aktifSoru.soruID = this.seciliDers.sorular[this.seciliDers.sonAktifSoruIndex].soruID;
                    this.aktifSoru.soruImg.src = this.seciliDers.sorular[this.seciliDers.sonAktifSoruIndex].soruIMG;
                    this.aktifSoru.kullaniciCevabi = this.seciliDers.sorular[this.seciliDers.sonAktifSoruIndex].kullaniciCevabi;
                    this.aktifSoru.sitil = this.seciliDers.sorular[this.seciliDers.sonAktifSoruIndex].sitil;
                }
            },
            
            created: function(){
                var vm = this;
                
                axios.get('apis/Sinav/SinavOlustur.php')
                .then(function (response) {
                    vm.sinav = response.data;
                    axios.get('apis/Sinav/getSinavKalanSure.php')
                    .then(function (response) {
                        vm.saat = new Date();
                        vm.hours = response.data.hours;
                        vm.minutes = response.data.minutes;
                        vm.seconds = response.data.seconds;
                        vm.saat.setHours(vm.hours);
                        vm.saat.setMinutes(vm.minutes);
                        vm.saat.setSeconds(vm.seconds);
                    })
                    .catch(function (error) {
                        //window.location.replace("/giris");
                        alert(error);
                    });
                    //kullaniciyi ilk ders ilk soru karsilar
                    vm.seciliDers = vm.sinav[0];
                    vm.aktifSoru.soruID = vm.seciliDers.sorular[vm.seciliDers.sonAktifSoruIndex].soruID;
                    vm.aktifSoru.soruImg.src = vm.seciliDers.sorular[vm.seciliDers.sonAktifSoruIndex].soruIMG;
                    vm.aktifSoru.kullaniciCevabi = vm.seciliDers.sorular[vm.seciliDers.sonAktifSoruIndex].kullaniciCevabi;
                    vm.aktifSoru.sitil = vm.seciliDers.sorular[vm.seciliDers.sonAktifSoruIndex].sitil;
                })
                .catch(function (error) {
                    //window.location.replace("/giris");
                    alert(error);
                });
                
            },
            beforeDestroy () {
                //son durumu sunucuya ilet.
                //sorular resim olarak geliyor.
                //404 hatasi alirsam, sayfayi yenileyebilir.
                //son durumu sunucuya aktarmam gerekir.
                //ya da sunucu tarafinda surekli kayit tutmam ve ders yuklemelerinin ona gore yapilmasi
	    },
        });
        
        var zamanlayici = setInterval(app.saatiBaslat, 1000);
        
    </script>
    <noscript>
        Tarayıcınız javascript desteklemiyor. 
        Lütfen javascript'i aktif hale getirin.
        Yada başka bir cihazdan giriş yapın.
    </noscript>

</body>
</html>