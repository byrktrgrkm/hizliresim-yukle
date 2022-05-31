
<div class="container-fluid my-5">
    
    <h1 class="text-center">ÜYE GİRİŞİ</h1>
    <div class="row justify-content-center m-5">

    
        <div class="col-5">
            <?php if(isset($result)): ?>
                <div class="alert alert-<?=$result['class']?>"><?=$result['message']?></div>

            <?php endif; ?>
            <?php if( !isset($result) || (isset($result) && $result['class'] != 'success')): ?>

            <form method="POST">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email ya da kullanıcı adı</label>
                  <input type="text" value="<?=post('email')?>" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                  <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Şifre</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-check text-right">
                  <a href="<?=base_url('password-reset')?>" class="text-right">Şifremi unuttum</a>
                </div>
                <button type="submit" class="btn btn-block btn-primary">
                    Giriş Yap</button>
                
                <hr>
               
                    <a href='<?=base_url('register')?>' >    
                    <button type="button" class="btn btn-outline-dark btn-block">Kayıt Ol</button></a>
            </form>

            <?php endif; ?>
        </div>
    </div>

</div>