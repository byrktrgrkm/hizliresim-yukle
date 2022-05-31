<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hızlı Resim Yükle</title>
    <link rel="icon" type="image/png" href="<?=base_url('assets/site/icon.png')?>"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <style>

        .border-dotted{
            border:2px dashed  gray;
        }
        .border-select-image{
            border:1px dashed gray;
            padding:72px !important;
            position: relative;
            
        }
        .select-image{
            background:url(<?=get_local_image('select-image.png')?>) no-repeat;
            left:0;top:0;right:0;bottom:0;
            width:100%;
            height:100%;
            position: absolute;
            background-size: contain;
            text-align: center;
            color:gray;
            filter: grayscale(100%);
            background-position: center center;
        }
        

        .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        }

        .switch input { 
        opacity: 0;
        width: 0;
        height: 0;
        }

        .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        }

        .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        }

        input:checked + .slider {
        background-color: #2196F3;
        }

        input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
        border-radius: 34px;
        }

        .slider.round:before {
        border-radius: 50%;
        }

        .bg-custom{
          background-color: #021526!important;
        }

    </style>
</head>
<body>


<header class="bg-custom">
    <div class="container px-5">
        <nav class="navbar navbar-expand-lg navbar-dark py-1 px-2">
            <a class="navbar-brand" href="<?=base_url('index')?>"><img src="<?=base_url('assets/site/icon.png')?>" width="30" style="background-color:white;border-radius:50%;right:3px;background-size: cover;">Hızlı Resim</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
              <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                  <a class="nav-link" href="#">Resim Yükle <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?=base_url('yardim-sss')?>">Yardım</a>
                  </li>
                
              </ul>

              <?php if(session("oturum")):?>

                <div class="position-relative text-light p-3" style="font-size:26px;">
                      <i class="far fa-bell"></i>
                  <!--
                      <div style="position:absolute;right:0px;top:0px;font-size:16px;">
                          <small class="badge badge-pill badge-info">1</small>
                      </div> -->
                </div>
                <div class="text-center" style="height:30px;width:30px;overflow:hidden;">
                        <img src="<?=empty(session('user')['avatar']) ? default_avatar() : avatar_url(session('user')['avatar'])?>" style="background-size:contain;background-position:center center;width:100%;height:100%;" alt="">
                 </div>
                
                    <span class="p-3"> 
                      <a class="text-light " href="<?=base_url('user/'.session('user')['username'])?>">
                        <?=strtoupper(session('user')['username'])?>
                        </a>
                    </span>
                  
                <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                  <a href="<?=base_url('user/'.session('user')['username'])?>">
                  <button class="dropdown-item" type="button">Profili görüntüle</button>
                  </a>
                  <a href="<?=base_url('settings')?>">
                    <button class="dropdown-item" type="button">Hesap Ayarları</button>
                  </a>
                  <a href="<?=base_url('logout?key='.session('user.token'))?>">
                    <button class="dropdown-item" type="button">Çıkış yap</button>
                  </a>
                </div>
              </div>

              <?php else:?>
                <a href="<?=base_url('login')?>">
                  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
                    Giriş Yap
                  </button>
                </a>
              <?php endif; ?>
            </div>
          </nav>
          
      </div>
</header>

