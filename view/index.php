<div class="container-fluid mt-5">

    <div class="row justify-content-center flex-column align-items-center m-auto">

        <?php if(isset($result['status']) && $result['status'] == 'success'): ?>

            <div class="col-sm-10 col-md-6  p-3">
                <div class="d-flex flex-column">
                    <div class="alert alert-success">
                        Bağlantı adresi : <a href="<?=$result["slug_image"]?>"><?=$result["slug_image"]?></a>
                    </div>
                    <div class="img overflow-auto">
                        <img src="<?=$result['share_image']?>" alt="">
                    </div>
                    <div class="alert alert-info">Hızlı erişim</div>
                </div>
            </div>

        <?php endif; ?>


        <div class="col-sm-10 col-md-6 border-dotted p-3">
            <div class="d-flex flex-column">
                <form method="POST" enctype="multipart/form-data">

                    <?php if(isset($result) && $result['status'] == 'error'): ?>

                            <?php  foreach($result['data'] as $error):?>

                                    <div class="alert alert-<?=$error['class']?>"><?=$error['message']?></div>
                                
                            <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="p-2 bd-highlight text-dark">Bilgisayarda Resim seç</div>
                    <div class="border-select-image p-5">
                        <input id="select-file" name="file[]" type="file" multiple  accept="image/png, image/jpeg" hidden>
                        <label class="select-image" for="select-file">

                            <img src="<?=get_local_image('select-image.png')?>" width="50" height="50" id="mini-image" for="select-file" >
                        </label>
                    </div>
                    <div class="p-2 bd-highlight text-dark">

                        <label for="validationTextarea">Açıklama</label>
                        <textarea name="content" class="form-control" name="explain" id="validationTextarea" placeholder="" ></textarea>
                    </div>

                    <div class="p-2 bd-highlight text-dark">
                            <input type="hidden" name="csrf" value="<?=$csrf_token?>" />
                    </div>
                                
                    <div class="p-2 bd-highlight text-dark">

                        <label for="validationTextarea">Yayın süresi</label>
                        <select name="broadcast">
                            <?php foreach($broadcast_types as $type):?>
                                 <option value="<?=$type['id']?>"><?=$type['name']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="p-2">
                        <label for="checkPass">Dosya erişim şifresi :</label>
                    
                        <label class="switch">
                            <input id="checkPass" name="check" type="checkbox" class="label-file-access" type="checkbox">
                            <span class="slider round"></span>
                        </label>

                        <input type="password" name="password" class="form-control" id="file-password" style="display:none;">
                    
                    </div>

                   

                    

                    <div class="p-2">
                        <input type="submit" class="btn btn-block btn-outline-success " value="Paylaş" />
                    </div>

                </form>
                
            </div>
        </div>

        

        
        
    </div>

</div>

<div class="container-fluid p-5 text-center text-danger">
    <p class="p-5">10MB’a kadar GIF, JPG, JPEG ve PNG türünde dosyalar yüklenebilir. Yetişkin içerikli fotoğraf ve resimler otomatik olarak silinir.</p>
</div>


<hr>

<div class="container-fluid my-5">

    <div class="d-flex flex-column text-center">
        <div class="p-4 bd-highlight text-dark">
            <h3>Bizi diğer sitelerden farklı kılan nedir?</h3>
            <p>Gizli resimler paylaşabilme</p>
            <p>Kayıtlı kullanıcılarımızın resimleri silinmez. 10 MB'a kadar ücretsiz resim upload edebilir ve saklayabilirsiniz.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="<?=get_local_image('yuksek-hiz.png')?>" class="card-img-top" alt="...">
                    <div class="card-body">
                      <h5 class="card-title">Kolay ve Hızlı</h5>
                      <p class="card-text">Kolay ve Hızlıİstediğiniz resmi seçin ve tek tıklama ile kolay ve hızlı yükleyin.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="<?=get_local_image('gelismis-ozellik.png')?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Gelişmiş Paylaşım</h5>
                      <p class="card-text">E-posta, forum ve facebook, twitter, instagram vb. sosyal medyalarda paylaşın.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="<?=get_local_image('cloud-store.png')?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Depolama</h5>
                      <p class="card-text">Resimleri istediğiniz sürece depolayın veya video yükleyin.</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card" style="width: 18rem;">
                    <img src="<?=get_local_image('password.png')?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Şifreleme</h5>
                      <p class="card-text">Resimleri istediğiniz gibi şifreleyin,yalnızca paylaştıklarınız erişebilsin.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<?php if(isset($result['status']) && $result['status'] == 'success'): ?>
<!-- Modal -->

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imageModal">
  Launch demo modal
</button>
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Bağlantınızı Paylaşınız.</h5>
        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="alert alert-success">
                        Bağlantı adresi : <a href="<?=$result["slug_image"]?>">Bağlantıyı görüntüle</a>
        </div>
        <div>
        <img src="<?=$result['share_image']?>" height="200"/>
        </div>
        <hr/>
        <?php foreach($result['list']  as $item): ?>
            <img src="<?=$item?>" width="50" height="50"/>
        <?php endforeach; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
        <button type="button" class="btn btn-primary" onclick="copyToClipboard(this,'<?=$result["slug_image"]?>')">Link Kopyala</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<script type="text/javascript">

function copyToClipboard(e,text) {
        var inputc = document.body.appendChild(document.createElement("input"));
        inputc.value = text;
        inputc.focus();
        inputc.select();
        document.execCommand('copy');
        inputc.parentNode.removeChild(inputc);
        console.log(inputc);
        
        // badge
        var badge = document.createElement('span');
        badge.classList = 'badge badge-success';
        badge.textContent = 'Kopyalandı.';

        e.appendChild(badge);
        setTimeout(function(){
            e.removeChild(badge);
        },3000);

    }


    

    window.addEventListener('load',function(){

        $("#imageModal").modal();

        $("#select-file").on('change',function(e){

            $file = e.target.files[0];

            $types = ["image/png","image/jpeg","image/jpg"];
            
            $max = 1024 * 1024 * 10;

            if(! $types.includes($file.type)){
                alert('Dosya adı '+($types.join(',')+' olabilir.'));
                e.target.files = null;    
            }else if($file.size > $max){
                alert('Dosya boyutu 10 mb\'dan büyük olamaz');
                e.target.files = null;
            }else{

                const img = document.createElement("img");
                    img.src = URL.createObjectURL($file);
                    img.height = 60;
                    img.onload = function() {
                        $("#mini-image")[0].src = img.src;
                        URL.revokeObjectURL(img.src);
                        
                    }
                

            }
        });

    },false);



</script>