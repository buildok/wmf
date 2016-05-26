<?php
use app\models\Lang;


/**
*user profile template page
*@var Model $model object of User class
*/
?>

<div class="g-70 ml-15 profile-block">
        <div class="g-20 picture-form">
            <div class="g-100 dest">
                <img id="preview-image" src="<?= $model->picture ?>" alt="Profile photo" />
            </div>
        </div>
        <div class="g-80 ml-10">
            <div class="g-100 form-group">
                <div class="g-30">
                    <label class="field-label" for="user_id"><?= $model->getLabel('id') ?></label>
                </div>
                <div class="g-70">
                    <input id="user_id" type="text" name="user[email]" value="<?= $model->getID() ?>" readonly />
                </div>   
            </div>
            <div class="g-100 form-group">
                <div class="g-30">
                    <label class="field-label" for="user_name"><?= $model->getLabel('username') ?></label>
                </div>
                <div class="g-70">
                    <input id="user_name" type="text" name="user[username]" value="<?= $model->username ?>" readonly />
                </div>
                
            </div>
            <div class="g-100 form-group">
                <div class="g-30">
                    <label class="field-label" for="user_email"><?= $model->getLabel('email') ?></label>
                </div>
                <div class="g-70">
                    <input id="user_email" type="email" name="user[email]" value="<?= $model->email ?>" readonly />
                </div>
                
            </div>
            <div class="g-100 form-group">
                <div class="g-30">
                    <label class="field-label" for="user_cdate"><?= $model->getLabel('cdate') ?></label>
                </div>
                <div class="g-70">
                    <input id="user_cdate" type="text" name="user[email]" value="<?= date('d.m.Y', $model->cdate) ?>" readonly />
                </div>
            </div>
       </div>
</div>
