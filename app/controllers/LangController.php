<?php
namespace app\controllers;

use app\base\Controller;
use app\models\Lang;

/**
*   LangController Class
*/
class LangController extends Controller 
{
    /**
    *get message with subject language
    *@return json
    */
    public function message()
    {
        if($msg = $this->get('msg')) {
            echo json_encode(['t' => Lang::T($msg)]);
        }
    }
}