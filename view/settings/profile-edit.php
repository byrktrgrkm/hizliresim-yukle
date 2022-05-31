<form method="POST" enctype="multipart/form-data">
<div class="row">
    <div class="col-8">  <h3>PROFİLİ DÜZENLE</h3></div>
    <div class="col-4">
        <button class="btn btn-outline-secondary float-right" type="submit">Kaydet</button>
    </div>
</div>

<p>İnsalar sizi etikresim.com'da bu bilgilerle tanıyacak.</p>

<?php if(isset($messages)): ?>

    <?php foreach($messages as $message): ?>
        <div class="alert alert-<?=$message['class']?>"><?=$message['msg']?></div>
    <?php endforeach; ?>

<?php endif; ?>


<div>
    <img onclick="document.getElementById('avatar').click();" 
    height="50" width="50" 
    src="<?=$data['avatar']?>" class="rounded" alt="...">
    <input type="file"
       id="avatar" name="avatar"
       accept="image/png, image/jpeg" style="display:none;">
       <label for="avatar"><i class="fas fa-user-ninja"></i> Yeni avatarını seç</label>
</div>
<hr>
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="exampleFormControlInput1">İsim</label>
            <input type="text" name="firstname"  value="<?=!empty(post('firstname')) ? post('firstname') :  $data['firstName']?>" class="form-control" id="exampleFormControlInput1" placeholder="">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="exampleFormControlInput1">Soyisim</label>
            <input type="text" name="lastname" value="<?=!empty(post('lastname')) ? post('lastname') : $data['lastName']?>" class="form-control" id="exampleFormControlInput1" placeholder="">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="exampleFormControlInput1">Kullanıcı adı</label>
    <input type="text" name="username" value="<?=!empty(post('username')) ? post('username') :$data['username']?>" class="form-control"  placeholder="">
</div>
<div class="form-group">
    <label for="exampleFormControlInput1">Mail adresi</label>
    <input disabled type="email" name="mail" value="<?=!empty(post('mail')) ? post('mail'):$data['mail']?>" class="form-control disabled" id="exampleFormControlInput1" placeholder="">
</div>

</form>