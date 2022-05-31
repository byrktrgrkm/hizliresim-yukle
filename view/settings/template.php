
<style>

    .menu-active{
        color:blue;
    }

    a{
        color:currentColor;
    }
</style>

<div class="container-fluid my-5">
    <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-6">
                <div class="row">
                    <div class="col-12 mx-3 mb-2">
                        <a href="<?=base_url('user/'.session('user')['username'])?>" class="btn btn-outline-secondary">
                            <i class="fas fa-chevron-circle-left"></i>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4 col-md-4">
                        <!--Menüler-->
                        <ul class="nav flex-column ">

                         <?php foreach($menuler as $tag => $menu):?>

                            <li class="nav-item <?=(isset($menu['active']) ? 'menu-active' : '')?>">
                                
                                <a class="nav-link " href="<?=base_url('settings/'.$tag)?>">
                                    <i class="<?=$menu['menu']['icon']?>"></i>
                                    <?=$menu['menu']['name']?>
                                </a>
                            </li>

                         <?php endforeach; ?>
                            
                          </ul>
                    </div>
                    <div class="col-7">
                        <?php echo $data; ?>
                    </div>
                </div>
            </div>
    </div>
</div>

