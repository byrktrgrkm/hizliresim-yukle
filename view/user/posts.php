


<div class="row justify-content-around m-3">


<?php if(isset($messages)): ?>

<?php foreach($messages as $message): ?>
    <div class="alert alert-<?=$message['class']?>"><?=$message['msg']?></div>
<?php endforeach; ?>

<?php endif; ?>


<?php if(isset($data['posts'])): ?>
                <?php foreach($data['posts'] as $post): ?>
                  
                  <div class="col-12 col-sm-6 col-md-6 col-lg-3 card m-3">
                     <?php if($post['isPass'] == 1): ?>
                      <div class="text-center">
                        <i class="fas fa-key"></i>
                     </div>
                      <?php endif; ?>
                     <a href="<?=base_url($post['slug'])?>">
                      <img class="card-img-top mt-3" height="150" src="<?=$post['image']?>" alt="Card image cap">
                      </a>
                      <div class="card-body">
                        <p class="card-text"><?=$post['content']?></p>
                      </div>
                      <div class="card-footer text-center">
                        <span class="pr-1">
                            <i class="fas fa-heartbeat"></i>
                            <?=$post['likes_count']?>
                        </span>

                        <span class="pr-1">
                            <i class="far fa-comment"></i> 
                            <?=$post['comment_count']?>
                        </span>
                        <hr>
                        <div class="py-1 text-center">
                            <span>
                                <i class="far fa-clock"></i>
                                <small class="text-muted"><?=$post['share_date']?></small>
                            </span>    
                        </div>
                        
                      </div>
                    </div>

                <?php endforeach; ?>

<?php endif; ?>


</div>