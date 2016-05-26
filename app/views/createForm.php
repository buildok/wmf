<?php

use app\models\Lang;

/**
*create user template page
*@var Form $model object of CreateForm class
*/

/**
*set maxlength attribute to input tag
*@param Form $obj object of CreateForm class
*@param string $field field name
*@return string
*/
function attrMaxLength($obj, $field)
{
    $rules = $obj->rules();
    $maxLength = isset($rules[$field]['length']['max']) ? $rules[$field]['length']['max'] : false;
    
    return ($maxLength !== false) ? 'maxlength="' . $maxLength . '"' : '';
}

$errors = $model->getErrors();

?>

<div class="g-90 ml-5 create-block">
    <form class="" method="POST" novalidate>
        <div class="g-100 picture-form">
            <div class="g-20">
                <label class="field-label" for="user_picture"><?= $model->getLabel('picture') ?></label>
            </div>
            <div class="g-15 dest">
                <div>
                    <?php $src = $model->picture ? $model->picture : "/img/default-profile.png"; ?>
                    <img id="preview-image" src="<?= $src ?>" alt="Profile photo" />
                </div>
                <textarea id="user_picture" name="user[picture]" style="display:none;"><?= $model->picture ?></textarea>
            </div>
            <div class="g-60 ml-5 error-msg">
                <span><?= $model->getFirstError('picture') ?></span> 
            </div>
            
            <div class="g-15 ml-5 pict-buttons form-control">
                <label class="g-100 button btn-file" for="btn-upload">
                    <span><?= Lang::T('Upload')?></span>
                    <input type="file" id="btn-upload" />
                </label>
            </div>
            
        </div>
        <div class="g-100 form-group">
            <div class="g-20">
                <label class="field-label" for="user_name"><?= $model->getLabel('username') ?></label>
            </div>
            <div class="g-40">
                <input id="user_name" type="text" name="user[username]" value="<?= $model->username ?>" required <?= attrMaxLength($model, 'username'); ?>/>
            </div>
            <div class="g-40 error-msg">
                <span><?= $model->getFirstError('username') ?></span>
            </div>
        </div>
        <div class="g-100 form-group">
            <div class="g-20">
                <label class="field-label" for="user_email"><?= $model->getLabel('email') ?></label>
            </div>
            <div class="g-40">
                <input id="user_email" type="email" name="user[email]" value="<?= $model->email ?>" required <?= attrMaxLength($model, 'email'); ?>/>
            </div>
            <div class="g-40 error-msg">
                <span><?= $model->getFirstError('email') ?></span>
            </div>
        </div>
        <div class="g-100 form-group">
            <div class="g-20">
                <label class="field-label" for="user_password"><?= $model->getLabel('password') ?></label>
            </div>
            <div class="g-40">
                <input id="user_password" type="password" name="user[password]" value="" required/>
            </div>
            <div class="g-40 error-msg">
                <span><?= $model->getFirstError('password') ?></span>
            </div>
        </div>
        <div class="g-100 form-group">
            <div class="g-20">
                <label class="field-label" for="user_password_repeat"><?= $model->getLabel('password_repeat') ?></label>
            </div>
            <div class="g-40">
                <input id="user_password_repeat" type="password" name="user[password_repeat]" value="" required/>
            </div>
            <div class="g-40 error-msg">
                <span><?= $model->getFirstError('password_repeat') ?></span>
            </div>
        </div>
        <div class="g-20 ml-40 form-control">
            <input type="submit" value="<?= Lang::T('Submit')?>">
        </div>
    </form>
</div>

<!-- modal -->
<div class="dm-overlay" id="crop-modal">
    <div class="dm-table">
        <div class="dm-cell">
            <div class="gblock gb-800 dm-modal">
            	<a href="#" class="close">
            		<span></span><span></span>
            	</a>
                <div class="g-100 dm-body">
                    <div class="preloader">
                        <div class="spinner"><div></div></div>
                    </div>
                    <div class="g-100 source">
                        <div>
                            <img id="source-image" class="source-image" src="/img/default-profile.png" alt="Image" />
                        </div>
                    </div>
                </div>
            	<div class="g-100 dm-footer">
                    <div class="spinner"><div></div></div>
                    <div class="g-40 ml-60 form-control">
                        <input id="btn-crop" type="button" value="<?= Lang::T('crop')?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>