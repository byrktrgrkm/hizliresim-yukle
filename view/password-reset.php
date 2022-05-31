
<div class="container-fluid my-5">
    
    <h1 class="text-center">Şifremi Unuttum</h1>
    <div class="row justify-content-center m-5">

    
        <div class="col-5">
         <?php if(isset($result)):?>

            <?php if(is_array($result)): ?>  
                
                <?php foreach($result as $r): ?>

                    <div class="alert alert-<?=$r['class']?>"><?=$r['message']?></div>

                <?php endforeach; ?>

            <?php else: ?>
                <div class="alert alert-<?=$result['class']?>"><?=$result['message']?></div>
            <?php endif; ?>
            <?php endif; ?>
            

            <form method="POST" action="<?=base_url('password-reset')?>">
                <div class="form-group">
                  <label for="exampleInputEmail1">Email adresiniz</label>
                  <input type="text" value="<?=post('email')?>" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                  <small id="emailHelp" class="form-text text-muted"></small>
                </div>
                
                
                <div class="form-check text-right">
                  <a href="<?=base_url('login')?>" class="text-right">Giriş yap</a>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Doğrulama bağlanısı gönder</button>
                
             
            </form>

           
        </div>
    </div>

</div>