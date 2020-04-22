<?php



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
        
        <div class="row text-center">
            <img src="assets/mudur_bey.jpg">
        </div>
        <hr>
        <div class="row text-center">
            <div class="col-lg-4"></div>
            <div class="col-lg-4 text-center">
                "Aydın İl Milli Eğitim Müdürlüğü"
                <br>
                "Fatih Projesi İl Korrdinatörlüğü"
            </div>
            <div class="col-lg-4"></div>
        </div>
        <br>
        <br>
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
            },

            computed:{
                
            },

            methods: {
                
            },
            
            created: function(){
                
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