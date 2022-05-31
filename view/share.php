


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
        .share-image{
            width:100%;
            max-height: 400px;
            user-select: none;
        }

        .item-user{
            border-bottom:1px solid rgb(175, 166, 166,.5);
        }
        .album{
            margin:10px 0;
            padding:10px 0;
        }
        .album .album-item{
            width:75px;
            height:50px;
            margin:4px;
            display:inline-block;
        }

    </style>



<div class="container p-5">


<div class="row">
    <div class="col">
        <div class="alert alert-info">
            <span class="badge"><?=time_elapsed_string($share['share_date'])?> <span class="badge badge-info p-2" id="post_username"><?=$share['username']?></span> tarafından paylaşıldı</span>
        </div>
        <img class="share-image" id="post_image" src="<?=$share["isPass"] && !$share['is_my_image'] ? get_local_image("/no-image-icon.png") : share_image($share['folder'],$images[0]['image'])?>" alt="">
        
        <?php if( ! $share['isPass'] || $share['is_my_image']): ?>
        <div class="album">
            
            <?php for($i = 1; $i < count($images);$i++): ?>
            <div class="album-item">
                <img width="100" height="75" src="<?=share_image($share['folder'],$images[$i]['image'])?>"></img>
            </div>
            <?php endfor;?>

        </div>

        <?php endif; ?>

        <div id="post_container_istatistik" class="row p-1 border border-primary align-items-center text-secondary mt-3 m-2 <?=($share['isPass'] && !$share['is_my_image'] ? 'd-none' :'')?>">
            <div class="col-2">
                <i class="fa fa-eye" style="font-size:26px;"></i> 
                <span id="post_viewCount"><?=$viewsCount?></span>
            </div>
            <div class="col-2">
                <span id="post_heart" style="cursor:pointer;color:<?=($isLikeChecked) ? 'blue' : 'black'?>">
                    <i class="fa fa-heart" style="font-size:26px;"></i>
                    <span id="post_likesCount"><?=$likesCount?></span>
                </span>
             </div>
            <div class="col-2">
                <span id="post_bookmark" style="cursor:pointer;color:<?=($isBookChecked) ? 'green' : 'black'?>">
                    <i class="fa fa-bookmark" style="font-size:26px;"></i>
                    <span id="post_bookmarkCount"><?=$bookmarksCount?></span>
                </span>
             </div>
            <div class="col-auto ml-auto px-4 py-1">
                <input type="hidden" value="<?=$share['id']?>">
                <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#RaporModal">
                    Bildir
                </button>
            </div>
        </div>
     
    </div>
    <div class="col">
        <h3>Not:</h3>

        <div class="m-3" id="post_content">
            
            <?php if($share['isPass'] && !$share['is_my_image']): ?>
                <div class="alert alert-info">İçerik gizli</div>
            <?php elseif($share['content'] == ""): ?>
            <div class="alert alert-danger">Açıklama belirtilmemiş!</div>
            <?php else: ?>
                <?=$share['content']?>
            <?php endif; ?>

        </div>

        <hr>


        <h5>Yorumlar  <span class="badge badge-info" id="post_totalComment"><?=$comments['totalCount']?></span></h5>
        <hr>
        <div class="col item-user">
            <div class="row">
                <div class="col-2 text-center ">
                    <img src="<?=get_local_image("resize/ninja-default.png")?>" alt="">
                </div>
                <div class="col-10">
                    <input type="hidden" name="csrftoken" value="<?=$token['csrftoken']?>">
                    <div class="user-name">
                    <b><?=session('oturum') ? ucFirst(session('user')['username']) : 'Anonim'?></b>
                    </div>
                    <div class="user-comment"><textarea name="" class="form-control" id="user-comment"></textarea></div>
                    <div class="user-button p-1 float-right"><button class="btn btn-inline btn-outline-success" placeholder="Birşeyler yazınızz.." id="sendComment">Gönder</button></div>
                </div>
            </div>
        </div>
        <div class="row flex-column py-5" id="post_comments">

            <?php if($share['isPass'] == 0 || $share['is_my_image']):?>

                <?php if( $comments['totalCount'] == 0): ?>

                    <div class="alert text-small">
                        Yorum bulunamadı, ilk yazan sen ol!
                    </div>
                <?php else: ?>
                    <?php foreach($comments['data'] as $comment):?>
                        <div class="col item-user  p-2 my-1" style="    font-size: 13px;">
                            <div class="row">
                                <div class="col-2 text-center ">
                                    
                                    <!---->
                                    <img src="<?=$comment['avatar']?>" onerror="this.src = '<?=get_local_image('resize/ninja-default.png')?>';"  alt="">
                                </div>
                                <div class="col-10">
                                    <div class="user-name"><b><?=$comment['username']?></b><time class="float-right"><?=$comment['date']?></time></div>
                                    <div class="user-comment text-break"><?=$comment['content']?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>


            <?php endif;?>

        </div>
    </div>
</div>


</div>


<div class="modal fade" id="RaporModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Fotoğrafı bildir!</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body" id="reportBody">
    
      <div class="alert alert-info">
            Uygunsuz bulduğunuz fotoğrafları bizlere bildirin.
      </div>
      <input type="hidden" value="">
      <label for="tip">Türü</label>
      <input type="hidden" name="reportCsrf" value="<?=$token['csrftoken']?>">
      <select name="reportType" id="tip">
        <?php foreach($reportItems as $item): ?>
            <option value="<?=$item['id']?>"><?=$item['name']?></option>
        <?php endforeach; ?>
      </select>
      <textarea id="reportContent" placeholder="Gönderi hakkında daha fazla bilgi verebilirsiniz.." class="form-control" name=""></textarea>
    
      <div class="alert m-3" id="reportStatus">..</div>
    
    </div>
    <div class="modal-footer">
      
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
      <button type="button" class="btn btn-success" id="sendReport">Bildir!</button>
    </div>
  </div>
</div>
</div>



<div class="toast" style="position: fixed; left: 10px; bottom: 10px;"  data-delay="10000">
    <div class="toast-header">
    <i class="fa fa-envelope" style="font-size:26px; padding:6px;"></i> 
    <strong class="mr-auto">Etikresim.com</strong>
    <small class="p-1">az önce</small>
    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="toast-body">
    Hello, world! This is a toast message.
    </div>
</div>




<!-- GİZLİ BELGE! -->

<?php if($share['isPass'] == 1 && !$share['is_my_image']): ?>

<div class="modal fade show" id="passModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gizli Belge</h5>
      </div>
      <div class="modal-body">
            <div class="alert alert-info">Lütfen belgeye erişmek için şifreyi giriniz..</div>
            <div class="form-group row">
                <input type="hidden" name='csrf' value="<?=$token['csrf']?>">
                <label for="inputPassword" class="col-sm-4 col-form-label">Dosya şifresi </label>
                <div class="col-sm-8">
                <input type="password" name='pass' class="form-control" id="inputPassword" placeholder="Şifreyi giriniz!">
                </div>
            </div>

            <div class="alert" id="responseAlert"></div>
      </div>
      <div class="modal-footer">
             <button type="button" class="btn btn-secondary" onclick="location.href = '<?=base_url()?>'">
                Vazgeç
             </button>
            <button type="button" class="btn btn-primary" id="passKontrol">
            Kontrol
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="false" style='display:none;'></span>
             </button>
        
      </div>
    </div>
  </div>
</div>







<script type="text/javascript">

window.addEventListener('load',function(){

    $("#passModal").modal({
        backdrop: 'static',
        keyboard: false
    });
    $('#passModal').modal('show');


    $("#passKontrol").on('click',function(){

        $overlay = $(this).find('span');
        $overlay.css('display','inline-block');
        $csrf = $("input[name=csrf]").val();
        $slug = "<?=$share['slug']?>";
        $pass = $("input[name=pass]").val();
        $.ajax({
            method:'POST',
            url:"<?=api_url('access-image')?>",
            data:{
                "csrf":$csrf,
                "slug":$slug,
                "password":$pass
            },
            dataType:"json",
            success:(result)=>{
                setTimeout(function(){
                    $overlay.css('display','none');
                },1000);
                if(result.state == 'error'){
                    $("#responseAlert").addClass('alert-danger');
                    $("#responseAlert").html(result.message);
                    $("input[name=pass]").val('');
                }else{

                    if(result.response.comments.totalCount == 0){
                        $("#post_comments").html(result.response.comments.noComment);
                    }else{

                        $("#post_totalComment").append(result.response.comments.totalComment);
                        result.response.comments.data.forEach(comment => {
                            $("#post_comments").append(getComment(comment));
                        });
                    }

                    $("input[name=reportCsrf").val(result.response.token);
                    $("input[name=csrftoken]").val(result.response.token);
                    $("#post_image").attr('src',result.response.images[0].image);
                    $("#post_content").html(result.response.share.content);
                    $("#post_username").html(result.response.share.username);
                    $("#post_container_istatistik").removeClass('d-none');

                    $('#passModal').modal('hide');
                }
            }
        })

    });

    function getComment(data){

        let str = `
                <div class="col item-user  p-2 my-1" style="    font-size: 13px;">
                    <div class="row">
                        <div class="col-2 text-center ">
                            <img src="${data.image}" alt="">
                        </div>
                        <div class="col-10">
                            <div class="user-name"><b>${data.username}</b><time class="float-right">${data.date}</time></div>
                            <div class="user-comment text-break">${data.content}</div>
                        </div>
                    </div>
                </div>
        `;
        return str;
    }

})
        

</script>

<?php endif; ?>




<script>

window.addEventListener('load',function(){



            $("#sendReport").on('click',function(){

                $csrf = $("input[name=reportCsrf").val();
                $content = $("#reportContent").val();
                $shareid = "<?=$share['id']?>";
                $typeid = $("select[name=reportType]").val();

                $that = this;

                $.ajax({
                        method:'POST',
                        url:"<?=api_url('report-image')?>",
                        data:{
                            "csrftoken":$csrf,
                            "id":$shareid,
                            "typeid":$typeid,
                            "content":$content,
                        },
                        dataType:"json",
                        success:function(data){
                            $("#reportStatus").show();
                            if(data.state == 'success'){
                                $($that).hide();
                                $("#reportStatus").html(data.message);
                                $("#reportStatus").addClass('alert-success');
                            }else{
                                $("#reportStatus").html(data.errors);
                                $("#reportStatus").addClass('alert-error');
                            }
                            
                            
                            

                          
                        }
                 });



            });

    
            $('#sendComment').on('click',function(){

                    $csrf = $('input[name=csrftoken]').val();
                    $comment = $('#user-comment').val();
                    $id = "<?=$share['id']?>";
                    $.ajax({
                        method:'POST',
                        url:"<?=api_url('comment-post')?>",
                        data:{
                            "csrf":$csrf,
                            "id":$id,
                            "comment":$comment
                        },
                        dataType:"json",
                        success:function(data){

                            console.log(data);
                            if(data.state == 'success'){
                                $('#user-comment').val(''); 
                                ShowToast(data.message);
                            }else{
                                ShowToast(data.errors);
                            }
                           
                          
                        }
                    });


            });



            <?php if($isLogin):?>



                    $("#post_bookmark").on('click',function(){
                        $csrf = $('input[name=csrftoken]').val();
                        $id = "<?=$share['id']?>";

                        $that = this;
                        $.ajax({
                                method:'POST',
                                url:"<?=api_url('bookmark')?>",
                                data:{
                                    "csrf":$csrf,
                                    "id":$id,
                                },
                                dataType:"json",
                                success:function(data){
                                    if(data.state == 'success'){
                                        if(data.check == "BOOKMARK")
                                            $($that).css('color',"green");
                                        else if(data.check == "NOBOOKMARK")
                                            $($that).css('color','black');
                                        
                                        $val = parseInt($("#post_bookmarkCount").text()) + (data.check == 'BOOKMARK' ? 1 : -1);

                                        $("#post_bookmarkCount").html(  $val ); 
                                    }
                                }
                        });
                    })


                    $("#post_heart").on('click',function(){
                        $csrf = $('input[name=csrftoken]').val();
                        $id = "<?=$share['id']?>";

                        $that = this;
                        $.ajax({
                                method:'POST',
                                url:"<?=api_url('heart')?>",
                                data:{
                                    "csrf":$csrf,
                                    "id":$id,
                                },
                                dataType:"json",
                                success:function(data){
                                    if(data.state == 'success'){
                                        if(data.check == "HEART")
                                            $($that).css('color',"blue");
                                        else if(data.check == "NOHEART")
                                            $($that).css('color','black');

                                        
                                        $val = parseInt($("#post_likesCount").text()) + (data.check == 'HEART' ? 1 : -1);

                                        $("#post_likesCount").html(  $val ); 
                                    }
                                }
                        });
                    })



            <?php endif; ?>


            function ShowToast(message){
                $('.toast').find('.toast-body')[0].innerHTML = message;
                $('.toast').toast('show');
            }


           

});

</script>



