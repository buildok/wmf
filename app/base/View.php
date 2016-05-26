<?php
namespace app\base;

/**
*  View Class 
*/
class View
{
    /**
    *get html-markup from template view
    *@param string $template template name
    *@param mixed[] $params array of content data
    *@return string content
    */
    public function getContent($template, $params = [])
    {
        extract($params);
        
        ob_start();
        include ROOT . '/app/views/' . $template . '.php';
        
        return ob_get_clean();
    }
    
    /**
    *get html-markup from template view with layout
    *@param string $layout layout name
    *@param string $template template name
    *@param mixed[] $params array of content data
    *@return string content
    */
    public function render($layout, $template, $params = [])
    {
        $content = $this->getContent($template, $params);
        $params = array_merge($params, ['content' => $content]);
        
        echo $this->getContent($layout, $params);
    }
}