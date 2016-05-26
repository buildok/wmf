<?php
use app\models\Lang;

/**
*login user template page
*@var Form $model object of LoginForm class
*/

$errors = $model->getErrors();
?>

<div class="g-90 ml-5 login-block">
    <form class="" method="POST" novalidate>
        <div class="g-100 form-group">
            <div class="g-20">
                <label class="field-label" for="user_email"><?= $model->getLabel('email') ?></label>
            </div>
            <div class="g-40">
                <input id="user_email" type="email" name="user[email]" value="<?= $model->email ?>"/>
            </div>
        </div>
        <div class="g-100 form-group">
            <div class="g-20">
                <label class="field-label" for="user_password"><?= $model->getLabel('password') ?></label>
            </div>
            <div class="g-40">
                <input id="user_password" type="password" name="user[password]" value=""/>
            </div>
            <div class="g-20 form-control">
                <input type="submit" value="<?= Lang::T('Submit')?>">
            </div>
        </div>
        <div class="g-80 ml-20 error-msg">
            <span><?= $model->getFirstError('login') ?></span>
        </div>
    </form>
</div>