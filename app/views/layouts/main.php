<?php

use app\base\WebUser;
use app\models\Lang;

/**
*layout template
*@var integer $active number of current page
*/
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/components/grid/grid.css">
    <link rel="stylesheet" href="/components/cropper/stylesheets/cropper.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/modal.css">
    <link rel="stylesheet" href="/css/spinner.css">
    
    <title></title>
</head>
<body>
    <div class="wrapper">
        <div class="gblock header">
            <div class="gblock gb-800 main-menu">
                <div class="menu-item <?= ($active == 1) ? 'active' : '';?>">
                    <a href="/"><span><?= Lang::T('home')?></span></a>
                </div>
                <?php if(WebUser::isGuest()): ?>
                    <div class="menu-item <?= ($active == 2) ? 'active' : '';?>">
                        <a href="/user/login"><span><?= Lang::T('login')?></span></a>
                    </div>
                    <div class="menu-item <?= ($active == 3) ? 'active' : '';?>">
                        <a href="/user/create"><span><?= Lang::T('registration')?></span></a>
                    </div>
                <?php else: ?>
                    <div class="menu-item">
                        <a href="/user/logout"><span><?= Lang::T('logout')?></span></a>
                    </div>
                    <div class="menu-item <?= ($active == 4) ? 'active' : '';?>">
                        <a href="/user/profile"><span><?= Lang::T('profile')?></span></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="content">
        <div class="gblock gb-1024 ">
            <?= $content ?>
        </div>
        </div>

        <div class="gblock footer">
            <div class="gblock gb-800 footer-menu">
                <div class="g-30 copyright">
                    <span>development & design by </span>
                    <a href="mailto:buildok@mail.ru" target="_blanc">buildok</a>
                </div>
                <div class="g-20 ml-80 language">
                    <div class="g-40 label">
                        <span><?= Lang::T('language')?></span>
                    </div>
                    <?php $lang = WebUser::getLanguage(); ?>
                    <ul class="g-60 list">
                        <li class="<?= ($lang == 'en') ? 'active' : '';?>"><a href="/user/language?code=en"><span>english</span></a></li>
                        <li class="<?= ($lang == 'uk') ? 'active' : '';?>"><a href="/user/language?code=uk"><span>українська</span></a></li>
                        <li class="<?= ($lang == 'bg') ? 'active' : '';?>"><a href="/user/language?code=bg"><span>български</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/components/cropper/javascripts/cropper.js"></script>
    <script src="/js/script.js"></script>
</body>
</html>