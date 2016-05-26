<?php
namespace app\models;

use app\base\Model;
use app\models\Lang;

const PICTURE_DEFAULT = '/img/default-profile.png';

/**
*   User Class
*/
class User extends Model
{   
    /**@var integer $id primary key*/
    protected $id;
    
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
            'email' => [
                'required',
                'email',
                'length' => [
                    'max' => 45
                ],
                'unique' => [
                    'class' => $this->className(),
                ]
            ],
            'picture' => [
                'default' => [
                    'obj' => $this,
                    'val' => PICTURE_DEFAULT,
                ],
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
            'id' => 'ID',
            'username' => Lang::T('Name'),
            'email' => Lang::T('E-mail'),
            'picture' => Lang::T('Photo'),
            'cdate' => Lang::T('Registration date'),
            'password' => Lang::T('Password')
        ];
    }
    
    /**
    *get id record
    *@return integer $id
    */
    public function getID()
    {
        return $this->id;
    }
    
    /**
    *insert or update record
    *@return boolean true if success, else false
    */
    public function save()
    {
        if($this->isNewRecord()) {
            $this->cdate = time();
            $this->password = md5($this->password);
        }
        
        $file = $this->picture;
        if(stripos($file, ';base64')) {
            $this->picture = '';
            
            if(parent::save()) {
                $raw = file_get_contents($file);

                $filename = 'uploads/' . $this->id . '_profile.jpg';
                if(file_put_contents($filename, $raw) === false) {die;}
                
                $this->picture = '/'.$filename;
            }
        } 
        
        return parent::save();
    }
}