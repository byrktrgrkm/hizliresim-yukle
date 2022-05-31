<style>
                    blockquote{
                        box-shadow: 0 0 6px rgba(0,0,0,0.5);
                        padding:8px;
                        word-break:break-word;
                    }
                    blockquote::before{
                        
                    display: block;
                    height: 0;
                    content: "“";
                    margin-left: -.95em;
                    font: italic 400%/1 Cochin,Georgia,"Times New Roman", serif;
                    color: #999;
                        
                    }


                    .customimage{
                        background-position: center;
                        background-attachment: scroll;
                        background-origin: border-box;
                        width: 80%;
                        height: 80%;
                    }

              
                    
                </style>
                   
     


<div class="row flex-column justify-content-around m-3">

<?php if(isset($messages)): ?>

<?php foreach($messages as $message): ?>
    <div class="alert alert-<?=$message['class']?>"><?=$message['msg']?></div>
<?php endforeach; ?>

<?php endif; ?>
                


                
<?php if(isset($data['posts'])): ?>

     
<?php foreach($data['posts'] as $post): ?>
                   <div class="col my-1">
                       
                       <div class="row align-items-center justify-content-center">
                           <div class="col-5 col-md-3" style="overflow:hidden;">
                               <div class="">
                                   <img height="30" width="30" src="<?=$post[0]['avatar']?>">
                                   <?=$post[0]['name']?>
                               </div>
                               <a href="<?=base_url($post[0]['slug'])?>">
                                    <img class="customimage mt-3" style="overflow:hidden" src="<?=$post[0]['image']?>">
                                </a>
                            </div>
                           <div class="col-5 m-3 p-3">

                                <blockquote>
                                   <?=$post[0]['content']?>
                               </blockquote>
                               <?php
                                    unset($post[0]);
                                    foreach($post as $comment):
                               ?>
                                <blockquote>
                                   <?=$comment['content']?>
                               </blockquote>

                                    <?php endforeach; ?>
           
                           </div>
                           
                       </div>
                       <hr>
                   </div>  


                   <?php endforeach; ?>

<?php endif; ?>

                    
                  
</div>