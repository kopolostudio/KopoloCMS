<?php

/**
* Авторизация пользователей
* работает при помощи PEAR Auth
*
* @version 1.1 / 18.07.2011
* @author kopolo.ru
* @developer Elena Kondrateva [elena@kopolo.ru]
*/

/* PEAR auth */
require_once ('Auth/Auth.php');

class Controller_Users_Auth
{
    public  $template = 'users/auth.tpl'; //объект класса Auth (PEAR)
    
    public  $auth = false; //объект класса Auth (PEAR)
    public  $user;         //объект класса Users (пользователь)
    private $params;       //параметры для Auth (PEAR)
    private $salt = 'e81A4F64dfC4a'; //секретный ключ для записи пароля в COOKIES
    private $expire_period = 2592000; //время хранения кук

    function __construct ($params)
    {
        $user = new Module_Users ();
        
        //параметры по умолчанию
        $default_params = array (
            'table' => $user->__table,
            'usernamecol' => 'us_login',
            'passwordcol' => 'us_password',
            'useractivecol' => 'us_is_active',
            'cryptType' => 'none');
        
        //если входные параметры не пусты, сливаем с параметрами по умолчанию
        if ($params != null) {
            $params = array_merge ($default_params, (array) $params);
        } else {
            $params = $default_params;
        }
        
        Kopolo_Session::initSession();
        
        // Настройки для Auth
        $pear_params = array ('dsn' => KOPOLO_DSN,
                    'table' => $params['table'],
                    'usernamecol' => $params['usernamecol'],
                    'passwordcol' => $params['passwordcol'],
                    'cryptType' => $params['cryptType']);
        $auth = new Auth ('DB', $pear_params, '', false);
        $auth->setSessionname ("UserID");
        $this->auth = $auth;
        $this->parameters = $params;
        
        if (isset ($_REQUEST['logout']))
        {
            $this->logout ();
        } else {
            $this->login ();
        }
        
        Kopolo_Registry::appendTo('content', 'auth', (array)$this->auth);
    }
    
    protected function login()
    { 
        $usernamecol = $this->parameters['usernamecol'];
        $passwordcol = $this->parameters['passwordcol'];
        $useractivecol = $this->parameters['useractivecol'];

        if ($this->loginFromCookies() === false) {
            $this->auth->start ();
            if (!$this->auth->getAuth ()) { 
                if (isset ($_REQUEST['username']) && isset ($_REQUEST['password'])) {
                    Kopolo_Messages::error('Неверный логин или пароль.');
                }
                return false;
            }

            $user = new Module_Users ();
            $user->$usernamecol = $this->auth->getUsername();
            $user->find(true);

            if ($user->$useractivecol != 1) {
                Kopolo_Messages::error('Аккаунт неактивен, вход невозможен.');
                $this->logout ();
                return false;
            }
            $this->auth->user = $user->toArray();
        }

        $this->auth->setAuthData ('users', $this->auth->user);
        
        if (isset($_REQUEST['remember'])) {
            $expire = time()+$this->expire_period;
            setcookie ('login', $this->auth->user[$usernamecol], $expire, '/', false, false, true);
            setcookie ('pass', md5 ($this->auth->user[$passwordcol].$this->salt), $expire, '/', false, false, true);
        }
        return true;
    }

    protected function loginFromCookies()
    {
        $usernamecol = $this->parameters['usernamecol'];
        $passwordcol = $this->parameters['passwordcol'];
        $useractivecol = $this->parameters['useractivecol'];
        
        if (isset ($_COOKIE['login']) && isset($_COOKIE['pass']))
        {
            $username = $_COOKIE['login'];
            $password = $_COOKIE['pass'];

            $user = new Module_Users();
            $user->$usernamecol = $username;
            $user->find(true);

            if ($user->N > 0 && (md5 ($user->$passwordcol.$this->salt) == $password) && $user->$useractivecol == 1) {

                $this->auth->login = $username;
                $this->auth->pass = $user->$passwordcol;
                $this->auth->user = $user->toArray();
                
                return true;
            }
        }
        return false;
    }

    protected function logout()
    {
        $this->auth->start();
        $this->auth->logout();

        setcookie ('login', '', time() - 3600, '/');
        setcookie ('pass', '', time() - 3600, '/');

        $_SESSION['user'] = null;
        
        HTTP::redirect("/");
    }
}
?>