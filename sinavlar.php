<?php
require_once("apis/Ogrenci/Ogrenci.php");
require_once("config_require_login.php");
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
        <div class="row">
            <div class="col-md-12">
                <input type="text" v-model="search" placeholder=" Arama yap">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12 table-responsive p-0">
                <table class="table table-hover p-0" style="font-size: 14px">
                    <thead>
                        <tr>
                            <th>Sınav Adı</th>
                            <th>Sınıf</th>
                            <th>Baslangıç</th>
                            <th>Bitiş</th>
                            <th>Sınav İşlemleri</th>
                        </tr>
                    </thead>
                    <tbody v-for="item in filteredItems">
                        <tr>
                            <td>{{ item.SINAVADI }}</td>
                            <td>{{ item.SINIFSEVIYESI }}</td>
                            <td>{{ item.BASLANGICTARIHI}}</td>
                            <td>{{ item.BITISTARIHI}}</td>
                            <td>
                                <button v-on:click="sinaviBaslat(item)" class="btn btn-light btn-sm m-1">Başlat</button>
                                <button v-on:click="sinavSonucu(item)" class="btn btn-light btn-sm m-1">Sonuç</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
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
        
        
        var app = new Vue({
            el: '#app',
            data: {
                message: "mesajim burada",
                sinavlar: [],
                search: ''
            },

            computed:{
                filteredItems: function(){
                    return this.sinavlar.filter(item => {
                        if (item.SINAVADI.toLowerCase().match(this.search.toLowerCase())){
                            return item;
                        }
                        if(item.SINIFSEVIYESI.toLowerCase().match(this.search.toLowerCase())){
                            return item;
                        }
                    });
                }
            },

            methods: {
                sinaviBaslat: function(item){
                    if(item.DURUM === "0"){
                        alert("Sınav Hazirlanma aşamasında.");
                    }else if(item.DURUM === "1"){
                        alert("Sınav aktif değil.");
                    }else if(item.DURUM === "2"){
                        //alert("Sınav baslatiliyor..");
                        axios.post("apis/Sinav/SinavSecimi.php",{
                            sinavID: item.ID
                        }).then(function (response){
                            //alert(response.data.message);
                            if(response.data.message === "START" || response.data.message === "RECONNECT"){
                                alert(item.ACIKLAMA)
                                window.location.replace("quiz_app.php");
                            }
                            else if(response.data.message === "RUN_OUT_OF_TIME"){
                                alert("Sınav süreniz bitmiştir.");
                            }
                            else if(response.data.message === "FINISED"){
                                alert("Sınavı tamamladınız. Tekrar giriş yapamazsınız.");
                            }
                            else{
                                alert("Sınavı tamamladınız. Tekrar giriş yapamazsınız.");
                            }
                        }).catch(function (error){
                           console.log(error); 
                        });
                        
                    }else if(item.DURUM === "3"){
                        alert("Sınav süresi bitmiştir.");
                    }else if(item.DURUM === "4"){
                        alert("Sınav süresi tamamlandı. Sonuçlarınıza bakabilirsiniz.");
                    }
                },
                sinavSonucu: function(item){
                    alert(item.BASLANGICTARIHI);
                },
                sinavYonergesi: function(item){
                    alert(item.ACIKLAMA);
                }
                
            },
            
            created: function(){
                var vm = this;
                axios.get("apis/Sinav/SinavList.php")
                        .then(function (response) {
                            vm.sinavlar = response.data;
                        })
                        .catch(function (error){
                           window.location.replace("index.php");
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
        

    </script>
    <noscript>
        Tarayıcınız javascript desteklemiyor. 
        Lütfen javascript'i aktif hale getirin.
        Yada başka bir cihazdan giriş yapın.
    </noscript>

</body>
</html>