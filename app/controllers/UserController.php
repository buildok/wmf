<?php
namespace app\controllers;


use app\base\WebUser;
use app\base\Controller;

use app\models\User;
use app\models\LoginForm;
use app\models\CreateForm;
use app\models\Lang;


/**
*   UserController Class
*/
class UserController extends Controller 
{
    /**
    *default action
    *@return string html-markup from page template
    */
    public function index()
    {
        return $this->render('index', ['active' => 1]);
    }

    /**
    *user authorization
    *@return string html-markup from page template
    */
    public function login()
    {
        if(WebUser::isGuest()) {
            
            $loginUser = new LoginForm();
            if($userData = $this->post('user')) {
                $loginUser->load($userData);
                
                if($loginUser->validate()) {
                    if($user = User::findOne(['email' => $loginUser->email, 'password' => md5($loginUser->password)])) {
                        WebUser::openSession([
                            'id' => $user->getID(),
                            'username' => $user->username,
                            'email' => $user->email
                        ]);
                        
                        $this->redirect('/');
                    }
                }
                $loginUser->setError(['login' => [Lang::T('Incorrect e-mail or password')]]);
            }
            
            return $this->render('loginForm', ['model' => $loginUser, 'active' => 2]);
        }
        
        $this->redirect('/');
    }
    
    /**
    *user log out
    *@return string html-markup from page template
    */
    public function logout()
    {
        if(!WebUser::isGuest()) {
            WebUser::closeSession();
        }
        
        $this->redirect('/');
    }
    
    /**
    *create new user
    *@return string|json html-markup from page template if http request, if ajax-request return json-obect
    */
    public function create()
    {
        $model = new CreateForm;
        
        if($this->isAjax()) { 
            // AJAX validation
            $model->password = $this->get('pwd');
            $userData = [$this->get('field') => $this->get('val')];
            if($model->load($userData) && $model->validate($this->get('field'))) {

                echo json_encode([
                    'validate' => $model->validate($userData[$this->get('field')]),
                    'field' => $this->get('field'),
                    'val' => $userData[$this->get('field')]
                ]);
                
                die;
            }
            
            header('HTTP/1.0 418 Validation error');     // Response error
            echo $model->getFirstError($this->get('field'));
            
            die;
        } else {

            if($userData = $this->post('user')) {
                $model->load($userData);
                
                if($model->validate()) {
                    $user = new User;
                    $user->load($userData);
                    $user->validate();
                    $user->save();
                    
                    $this->redirect('/');
                }
            }
                
            return $this->render('createForm', ['model' => $model, 'active' => 3]);
        }
    }
    
    /**
    *get authorized user profile page
    *@return string html-markup from page template
    */
    public function profile()
    {
        if(!WebUser::isGuest()) {
            $user = User::findOne(['id' => WebUser::getID()]);
            
            return $this->render('profile', ['model' => $user, 'active' => 4]);
        } else {
            $this->redirect('/');
        }
    }
    
    /**
    *reset language for current user
    *@return string html-markup from page template
    */
    public function language()
    {
        if($lang = $this->get('code')) {
            WebUser::setLanguage($lang);
            
            $ref = '/';
            if(isset($_SERVER['HTTP_REFERER'])) {
                if(strripos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])) {
                    $ref = $_SERVER['HTTP_REFERER'];
                }
            }
            
            return header('Location: '.$ref);
        }
    }
}