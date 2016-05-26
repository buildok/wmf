<?php
namespace app\base;

use app\base\AppException;
use app\models\Lang;


/**
*  Validator Class 
*/
class Validator
{
    /**
    *@var string[] array of validation errors
    */
    private $errors = [];
    
    /**
    *run validation method
    *@param string $fieldValue attribute value
    *@param string $fieldName attribute name
    *@param string|string[] $fieldRules attribute validation rules
    *@param string $fieldLabel attribute description
    *@throw AppException
    *@return boolean true if validation success, else false
    */
    public function check($fieldValue, $fieldName, $fieldRules, $fieldLabel)
    {   
        $this->clearErrors();
        
        if(!empty($fieldRules)) {
            $args = ['fieldName' => $fieldName, 'fieldValue' => $fieldValue, 'fieldLabel' => $fieldLabel];           
             
            foreach ($fieldRules as $key => $value) {
                $func = 'check';
                
                if(is_int($key)) {
                    $func .= ucfirst($value);
                } else {
                    $func .= ucfirst($key);
                    $args = array_merge($args, $value);
                }

                if(!method_exists($this, $func)) {
                    throw new AppException('Undefined validator: ' . $func);  
                } 
                
                call_user_func_array([$this, $func], [$args]);
            }
        }
        
        return !count($this->getErrors());
    }
    
    /**
    *add new value to $errors
    *@param string $field field name
    *@param string $msg error message
    *@return void
    */
    public function setError($field, $msg)
    {
        $this->errors[$field][] = $msg;
        
    }
    
    /**
    *get validation errors
    *@return string[] $errors
    */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
    *clear $errors
    *@return void
    */
    private function clearErrors()
    {
        $this->errors = [];
    }
    
    
    /**** Validators ***************************/
    
    /**
    *file
    *@param mixed[] $args
    *@example
        $args = [
            'fieldName' =>  // string attribute name
            'fieldValue' => // string attribute value
            'fieldLabel' => // string attribute description
            'maxsize' =>    // int max size of file (Kb)
            'type' =>       // string[] array of file types
        ]
    *@return boolean true if validation success, else false
    */
    protected function checkFile($args)
    {
        $ret = true;
        if(stripos($args['fieldValue'], ';base64')) {
            
            if(isset($args['maxsize'])) {
                $fsize = strlen($args['fieldValue']);
                if($fsize > $args['maxsize'] * 1000) {
                    $msg = Lang::T('Too big file size (maximum ') . $args['maxsize'] . ' Kb)';
                    $this->setError($args['fieldName'], $msg);
                    $ret = false;
                }
            }
            
            if(isset($args['type'])) {
                $t = explode(';', $args['fieldValue']);
                list(, $ext) = explode('/', $t[0], 2);
                
                if(!in_array($ext, $args['type'])) {
                    $msg = implode(' ', [Lang::T('Wrong type of file'), '('.Lang::T('can only'), implode(', ', $args['type']).')']);
                    $this->setError($args['fieldName'], $msg);
                    $ret = false;
                }
            }
        }
        
        return $ret;
    }
    
    /**
    *default
    *@param mixed[] $args
    *@example
        $args = [
            'fieldName' =>  // string attribute name
            'fieldValue' => // string attribute value
            'fieldLabel' => // string attribute description
            'obj' =>        // Model object
            'val' =>        // mixed default value
        ]
    *@return boolean true
    */
    protected function checkDefault($args)
    {
        if($args['fieldValue'] === '') {
            $fn = $args['fieldName'];
            $args['obj']->$fn = $args['val'];
        }
        
        return true;
    }
    
    /**
    *equal
    *@param mixed[] $args
    *@example
        $args = [
            'fieldName' =>  // string attribute name
            'fieldValue' => // string attribute value
            'fieldLabel' => // string attribute description
            'msg' =>        // string error message
            'val' =>        // mixed comparison value
        ]
    *@return boolean true if validation success, else false
    */
    protected function checkEqual($args)
    {
        if($args['fieldValue'] != $args['val']) {
            $this->setError($args['fieldName'], $args['msg']);
            
            return false;
        }
        
        return true;
    }
    
    /**
    *unique
    *@param mixed[] $args
    *@example
        $args = [
            'fieldName' =>  // string attribute name
            'fieldValue' => // string attribute value
            'fieldLabel' => // string attribute description
            'class' =>      // string name of Model class
        ]
    *@throw AppException
    *@return boolean true if validation success, else false
    */
    protected function checkUnique($args)
    {
        try {
            if(!isset($args['class'])) {
                throw new AppException('UNIQUE validator requires specified class');
            }
            
            $model = new $args['class'];
              
            if($model->findOne([$args['fieldName'] => $args['fieldValue']])) {
                $msg = implode(' ', [$args['fieldLabel'], Lang::T('already exists')]);
                $this->setError($args['fieldName'], $msg);
                
                return false;
            }

            return true;
        } catch(AppException $e) {
            $e->getMessage();die;
        }
    }
    
    /**
    *email
    *@param mixed[] $args
    *@example
        $args = [
            'fieldName' =>  // string attribute name
            'fieldValue' => // string attribute value
            'fieldLabel' => // string attribute description
        ]
    *@return boolean true if validation success, else false
    */
    protected function checkEmail($args)
    {
        if(strpos($args['fieldValue'], '@') > 0) {
            list($login, $domain) = explode('@', strtolower($args['fieldValue']), 2);
            
            if(checkdnsrr($domain)) {
                return true;        
            }
        }
        
        $msg = Lang::T('Incorrect e-mail address');
        $this->setError($args['fieldName'], $msg); 
        
        return false;
    }
    
    /**
    *length
    *@param mixed[] $args
    *@example
        $args = [
            'fieldName' =>  // string attribute name
            'fieldValue' => // string attribute value
            'fieldLabel' => // string attribute description
            'min' =>        // int minimum characters
            'max' =>        // int maximum characters
        ]
    *@return boolean true if validation success, else false
    */
    protected function checkLength($args)
    {
        $ret = true;
        if(isset($args['min'])) {
            if(iconv_strlen($args['fieldValue']) < $args['min']) {
                $msg = implode(' ', [$args['fieldLabel'], Lang::T('is too short (minimum'), $args['min'], Lang::T('characters)')]);
                $this->setError($args['fieldName'], $msg);
                
                $ret = false;
            }    
        }
        if(isset($args['max'])) {
            if(iconv_strlen(strval($args['fieldValue'])) > $args['max']) {
                $msg = implode(' ', [$args['fieldLabel'], Lang::T('is too big (maximum'), $args['max'], Lang::T('characters)')]);
                $this->setError($args['fieldName'], $msg);
                
                $ret = false;
            }    
        }
        
        return $ret;
    }
    
    /**
    *required
    *@param mixed[] $args
    *@example
        $args = [
            'fieldName' =>  // string attribute name
            'fieldValue' => // string attribute value
            'fieldLabel' => // string attribute description
        ]
    *@return boolean true if validation success, else false
    */
    protected function checkRequired($args)
    {
        if($args['fieldValue'] === '') { 
            $msg = Lang::T('is required');
            $this->setError($args['fieldName'], $msg);
            
            return false;
        }
        
        return true;
    }
}