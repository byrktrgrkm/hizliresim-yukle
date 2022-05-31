<form method="POST">
<div class="row">
    <div class="col-8">  <h3>HESAP AYARLARI</h3></div>
    <div class="col-4">
        <button class="btn btn-outline-secondary float-right" type="submit">Kaydet</button>
    </div>
</div>

<p>Şifrenizi değiştirebilirsiniz</p>


<?php if(isset($messages)): ?>

<?php foreach($messages as $message): ?>
    <div class="alert alert-<?=$message['class']?>"><?=$message['msg']?></div>
<?php endforeach; ?>

<?php endif; ?>




<div class="form-group">
    <label for="exampleFormControlInput1">Şifreniz</label>
    <input type="password" name="current_password" value="" class="form-control"  placeholder="">
</div>

<small>Yeni şifreniz en az 6 karakter en fazla 20 karakter uzunlukta olabilir.</small>

<div class="form-group">
    <label for="pass">Yeni şifreniz</label>
    <input type="password" name="password" value="" class="form-control " id="pass" placeholder="">
</div>
<div class="form-group">
    <label for="pass2">Yeni şifreniz tekrar</label>
    <input type="password" name="password2" value="" class="form-control " id="pass2" placeholder="">
</div>


</form>


<div class="divider my-5"></div>

<p>Hesabınızı silenebilir,dondurabilirsiniz.</p>
<hr>
<div class="row">

    <div class="col-7">
        Hesabınızı bir sonraki girişe kadar dondurabilirsiniz.
    </div>
    <div class="col-5">
        <button class="btn btn-outline-danger">Hesabımı Dondur!</button>
    </div>
</div>





<hr>
<div class="row mt-5">
    <div class="col-8">
        Hesabınızı silebilirsiniz,unutmayın tüm verileriniz silenecek ve geri alınamayacaktır.
    </div>
    <div class="col-4 ">
        <button class="btn btn-danger">Hesabımı Sil</button>
    </div>
</div>
<hr>


