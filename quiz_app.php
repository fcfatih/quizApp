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
                
                    <img src="soruIMG/s1fen2.jpg"></img>
                
            </div>
        </div>
        <!-- ----------------------------Quiz question section END------------------------ -->
        
        <hr>
        <div class="row">
            <div class="col-md-12 text-center">
                <h6>Cevabınız: </h6>
                <button type="button" class="btn btn-outline-primary btn-md">A</button>
                <button type="button" class="btn btn-outline-primary btn-md">B</button>
                <button type="button" class="btn btn-primary btn-md">C</button>
                <button type="button" class="btn btn-outline-primary btn-md">D</button>
                <button type="button" class="btn btn-outline-primary btn-md">E</button>
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
                <button type="button" class="btn btn-danger btn-sm">Sınavı Bitir</button>
            </div>
        </div>
        
        <div class="row">
            <h6>Derse ait sorular:</h6>
            <div class="col-sm-12">
                <button v-for="item in sorular" v-bind:class="classObject(item)">
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
                sinav: [
                    {dersAdi : "Türkçe"},
                    {dersAdi : "Matematik"},
                    {dersAdi : "Fen Bilgisi"},
                    {dersAdi : "Sosyal Bilgiler"}
                ],
                seciliDers: "",
                hours: "01",
                minutes: "02",
                seconds: "03",
                sorular: [
                    {index: 1, sitil: "btn btn-success btn-sm"},
                    {index: 2, sitil: "btn btn-success btn-sm"},
                    {index: 3, sitil: "btn btn-secondary btn-sm"},
                    {index: 4, sitil: "btn btn-success btn-sm"},
                    {index: 5, sitil: "btn btn-secondary btn-sm"},
                    {index: 6, sitil: "btn btn-success btn-sm"},
                    {index: 7, sitil: "btn btn-success btn-sm"},
                    {index: 8, sitil: "btn btn-primary btn-sm"}
                ]
            },

            computed:{
                
            },

            methods: {
               classObject: function(item){
                   return item.sitil;
                },
                degistir: function(){
                    this.sorular[1].sitil = "btn btn-secondary btn-sm";
                },
                eventDersSecimi: function(event){
                    alert(this.seciliDers.dersAdi);
                }
            },
            
            created: function(){
                //sorulari cek
                //then
                //sinav kalan sureyi cek
                //then
                //sinavin ilk dersinin ilk sorusunu hazirla
                this.seciliDers = this.sinav[0];
            },
            beforeDestroy () {
                //son durumu sunucuya ilet.
                //sorular resim olarak geliyor.
                //404 hatasi alirsam, sayfayi yenileyebilir.
                //son durumu sunucuya aktarmam gerekir.
                //ya da sunucu tarafinda surekli kayit tutmam ve ders yuklemelerinin ona gore yapilmasi
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