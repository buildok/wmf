<?php
namespace app\base;

use app\base\Validator;
use app\base\AppException;

/**
*  Form Class 
*/
class Form 
{
    /**
    *@var string[] $attributes array of public attribute names
    */
    protected $attributes = [];
    
    /**
    *@var string[] $errors array of validation errors 
    */
    protected $errors = [];
    
    /**
    *validation rules
    *@example 
        return [
            'field name' => [
                'validator name',
                ...
                'validator name' => [
                    'parameter' => 'value',
                    ...
                ],
            ],
            ...
        ];
    *@see class app\base\Validator
    *@return mixed[] rules array
    */
    public function rules()
    {
        return [];
    }
    
    /**
    *field labels
    *@example
        return [
            'field name' => 'field description',
            ...
        ]
    *@return string[] array of field labels
    */
    public function labels()
    {
        return [];
    }
    
    /**
    *sets $attributes
    *@return string[] $attributes
    */
    public function getAttributes()
    {
        $reflect = new \ReflectionObject($this);
        $publicFields = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        
        $this->attributes = [];
        foreach ($publicFields as $key => $item) {
            $this->attributes[] = $item->name;
        }
        
        return $this->attributes;
    }
    
    /**
    *get field description or field name, if description undefined
    *@param string $field field name
    *@return string
    */
    public function getLabel($field)
    {
        $array = $this->labels();
        return isset($array[$field]) ? $array[$field] : $field;
    }
    
    /**
    *use validation rules
    *@param string $field field name
    *@return boolean true if validation success, else false
    */
    public function validate($field = false)
    {
        $rules = $this->rules();

        if(!empty($rules)) {
            $validator = new Validator();
            
            foreach($rules as $fieldName => $fieldRules) {
                if($field && $field != $fieldName) {
                    continue;
                }
                
                try {
                    if(!$validator->check($this->$fieldName, $fieldName, $fieldRules, $this->getLabel($fieldName))) {
                        $this->setError($validator->getErrors());
                    }
                    
                } catch(AppException $e) {
                    
                    echo $e->getMessage();die;
                }
            }           
        }
        
        return !count($this->getErrors());        
    }
    
    /**
    *add value to $errors
    *@param string[] $errors array of current validation getErrors
    *@return void
    */
    public function setError($errors = [])
    {
        if(!empty($errors)) {
            $this->errors = array_merge($this->errors, $errors);
        }
    }
    
    /**
    *return validation errors
    *@param string $field field name
    *@return string[] array of validation errors*/
    public function getErrors($field = false)
    {
        if($field) {
            return isset($this->errors[$field]) ? $this->errors[$field] : '';
        }
        
        return $this->errors;
    }
    
    /**
    *return first validation error
    *@param string $field field name
    *@return string
    */
    public function getFirstError($field)
    {
        $errors = $this->getErrors($field);
        
        return isset($errors[0]) ? $errors[0] : '';
    }
    
    /**
    *sets public attributes to new values from array
    *@param mixed[] $data array of values
    *@return boolean true if success sets values, else false
    */
    public function load($data = [])
    {
        $reflect = new \ReflectionObject($this);
        $publicFields = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);

        $ret = false;
        foreach($publicFields as $key => $field) {
            $prop = $field->getName();
            
            if(isset($data[$prop])) {
                $this->$prop = htmlspecialchars(trim($data[$prop]));
                $ret = $ret || true;
            }
        }            
        
        return $ret;
    }

}