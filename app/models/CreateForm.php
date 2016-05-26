<?php
namespace app\models;

use app\base\Form;
use app\models\User;
use app\models\Lang;

/**
*   CreateForm Class
*/
class CreateForm extends Form
{   
    /**@var string $username*/
    public $username;
    /**@var string $password*/
    public $password;
    /**@var string $password_repeat*/
    public $password_repeat;
    /**@var string $email*/
    public $email;
    /**@var string $picture*/
    public $picture;
    
    
    /**
    *validation rules
    *@return mixed[] array of rules
    */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'length' => [
                    'min' => 4,
                    'max' => 150
                ],
            ],
            'password' => [
                'required',
                'length' => [
                    'min' => 6
                ],
            ],
            'password_repeat' => [
                'required',
                'equal' => [
                    'val' => $this->password,
                    'msg' => Lang::T('Passwords are not equal')
                ],
            ],
            'email' => [
                'required',
                'email',
                'length' => [
                    'max' => 45
                ],
                'unique' => [
                    'class' => User::className(),
                ]
            ],
            'picture' => [
                'file' => [
                    'maxsize' => 1024,
                    'type' => ['png', 'gif', 'jpeg'],
                ]
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
            'username' => Lang::T('Name'),
            'email' => Lang::T('E-mail'),
            'picture' => Lang::T('Photo'),
            'password' => Lang::T('Password'),
            'password_repeat' => Lang::T('Repeat password')
        ];
    }
}