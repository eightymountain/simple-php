<?php

namespace Lib;

class Auth
{
    private const REDIRECT_PATH = '/login';
    private const SESSION_MAIN_KEY = 'auth';
    private const USER_ID = 'userid';

    public static function login(array $user)
    {
        $_SESSION[self::SESSION_MAIN_KEY] = $user;
    }

    public static function logout()
    {
        session_destroy();
    }

    public static function me($key = null)
    {
        self::check();

        if($key){
            return $_SESSION[self::SESSION_MAIN_KEY][$key] ?? '';
        }

        return $_SESSION[self::SESSION_MAIN_KEY];
    }

    public static function check($redirectIfNotAuthenticated = true)
    {
        if ( ! isset($_SESSION[self::SESSION_MAIN_KEY])) {
            $state = false;
        } elseif ( ! isset($_SESSION[self::SESSION_MAIN_KEY][self::USER_ID])) {
            $state = false;
        } elseif (empty($_SESSION[self::SESSION_MAIN_KEY][self::USER_ID])) {
            $state = false;
        } else {
            $state = true;
        }
        if ( ! $state && $redirectIfNotAuthenticated) {
            if(headers_sent()){
                echo '<script>location.href="'.self::REDIRECT_PATH.'"</script>';
                exit;
            }
            exit(header('Location: ' . self::REDIRECT_PATH));
        }
        return $state;
    }

    public static function pwd($pwd)
    {
        return hash('sha256', $pwd);
    }
}