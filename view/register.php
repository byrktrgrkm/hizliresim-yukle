
<div class="container-fluid my-5">
    
    <h1 class="text-center">Hesap Oluştur</h1>
    <div class="row justify-content-center">
     
        <div class="col-sm-12 col-md-5">

            <?php if(isset($result)):?>

              <?php if(is_array($result)): ?>  
                    
                  <?php foreach($result as $r): ?>

                      <div class="alert alert-<?=$r['class']?>"><?=$r['message']?></div>

                  <?php endforeach; ?>

              <?php else: ?>
                    <div class="alert alert-<?=$result['class']?>"><?=$result['message']?></div>
              <?php endif; ?>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Kullanıcı adı</label>
                    <input type="text" value="<?=post("username")?>" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                    <small class="form-text text-muted">Kullanıcı adı türkçe karakter içeremez.</small>
                  </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email</label>
                  <input type="email" value="<?=post("email")?>" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Şifre</label>
                  <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Şifre tekrar</label>
                    <input type="password" class="form-control" name="password_again" id="exampleInputPassword1" placeholder="Password">
                  </div>
                
                <button type="submit" class="btn btn-block btn-success">Kayıt Ol</button>
                
                <hr>
                <a href='<?=base_url('login')?>'>
                     <button type="button" class="btn btn-outline-dark btn-block">
                    Giriş Yap</button>
                </a>
            </form>
        </div>
    </div>

</div>
