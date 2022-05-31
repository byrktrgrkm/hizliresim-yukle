<form method="POST">
  <div class="row">
      <div class="col-8">  <h3>BİLDİRİMLER</h3></div>
      <div class="col-4">
          <button class="btn btn-outline-secondary float-right" type="submit">Kaydet</button>
      </div>
  </div>




  <?php if(isset($messages)): ?>

  <?php foreach($messages as $message): ?>
      <div class="alert alert-<?=$message['class']?>"><?=$message['msg']?></div>
  <?php endforeach; ?>

  <?php endif; ?>


  <hr>
  <div class="custom-control custom-switch my-3">
    <input type="checkbox" class="custom-control-input" id="switch1" name="get_all_notification" <?=($data['property']['get_all_notification'] == 1 ? 'checked' :'')?> >
    <label class="custom-control-label" for="switch1">Her bildirimleri al</label>
  </div>

  <div class="custom-control custom-switch my-3">
    <input type="checkbox" class="custom-control-input" id="switch2" name="get_mail_important_notification" <?=($data['property']['get_mail_important_notification'] == 1 ? 'checked' :'')?>>
    <label class="custom-control-label" for="switch2">Önemli bildirimler mail adresime gönderilsin.</label>
  </div>
</form>