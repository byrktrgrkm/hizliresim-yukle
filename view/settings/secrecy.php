<form method="post">
  <div class="row">
      <div class="col-8">  <h3>GİZLİLİK AYARLARI</h3></div>
      <div class="col-4">
          <button class="btn btn-outline-secondary float-right">Kaydet</button>
      </div>
  </div>

  <?php if(isset($messages)): ?>

  <?php foreach($messages as $message): ?>
      <div class="alert alert-<?=$message['class']?>"><?=$message['msg']?></div>
  <?php endforeach; ?>

  <?php endif; ?>



 
 
  <hr>



  <div class="custom-control custom-switch my-3">
    <input type="checkbox" class="custom-control-input" id="swit" name="posts_public_show" <?=($data['property']['posts_public_show'] == 1 ? 'checked' :'')?>>
    <label class="custom-control-label" for="swit">Paylaşımlarımı herkes görüntüleyebilir.</label>
  </div>

  <div class="custom-control custom-switch my-3">
    <input type="checkbox" class="custom-control-input" id="switch" name="picture_public_show" <?=($data['property']['picture_public_show'] == 1 ? 'checked' :'')?>>
    <label class="custom-control-label" for="switch">Profil fotoğrafımı herkes görüntüleyebilir.</label>
  </div>
  <div class="custom-control custom-switch my-3">
    <input type="checkbox" class="custom-control-input" id="switch1" name="comment_public_show" <?=($data['property']['comment_public_show'] == 1 ? 'checked' :'')?>>
    <label class="custom-control-label" for="switch1">Yorumlarımı herkes görüntüleyebilir.</label>
  </div>

  <div class="custom-control custom-switch my-3">
    <input type="checkbox" class="custom-control-input" id="switch2" name="likes_public_show" <?=($data['property']['likes_public_show'] == 1 ? 'checked' :'')?>>
    <label class="custom-control-label" for="switch2">Beğenilerimi herkes görüntüleyebilir<label>
  </div>

  <div class="custom-control custom-switch my-3">
    <input type="checkbox" class="custom-control-input" id="switch3" name="bookmarks_public_show" <?=($data['property']['bookmarks_public_show'] == 1 ? 'checked' :'')?>>
    <label class="custom-control-label" for="switch3">Yer imlerimi herkes görüntüleyebilir</label>
  </div>

  <div class="custom-control custom-switch my-3">
    <input type="checkbox" class="custom-control-input" id="switch4" name="posts_comment_do" <?=($data['property']['posts_comment_do'] == 1 ? 'checked' :'')?>>
    <label class="custom-control-label" for="switch4">Paylaşımlarıma herkes yorum yapabilir.</label>
</div>

</form>