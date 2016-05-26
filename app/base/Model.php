<?php
namespace app\base;

use app\base\Form;
use app\base\AppException;

/**
*  Model Class 
*/
class Model extends Form
{
    /**
    *@var boolean true if is new record, else false
    */
    protected $bNew;
    
    public function __construct($obj = false) 
    {
        if(!$obj) {
            $query = 'SHOW COLUMNS FROM ' . $this->getTable();
            $this->bNew = true;
            
            try {
                $mysqli = $this->setConnection();
                
                if(!$res = $mysqli->query($query)) {
                    throw new AppException($mysqli->error);
                }
                
                while($row = $res->fetch_assoc()) {
                    $fieldName = $row['Field'];
                    $this->$fieldName = NULL;
                }
            } catch(AppException $e) {
                
                echo $e->getMessage();die;
            }
                            
        } else {
            $this->bNew = false;
        }
    }
    
    /**
    *get table name for this class
    *@return string table name
    */
    public static function getTable()
    {
        $cn = explode('\\', self::className());
        
        return strtolower(end($cn));
    }
    
    /**
    *get name of this class
    *@return string class name*/
    public static function className()
    {
        $reflect = new \ReflectionClass(get_called_class());
        
        return $reflect->getName();
    }
    
    
    
    /**
    *get array of objects this class
    *@param string[] $params select conditions
    *@example
        $params = [
        'fieldName1' => $fieldValue1,
        'fieldName2' => $fieldValue2,
            .....
        ]
        It is converted to 'WHERE fieldName1=fieldValue1 AND fieldName2=fieldValue2 .. '
    *@return Model[] array of objects this class
    */
    public static function find($params)
    {  
        $query_templ = ['SELECT', '*', 'FROM', self::getTable()];
        try {
            $mysqli = self::setConnection();    
            if(!empty($params)) {
                
                foreach($params as $field => $value) {
                    $val = '"' . $mysqli->escape_string($value) . '"';
                    $where_templ[] = implode([$field, '=', $val]);
                }

                $query_templ[] = 'WHERE';
                $query_templ[] = implode(' AND ', $where_templ);
            }
            
            $query = implode(' ', $query_templ);
            
            $ret = [];
            if(!$res = $mysqli->query($query)) {
                throw new AppException($mysqli->error);
            }
            
            while($obj = $res->fetch_object(self::className(), [true])) {
                $ret[] = $obj;
            }
        } catch(AppException $e) {
            
            echo $e->getMessage();die;
        }

        return !empty($ret) ? $ret : false;
    }
    
    /**
    *get object of this class
    *@param array $params select conditions
    *@return Model object of this class
    */
    public static function findOne($params)
    {
        if($res = self::find($params)) {
            return reset($res);
        }   
        
        return false;
    }
    
    /**
    *insert (or update if exist) attributes of this class to database
    *@throw AppException
    *@return boolean true if success, else false
    */
    public function save()
    {
        $fields = $this->getAttributes();
        $values = [];
        try {
            $mysqli = self::setConnection();
           
            if(!$this->bNew) {
                
                foreach($fields as $key => $fieldName) {
                    $values[] = $fieldName . '=' . '"' . $mysqli->escape_string($this->$fieldName) . '"';
                }
                
                $query_templ = ['UPDATE', self::getTable(), 'SET', implode(', ', $values), 'WHERE', 'id='.$this->id];
            } else {
                
                foreach ($fields as $key => $fieldName) {
                    $values[] = '"' . $mysqli->escape_string($this->$fieldName) . '"';
                }
                
                $query_templ = ['INSERT', 'INTO', self::getTable(), '('. implode(', ', $fields) .')', 'VALUES', '('. implode(', ', $values) .')'];
            }
            
            $query = implode(' ', $query_templ);
        
            if(!$mysqli->query($query)) {
                throw new AppException($mysqli->error);
            } 
            
            if($this->bNew) {
                $this->id = $mysqli->insert_id;
                $this->bNew = false;
            }

            return true;
        } catch(AppException $e) {
            
            echo $e->getMessage();die;
            return false;
        }
    }
    
    /**
    *get value of bNew
    *@return boolean $bNew value*/
    public function isNewRecord()
    {
        return $this->bNew;
    }
    
    /**
    *set connection to database
    *@throw AppException
    *@return mysqli MySQLi object
    */
    private function setConnection()
	{
        $config = require(ROOT . '/app/config/config.php');
        $db = $config['db'];
        
		$mysqli = new \mysqli($db['host'], $db['user'], $db['password'], $db['scheme']);		
		
        if($mysqli->connect_errno) {
            throw new AppException($mysqli->connect_error);
        }
        
        $mysqli->set_charset('utf8');

		return $mysqli;		
	}
}

