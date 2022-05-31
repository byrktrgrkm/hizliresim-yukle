

<footer style="margin-top:100px;">
    <hr>
    <div class="container">
        <div class="row">
            <div class="col text-uppercase">etikresim.com</div>
            <div class="col">
                <nav class="d-flex flex-column">
                    <a href="<?=base_url('static/gizlilik-politikasi')?>">Gizlilik Politikası</a>
                    <a href="<?=base_url('static/kotuye-kullanim')?>">Kötüye Kullanım</a>
                    <a href="<?=base_url('static/iletisim')?>">İletişim</a>
                    <a href="<?=base_url('static/yardim')?>">Yardım</a>
                </nav>
            </div>
            <?php if(!session("oturum")): ?>
            <div class="col"> 
                <a href='<?=base_url('register')?>'><button type="button" class="btn px-5 btn-outline-info float-right mx-5 my-1 border-rounded">Kayıt Ol</button></a>
            
            </div>

            <?php endif; ?>
        </div>
        <hr>
        <div class="row my-2">
            <div class="col">
                Copyright © 2020 etikresim.com
            </div>
        </div>

       
    </div>
</footer>
    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    --><script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        $("#checkPass").on('change',function(e){
            
            if(this.checked) $("#file-password").show();
            else $("#file-password").hide();
            
        });
    </script>
</body>
</html>