<?php
namespace app\models;

use app\base\Form;
use app\models\Lang;

/**
*   LoginForm Class
*/
class LoginForm extends Form
{   
    /**@var string $email*/
    public $email;
    /**@var string $password*/
    public $password;
    
    public function __construct()
    {
        $this->email = '';
        $this->password = '';
    }
    
    /**
    *validation rules
    *@return mixed[] array of rules
    */
    public function rules()
    {
        return [
            'password' => [
                'required',
            ],
            'email' => [
                'required',
            ],
        ];
    }
    
    /**
    *fields label
    *@return string[] array of fields label
    */
    public function labels()
    {
        return [
            'email' => Lang::T('E-mail'),
            'password' => Lang::T('Password')
        ];
    }
    
}