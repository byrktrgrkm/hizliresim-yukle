

<div class="container-fluid">

<div class="row justify-content-center m-4">

    <div class="col-12 col-md-6">
        
        <div class="row flex-column align-items-center">
            <?php if($userProfile['auth']): ?>
                <div class="position-absolute" style="right:0;">
                    <a class="btn btn-outline-secondary" href="<?=base_url('settings')?>">Profili Düzenle</a>
                </div>
            <?php endif; ?>
            
            <div class="position-relative">
                <img style="border-radius: 50%;overflow: hidden;"  height="100" width="100" src="<?=$userProfile['avatar']?>">
                
                <?php if(session('oturum')): ?>

                <li class="nav-item dropdown position-absolute" style="right:-40px;bottom:-10px;list-style-type:none;">
                        <a class="nav-link dropdown-toggle text-dark" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-flag"></i>
                        </a>
                        <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Profil fotoğrafını şikayet et!</a>
                        <a class="dropdown-item" href="#">Kullanıcı adını şikayet et!</a>
                        <a class="dropdown-item" href="#">Profili şikayet et!</a>
                </li>

                <?php endif; ?>
                
            </div>
            <div class="p-3">
              
                <h4><?=$userProfile['name']?></h4>

            </div>

            <nav class="navbar navbar-expand navbar-light bg-light">
               
               
                  <div class="navbar-nav">
                    <?php foreach($menuler as $url => $menu): ?>
                        <a class="nav-item nav-link <?=(isset($menu['active']) ? 'active' : '')?>" href="<?=('?tab='.$url)?>">
                        <i class="<?=$menu['menu']['icon']?>"></i>
                        <?=$menu['menu']['name']?>
                        </a>
                    <?php endforeach; ?>
                  </div>
                
              </nav>
        </div>
       
    </div>

    <div class="col-12 col-md-8">

        <?=$data?>
    </div>
    
</div>


</div>