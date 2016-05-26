<?php
use app\models\Lang;

/**
*main page template
*/
?>

<div class="gblock gd-1024">
    <h1><span><?= Lang::T('Implementing MVC-pattern without using php-frameworks') ?></span></h1>
    <ul><span><?= Lang::T('and') ?></span>
        <li><span><?= Lang::T('registration and login/logout user')?></span></li>
        <li><span><?= Lang::T('client and server validation')?></span></li>
        <li><span><?= Lang::T('support sessions and cookies')?></span></li>
        <li><span><?= Lang::T('multi-language interface')?></span></li>
    </ul>
    
    <p><a href="https://github.com/buildok/wmf" target="_blanc"><?= Lang::T('View the Project on GitHub') ?></a></p>
</div>