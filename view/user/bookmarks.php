<div class="row justify-content-around m-3">
                
<?php if(isset($messages)): ?>

<?php foreach($messages as $message): ?>
    <div class="alert alert-<?=$message['class']?>"><?=$message['msg']?></div>
<?php endforeach; ?>

<?php endif; ?>
                
<?php if(isset($data['posts'])): ?>

     
                <?php foreach($data['posts'] as $post): ?>

                <div class="col-12 col-sm-6 col-md-6 col-lg-3 card m-3">
                    <div class="pt-3">
                        <div class="row align-items-center">
                            <div class="col-2">
                                <img class="" height="30" width="30" src="<?=$post['avatar']?>" alt="">
                            </div>
                            <div class="col">
                                <small><a href=""><?=$post['name']?></a></small>
                            </div>
                        </div>
                    </div>
                    <a href="<?=base_url($post['slug'])?>">
                    <img class="card-img-top mt-3" src="<?=$post['image']?>" alt="Card image cap">
                     </a>
                    <div class="card-body">
                      <p class="card-text"><?=$post['content']?></p>
                    </div>
                    <div class="card-footer text-center">
                      <span class="pr-1">
                          <i class="fas fa-heartbeat"></i>
                          <?=$post['total_like']?>
                      </span>

                      <span class="pr-1">
                          <i class="far fa-comment"></i> 
                          <?=$post['total_comment']?>
                      </span>
                      <hr>
                      <div class="py-1 text-center">
                          <span>
                              <i class="far fa-clock"></i>
                              <small class="text-muted"><?=$post['date']?></small>
                          </span>    
                      </div>
                      
                    </div>
                  </div>

                  <?php endforeach; ?>

<?php endif; ?>

</div>