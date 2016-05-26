$(document).ready(function() {
  
   var crop = new CropperObj({
        mime: 'image/jpeg',
        aspectRatio: 1,
        fixed: true,
        srcIMG: '#source-image',
    });
    
    $('#btn-upload').on('change', '', {'crop':crop}, onLoadFile);
    $('#btn-crop').on('click', '', {'crop':crop}, onCropImage);
    
    $('#user_name').on('blur', '', {field:'username'}, onValidation);
    $('#user_email').on('blur', '', {field:'email'}, onValidation);
    $('#user_password').on('blur', '', {field:'password'}, onValidation);
    $('#user_password_repeat').on('blur', '', {field:'password_repeat'}, onValidation);
});

function onValidation(e)
{
    var obj = e.target;
    e.data.val = $(obj).val();
    e.data.pwd = $('#user_password').val();
    
    $.ajax({
        type: 'GET',
        url: '/user/create',
        data: e.data,
        dataType: 'json',
        success: function(data) {
            console.log('success:', data);
            $(obj).closest('.form-group').find('.error-msg span').text('');
        },
        error: function(data) {
            if(data.status == 418) {
                console.log('error:', data);
                
                $(obj).closest('.form-group').find('.error-msg span').text(data.responseText);
            }
        }
    });
}

function onLoadFile(e) 
{    
    if(this.files && this.files[0]) {
        var file = this.files[0];
        var types = ['gif', 'png', 'jpeg'];
        var ftype = file.type.split('/');
        
        if(types.indexOf(ftype[1]) == -1) {
            
            setError($('.picture-form .error-msg'), 'Wrong type of file');
        } else {
            $('.picture-form .error-msg span').text('');
            
            $('#crop-modal .dm-body').addClass('preload');
            window.location.href = '#crop-modal';
            
            var crop = e.data.crop;
            var reader = new FileReader();
            
            reader.onerror = function(e) {
                console.error("FR error:" + e.target.error);
            };

            reader.onload = function (e) {
                $('#crop-modal .dm-body').removeClass('preload');
                $('#source-image').attr('src', e.target.result);
                
                crop.reset({fixed: true});           
            }
            
            reader.readAsDataURL(file);
        }        
    }
}

function onCropImage(e)
{
    var crop = e.data.crop;
    
    $('#crop-modal .dm-footer').addClass('preload');
    
    crop.onCrop(function() {
        $('#preview-image').attr('src', crop.dataURL);
        
        $('#user_picture').val(crop.dataURL);
        $('#crop-modal .dm-footer').removeClass('preload');
        
        window.location.href = '#';
    });
}

function setError(obj, msg)
{
    $.ajax({
        type: 'GET',
        url: '/lang/message',
        data: {'msg':msg},
        dataType: 'json',
        success: function(data) {
            $(obj).find('span').text(data.t);
        },
        error: function(data) {
            console.log(data);
        }
    });
}